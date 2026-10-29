
describe("Sistema da Confeitaria", () => {
  const paginas = [
    { nome: "Dashboard", rota: "/" },
    { nome: "Clientes", rota: "/clientes" },
    { nome: "Produtos", rota: "/produtos" },
    { nome: "Pedidos", rota: "/pedidos" },
    { nome: "Entregas", rota: "/entregas" },
  ];

  paginas.forEach(({ nome, rota }) => {
    it(`deve abrir a página de ${nome}`, () => {
      cy.visit(rota);
      cy.location("pathname").should("eq", rota);
      cy.get("body").should("be.visible").and("not.be.empty");
    });
  });
});

describe("Cadastros com fixtures", () => {
  it("deve cadastrar um produto usando fixture", () => {
    cy.fixture("produto").then((produto) => {
      cy.criarProduto(produto);
      cy.contains(produto.name).should("be.visible");
    });
  });

  it("deve cadastrar um cliente usando fixture", () => {
    cy.fixture("cliente").then((cliente) => {
      cy.criarCliente(cliente);
      cy.contains(cliente.name).should("be.visible");
    });
  });
  it("não deve cadastrar produto sem nome", () => {
    cy.fixture("produto").then((produto) => {
      cy.visit("/produtos/create");

      cy.get('[data-cy="produto-categoria"]').select(produto.category);
      cy.get('[data-cy="produto-descricao"]').type(produto.description);
      cy.get('[data-cy="produto-preco"]').type(String(produto.price));
      cy.get('[data-cy="produto-estoque"]').type(String(produto.stock));
      cy.get('[data-cy="produto-estoque-minimo"]')
        .type(String(produto.minimum_stock));

      cy.get('[data-cy="salvar-produto"]').click();

      cy.get('[data-cy="produto-nome"]')
        .should("have.value", "")
        .and("be.visible");

      cy.location("pathname").should("eq", "/produtos/create");
    });
  });
});
