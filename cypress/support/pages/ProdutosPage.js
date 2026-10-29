
class ProdutosPage {
  visitar() {
    cy.visit("/produtos/create");
  }

  preencher(dados) {
    cy.get('[data-cy="produto-nome"]').type(dados.name);
    cy.get('[data-cy="produto-categoria"]').select(dados.category);
    cy.get('[data-cy="produto-descricao"]').type(dados.description);
    cy.get('[data-cy="produto-preco"]').type(String(dados.price));
    cy.get('[data-cy="produto-estoque"]').clear().type(String(dados.stock));
    cy.get('[data-cy="produto-estoque-minimo"]')
      .clear()
      .type(String(dados.minimum_stock));

    if (dados.active) {
      cy.get('[data-cy="produto-ativo"]').check();
    } else {
      cy.get('[data-cy="produto-ativo"]').uncheck();
    }
  }

  salvar() {
    cy.get('[data-cy="salvar-produto"]').click();
  }
}

export default new ProdutosPage();
