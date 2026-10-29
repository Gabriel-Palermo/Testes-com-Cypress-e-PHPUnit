# Doce Gestão

Projeto didático de uma confeitaria desenvolvido com Laravel 13, Blade, Docker Compose e MySQL, com testes automatizados utilizando PHPUnit e Cypress.

## Executando com Docker

Requisitos: Docker Desktop/OrbStack em execução.

```bash
./docker/install.sh
./docker/start.sh
```

Acesse http://localhost:8000.

Para acompanhar os logs:

```bash
docker compose logs -f app
```

O script de instalação configura a chave da aplicação, executa as migrations e insere dados de exemplo. O banco MySQL fica persistido no volume `mysql_data`.

## Módulos para explorar

- **Produtos e estoque:** categorias, preços, estoque mínimo e alerta visual de estoque baixo.
- **Clientes:** dados de contato e endereço.
- **Pedidos/vendas:** seleção de cliente e produto, status, validação de estoque e baixa automática na criação.
- **Fretes/entregas:** pedido, endereço, taxa, data prevista, rastreio e status.

Cada módulo possui listagem paginada e operações de criação, edição e exclusão. As regras ficam nos controllers e as tabelas são definidas por migrations.

## Testes automatizados

### PHPUnit

Executa os testes unitários e de funcionalidades do Laravel.

```bash
docker compose exec app php artisan test
```

### Cypress

Executa os testes end-to-end da aplicação.

```bash
npx cypress run
```

Os testes verificam a navegação pelos módulos principais da aplicação.

### Resultados dos testes

- **PHPUnit:** 2 testes aprovados.
- **Cypress:** 5 testes aprovados.
- **Total:** 7 testes aprovados nas últimas execuções.

## Desenvolvimento local sem Docker

Com PHP e Composer instalados:

```bash
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

Para executar os testes PHPUnit:

```bash
php artisan test
```
