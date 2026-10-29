## Testes automatizados com Cypress

O projeto utiliza Cypress para testar as páginas e funcionalidades do sistema da Confeitaria.

### Executar os testes

Com a aplicação em execução, utilize:

```bash
npx cypress run
```

Para abrir o Cypress no modo interativo:

```bash
npx cypress open
```

### Refatoração — A2

Nesta etapa, a suíte de testes foi refatorada para melhorar a organização e a reutilização do código.

- **Page Objects:** centralizam seletores e ações das páginas de produtos e clientes.
- **Comandos personalizados:** `cy.criarProduto()` e `cy.criarCliente()` reutilizam os passos de cadastro.
- **Fixtures:** `produto.json` e `cliente.json` armazenam os dados utilizados nos testes.
- **Validação:** teste de cadastro de produto sem nome.
- **Estabilidade:** remoção de esperas fixas e uso das verificações automáticas do Cypress.

### Estrutura dos testes

```text
cypress/
├── e2e/
│   └── confeitaria.cy.js
├── fixtures/
│   ├── produto.json
│   └── cliente.json
└── support/
    ├── commands.js
    ├── e2e.js
    └── pages/
        ├── ClientesPage.js
        └── ProdutosPage.js
```

### Documentação da refatoração

Consulte o arquivo `REFATORACAO.md` para ver os problemas identificados e as soluções aplicadas na A2.
