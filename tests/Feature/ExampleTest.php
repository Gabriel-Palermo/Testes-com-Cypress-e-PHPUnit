<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(
            \Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class
        );
    }

    public function test_home_page_returns_successful_response(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_module_pages_return_successful_response(): void
    {
        $this->get('/produtos')->assertStatus(200);
        $this->get('/clientes')->assertStatus(200);
        $this->get('/pedidos')->assertStatus(200);
        $this->get('/entregas')->assertStatus(200);
    }

    public function test_nonexistent_page_returns_404(): void
    {
        $this->get('/pagina-que-nao-existe')->assertNotFound();
    }

    public function test_product_page_displays_registered_product(): void
    {
        $product = Product::create([
            'name' => 'Bolo de Chocolate',
            'category' => 'Bolos',
            'price' => 35.00,
            'stock' => 10,
            'minimum_stock' => 2,
            'active' => true,
        ]);

        $this->get('/produtos')
            ->assertOk()
            ->assertSee('Produtos e estoque')
            ->assertSee($product->name);
    }

    public function test_product_can_be_created(): void
    {
        $response = $this->post('/produtos', [
            'name' => 'Brigadeiro',
            'category' => 'Doces',
            'price' => 3.50,
            'stock' => 20,
            'minimum_stock' => 5,
            'active' => '1',
        ]);

        $response->assertRedirect(route('produtos.index'));

        $this->assertDatabaseHas('products', [
            'name' => 'Brigadeiro',
            'category' => 'Doces',
        ]);
    }

    public function test_product_validation_rejects_missing_name_and_negative_price(): void
    {
        $response = $this->from('/produtos/create')->post('/produtos', [
            'name' => '',
            'category' => 'Bolos',
            'price' => -5,
            'stock' => 10,
            'minimum_stock' => 2,
        ]);

        $response->assertRedirect('/produtos/create')
            ->assertSessionHasErrors(['name', 'price']);

        $this->assertDatabaseCount('products', 0);
    }

    public function test_product_price_can_be_updated(): void
    {
        $product = Product::create([
            'name' => 'Bolo Simples',
            'category' => 'Bolos',
            'price' => 20.00,
            'stock' => 10,
            'minimum_stock' => 2,
            'active' => true,
        ]);

        $response = $this->put("/produtos/{$product->id}", [
            'name' => $product->name,
            'category' => $product->category,
            'price' => 25.00,
            'stock' => $product->stock,
            'minimum_stock' => $product->minimum_stock,
            'active' => '1',
        ]);

        $response->assertRedirect(route('produtos.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'price' => 25.00,
        ]);
    }

    public function test_customer_can_be_created(): void
    {
        $response = $this->post('/clientes', [
            'name' => 'Maria da Silva',
            'email' => 'maria@example.com',
            'phone' => '41999999999',
            'address' => 'Rua das Flores, 10',
            'city' => 'Curitiba',
        ]);

        $response->assertRedirect(route('clientes.index'));

        $this->assertDatabaseHas('customers', [
            'name' => 'Maria da Silva',
            'email' => 'maria@example.com',
        ]);
    }

    public function test_customer_can_be_deleted(): void
    {
        $customer = Customer::create([
            'name' => 'Cliente para excluir',
            'email' => 'excluir@example.com',
        ]);

        $response = $this->delete("/clientes/{$customer->id}");

        $response->assertRedirect(route('clientes.index'));

        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);
    }

    public function test_order_creation_deducts_product_stock(): void
    {
        $customer = Customer::create([
            'name' => 'João',
        ]);

        $product = Product::create([
            'name' => 'Coxinha',
            'category' => 'Salgados',
            'price' => 5.00,
            'stock' => 10,
            'minimum_stock' => 2,
            'active' => true,
        ]);

        $response = $this->post('/pedidos', [
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 3,
            'status' => 'pending',
        ]);

        $response->assertRedirect(route('pedidos.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 7,
        ]);

        $this->assertDatabaseHas('orders', [
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 3,
        ]);
    }

    public function test_order_with_insufficient_stock_is_rejected(): void
    {
        $customer = Customer::create([
            'name' => 'Ana',
        ]);

        $product = Product::create([
            'name' => 'Torta',
            'category' => 'Bolos',
            'price' => 40.00,
            'stock' => 2,
            'minimum_stock' => 1,
            'active' => true,
        ]);

        $response = $this->from('/pedidos/create')->post('/pedidos', [
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'quantity' => 5,
            'status' => 'pending',
        ]);

        $response->assertRedirect('/pedidos/create')
            ->assertSessionHasErrors('quantity');

        $this->assertDatabaseCount('orders', 0);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 2,
        ]);
    }
}