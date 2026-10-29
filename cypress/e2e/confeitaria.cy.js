
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
