# Órbita CRM — Sistema de Gestão de Clientes

## 1. Visão geral

O **Órbita CRM** é um sistema web de gerenciamento de clientes. A aplicação permite cadastrar, consultar, atualizar e excluir registros de clientes, armazenando as informações em um banco de dados relacional MySQL/MariaDB.

O projeto utiliza PHP para processamento no servidor, HTML para estrutura das páginas, CSS para a interface e JavaScript para interações e validações no navegador. A execução é local, com Apache e MySQL/MariaDB disponibilizados pelo XAMPP.

## 2. Funcionalidades

- **Cadastro de clientes:** inclusão de nome, e-mail e telefone, com validação dos campos obrigatórios.
- **Listagem de clientes:** consulta dos registros armazenados no banco, com acesso às ações de edição e exclusão.
- **Pesquisa de clientes:** filtragem da listagem por meio de JavaScript.
- **Atualização de clientes:** alteração de informações de um registro selecionado por seu identificador (`id`).
- **Exclusão de clientes:** remoção por identificador, mediante confirmação do usuário.
- **Autenticação:** acesso ao gerenciamento de clientes por meio de login e sessão PHP.
- **Navegação:** página inicial com atalhos para cadastro, listagem e gerenciamento de clientes.

## 3. Tecnologias utilizadas

| Tecnologia | Aplicação |
| --- | --- |
| HTML5 | Estrutura das páginas |
| CSS3 | Estilização e adaptação visual |
| JavaScript | Interações, validações e busca na listagem |
| PHP | Processamento dos formulários e operações do sistema |
| PDO | Comunicação entre o PHP e o banco de dados |
| MySQL/MariaDB | Armazenamento dos dados |
| Apache (XAMPP) | Servidor web local |
| phpMyAdmin | Administração e consulta do banco de dados |

## 4. Estrutura de arquivos

```text
sistema/
├── index.html
├── index.php
├── cadastro.php
├── clientes.php
├── atualizar.php
├── apagar.php
├── login.php
├── logout.php
├── auth.php
├── sessao.php
├── conexao.php
├── funcoes.php
├── ui.php
├── banco.sql
├── README.md
├── TESTES.md
├── .gitignore
├── css/
│   └── orbita.css
├── js/
│   ├── cadastro.js
│   ├── atualizar.js
│   └── clientes.js
└── img/
    └── orbita.svg
```

**Arquivos principais:**

- `index.html`: página inicial e navegação principal.
- `cadastro.php`: formulário e processamento do cadastro.
- `clientes.php`: listagem dos clientes cadastrados.
- `atualizar.php`: edição de informações a partir do ID do cliente.
- `apagar.php`: confirmação e exclusão de um cliente.
- `conexao.php`: configuração da conexão PDO com o banco de dados.
- `banco.sql`: criação do banco e das tabelas utilizadas.
- `login.php`, `logout.php`, `auth.php` e `sessao.php`: autenticação e controle de sessão.
- `funcoes.php` e `ui.php`: funções auxiliares e componentes da interface.
- `TESTES.md`: registro dos testes e roteiro de verificação.

## 5. Instalação e execução

### 5.1. Pré-requisitos

- XAMPP instalado, com Apache, PHP e MySQL/MariaDB disponíveis.
- Navegador web atualizado.
- Extensão `pdo_mysql` habilitada no PHP (presente nas instalações usuais do XAMPP).

### 5.2. Copiar os arquivos

Extraia o projeto e coloque a pasta **`sistema`** dentro do diretório `htdocs` do XAMPP:

**Windows:**

```text
C:\xampp\htdocs\sistema
```

**macOS:**

```text
/Applications/XAMPP/xamppfiles/htdocs/sistema
```

Os arquivos `index.html`, `cadastro.php`, `clientes.php`, `atualizar.php` e `apagar.php` devem ficar diretamente dentro de `sistema`, sem uma segunda pasta com o mesmo nome.

### 5.3. Iniciar o servidor

1. Abra o painel de controle do XAMPP.
2. Inicie **Apache**.
3. Inicie **MySQL** (ou MariaDB, conforme a instalação).
4. Acesse `http://localhost/phpmyadmin`.

### 5.4. Importar o banco de dados

1. No phpMyAdmin, abra a opção **Importar**.
2. Selecione o arquivo `sistema/banco.sql`.
3. Execute a importação.
4. Verifique se o banco `mini_sistema` e as tabelas `clientes` e `usuarios` foram criados.

