# Refatoração dos testes Cypress — A2

## Problemas encontrados e soluções

| Problema identificado | Solução aplicada |
|---|---|
| Seletores e interações repetidos nos comandos de cadastro | Criação de Page Objects para centralizar os seletores e as ações de produtos e clientes. |
| Passos de cadastro repetidos nos testes | Criação dos comandos personalizados `cy.criarProduto()` e `cy.criarCliente()`. |
| Dados de teste escritos diretamente nos testes | Criação das fixtures `produto.json` e `cliente.json`. |
| Falta de reutilização dos dados de teste | Uso de `cy.fixture()` nos cenários de cadastro. |
| Falta de cobertura da validação de cadastro | Criação de teste para verificar que um produto sem nome não seja cadastrado. |
| Risco de testes instáveis por esperas fixas | Uso das verificações e esperas automáticas do Cypress, sem `cy.wait()` com tempo fixo. |

## Organização criada

- `cypress/e2e/confeitaria.cy.js`: testes de navegação e cadastro.
- `cypress/fixtures/produto.json`: dados de teste de produtos.
- `cypress/fixtures/cliente.json`: dados de teste de clientes.
- `cypress/support/pages/ProdutosPage.js`: ações e seletores de produtos.
- `cypress/support/pages/ClientesPage.js`: ações e seletores de clientes.
- `cypress/support/commands.js`: comandos personalizados reutilizáveis.

## Validação

Os testes Cypress foram executados e passaram após as alterações. A suíte também passou em três execuções consecutivas antes da inclusão do último cenário de validação.

**Observação:** repetir as três execuções após todas as alterações finais para confirmar a estabilidade da suíte.
