
class ClientesPage {
  visitar() {
    cy.visit("/clientes/create");
  }

  preencher(dados) {
    cy.get('[data-cy="cliente-nome"]').type(dados.name);

    if (dados.email) {
      cy.get('[data-cy="cliente-email"]').type(dados.email);
    }

    if (dados.phone) {
      cy.get('[data-cy="cliente-telefone"]').type(dados.phone);
    }

    if (dados.address) {
      cy.get('[data-cy="cliente-endereco"]').type(dados.address);
    }

    if (dados.city) {
      cy.get('[data-cy="cliente-cidade"]').type(dados.city);
    }
  }

  salvar() {
    cy.get('[data-cy="salvar-cliente"]').click();
  }
}

export default new ClientesPage();