O arquivo SQL cria o banco `mini_sistema` quando necessário, seleciona esse banco e cria as tabelas com `CREATE TABLE IF NOT EXISTS`. Ele também cadastra o usuário administrador padrão, caso esse e-mail ainda não exista. O script não inclui registros iniciais na tabela `clientes` e não apaga os registros que já estiverem armazenados.

### 5.5. Conferir a conexão

A conexão é configurada em `conexao.php`. Os parâmetros padrão são:

```php
$host = '127.0.0.1';
$dbname = 'mini_sistema';
$user = 'root';
$password = '';
$port = (int) (getenv('DB_PORT') ?: 3306);
```

Caso o MySQL/MariaDB da máquina utilize outra senha ou porta, ajuste a configuração local antes de executar o sistema. Não publique senhas pessoais ou credenciais de produção no repositório.

### 5.6. Acessar o sistema

Abra no navegador:

```text
http://localhost/sistema
```

A página inicial é `index.html`. Ao entrar nas páginas de gerenciamento, o sistema solicita autenticação.

**Credenciais padrão para demonstração local:**

```text
E-mail: admin@sistema.com
Senha: admin123
```

Esse usuário é criado somente se ainda não existir na tabela `usuarios`. Caso a senha já tenha sido alterada em uma instalação anterior, a importação do SQL não redefine a senha existente.

> **Atenção:** as credenciais padrão destinam-se exclusivamente aos testes locais. Para utilizar o projeto em um ambiente público, é necessário substituí-las e revisar as configurações de segurança.

## 6. Banco de dados

O banco de dados utilizado é `mini_sistema`, com duas tabelas:

### Tabela `clientes`

| Campo | Tipo | Descrição |
| --- | --- | --- |
| `id` | `INT UNSIGNED` | Chave primária com incremento automático |
| `nome` | `VARCHAR(100)` | Nome do cliente |
| `email` | `VARCHAR(100)` | E-mail do cliente |
| `telefone` | `VARCHAR(20)` | Telefone do cliente |

Os campos `nome`, `email` e `telefone` são obrigatórios.

### Tabela `usuarios`

Armazena os dados necessários à autenticação: identificador, nome, e-mail, telefone opcional, hash da senha e data de criação. O campo `EMAIL` possui restrição de unicidade. A tabela `usuarios` é separada da tabela `clientes`, e as contas de acesso não são exibidas no cadastro de clientes.

## 7. Funcionamento do CRUD

| Operação | Arquivo | Comando SQL utilizado |
| --- | --- | --- |
| Cadastrar | `cadastro.php` | `INSERT INTO clientes` |
| Listar | `clientes.php` | `SELECT ... FROM clientes` |
| Atualizar | `atualizar.php` | `UPDATE clientes ... WHERE id = ?` |
| Excluir | `apagar.php` | `DELETE FROM clientes WHERE id = ?` |

O fluxo de utilização é:

1. Acessar a página inicial.
2. Entrar na área de clientes com o usuário administrador.
3. Cadastrar um cliente com nome, e-mail e telefone.
4. Consultar os clientes cadastrados.
5. Selecionar um registro para atualizar suas informações.
6. Selecionar um registro para exclusão e confirmar a operação.

As operações que identificam um cliente utilizam seu `id`. O sistema emprega consultas preparadas do PDO e validações no servidor. Os formulários de alteração de dados usam token de proteção contra requisições não autorizadas (CSRF); a exclusão somente é executada após uma confirmação enviada por POST.

## 8. Testes e verificação

O arquivo [`TESTES.md`](TESTES.md) apresenta os procedimentos executados e o roteiro de reprodução. O registro do projeto contém 53 verificações, entre elas:

- Cadastro e conferência no banco de cinco clientes.
- Listagem dos cinco registros cadastrados.
- Atualização de nome, e-mail e telefone de um cliente.
- Exclusão de um cliente após confirmação, com preservação dos demais registros.
- Verificação da navegação, autenticação, validações e sintaxe PHP.

Os testes registrados foram executados em ambiente isolado com PHP, PDO MySQL e MariaDB, conforme especificado em `TESTES.md`. Para a apresentação do projeto, as operações também podem ser reproduzidas no XAMPP e conferidas pelo phpMyAdmin.

Uma consulta para verificar os registros é:

```sql
SELECT id, nome, email, telefone
FROM mini_sistema.clientes
ORDER BY id;
```

