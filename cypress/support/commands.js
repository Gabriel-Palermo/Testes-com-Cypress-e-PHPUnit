
import ProdutosPage from "./pages/ProdutosPage";
import ClientesPage from "./pages/ClientesPage";

Cypress.Commands.add("criarProduto", (dados) => {
  ProdutosPage.visitar();
  ProdutosPage.preencher(dados);
  ProdutosPage.salvar();

  cy.url().should("include", "/produtos");
});

Cypress.Commands.add("criarCliente", (dados) => {
  ClientesPage.visitar();
  ClientesPage.preencher(dados);
  ClientesPage.salvar();

  cy.url().should("include", "/clientes");
});
