# Órbita CRM — Mini Sistema Web

Projeto de cadastro de clientes para o trabalho de Laboratório de Banco de Dados do 4º ADS. Desenvolvido em HTML, CSS, JavaScript e PHP, com PDO e MySQL/MariaDB, para execução local no XAMPP.

## Atualizar a versão anterior no Mac

1. Guarde uma cópia da pasta anterior do projeto e dos seus dados antes da atualização.
2. Extraia o ZIP. A pasta principal desta versão é **sistema**.
3. Coloque a pasta inteira em `/Applications/XAMPP/xamppfiles/htdocs/`.
4. O arquivo inicial deve ficar em `/Applications/XAMPP/xamppfiles/htdocs/sistema/index.html`.
5. Inicie **Apache** e **MySQL Database** no XAMPP.
6. Abra `http://localhost/phpmyadmin`, clique em **Importar** e escolha **banco.sql**, que está dentro da nova pasta `sistema`.
7. Execute a importação. O script utiliza `CREATE ... IF NOT EXISTS`, não remove tabelas nem apaga registros existentes. Ele cria a tabela `clientes` e mantém `usuarios` para o login.
8. Confira usuário, senha e porta em `conexao.php`. Se você personalizou a senha de conexão na versão anterior, mantenha essa senha aqui.
9. Abra **http://localhost/sistema**. A página inicial é `index.html`.
10. Se o navegador ainda mostrar o visual anterior, pressione `Command + Shift + R`.

Nesta versão, o endereço é `/sistema`, e não `/mini_sistema`. O nome do banco continua sendo `mini_sistema`, conforme o enunciado. O script não converte registros de `usuarios` em clientes: as duas tabelas têm funções separadas.

## Instalar do zero no Windows ou Mac

### 1. Colocar o projeto no XAMPP

- Windows: `C:\xampp\htdocs\sistema`
- macOS: `/Applications/XAMPP/xamppfiles/htdocs/sistema`

Evite colocar uma pasta `sistema` dentro de outra. Abra a pasta e confira se `index.html`, `cadastro.php`, `clientes.php`, `atualizar.php` e `apagar.php` estão diretamente nela.

### 2. Iniciar os serviços e importar o banco

No painel do XAMPP, inicie Apache e MySQL/MariaDB. Abra `http://localhost/phpmyadmin` e importe `banco.sql`. O próprio script cria e seleciona o banco `mini_sistema`.

### 3. Conferir a conexão

Os valores padrão do XAMPP estão em `conexao.php`:

```php
$host = '127.0.0.1';
$dbname = 'mini_sistema';
$user = 'root';
$password = '';
$port = (int) (getenv('DB_PORT') ?: 3306);
```

Se a instalação utilizar outra senha ou porta, ajuste os valores para corresponderem ao seu MySQL. Nenhum pacote npm ou compilação é necessário para rodar o site.

### 4. Abrir e acessar

Abra **http://localhost/sistema** e selecione **Cadastrar cliente** ou **Meus clientes**. O login, mantido da versão anterior como recurso adicional, será solicitado para acessar o CRUD:

- E-mail: **admin@sistema.com**
- Senha: **admin123**

A importação cria esse administrador apenas se o e-mail ainda não existir. Se você já alterou a senha desse usuário, sua senha anterior continua valendo.

## Estrutura

```text
sistema/
  index.html
  cadastro.php
  atualizar.php
  apagar.php
  clientes.php
  css/
    orbita.css
  js/
    cadastro.js
    atualizar.js
    clientes.js
  img/
    orbita.svg
  conexao.php
  funcoes.php
  ui.php
  sessao.php
  auth.php
  login.php
  logout.php
  index.php
  banco.sql
  README.md
  TESTES.md
```

`index.html` é a página principal e contém os acessos ao cadastro e à listagem. `index.php` apenas redireciona para `index.html`, mantendo compatibilidade com atalhos anteriores. Os arquivos auxiliares implementam a conexão, a autenticação, a validação dos formulários e os componentes visuais.

## Banco e funcionamento do CRUD

O banco chama-se **mini_sistema**. A tabela **clientes** contém `id` como chave primária com incremento automático, além de `nome`, `email` e `telefone`. Os três campos do contato são obrigatórios.

| Arquivo | Funcionamento |
| --- | --- |
| `cadastro.php` | Valida os dados enviados por POST e executa `INSERT INTO clientes`. |
| `clientes.php` | Executa `SELECT` em `clientes`, mostra os registros e os acessos à edição e exclusão. A busca em JavaScript filtra a lista. |
| `atualizar.php` | Recebe o ID, carrega o contato e executa `UPDATE clientes ... WHERE id = ?` após validar o formulário. |
| `apagar.php` | Ao abrir por GET, mostra os dados do contato e pede confirmação. Só executa `DELETE FROM clientes WHERE id = ?` após um POST confirmado com token válido. O botão Cancelar volta à lista sem excluir. |

`usuarios` é utilizada somente para autenticação. O administrador não aparece na listagem de clientes. A senha de acesso é armazenada como hash bcrypt.

As consultas de gravação e as buscas por ID usam parâmetros preparados do PDO. Os formulários validam nome, e-mail e telefone no servidor. Os valores exibidos são escapados em HTML. Após uma gravação, o navegador é redirecionado para evitar duplicar a operação ao recarregar a página.

## Testes

Os testes executados e o roteiro para repeti-los no XAMPP estão em **TESTES.md**. Foram cadastrados cinco clientes por requisições às páginas PHP, com consulta direta ao banco para confirmar as gravações, uma atualização e uma exclusão. Os dados usados nos testes ficaram em um banco isolado e não são carregados automaticamente na instalação do projeto.

## Entrega pelo GitHub

1. Entre na conta do grupo e crie um repositório.
2. Envie a pasta completa `sistema`, incluindo o SQL e os arquivos de instruções. A estrutura do repositório deve conter `sistema/index.html` e os demais arquivos.
3. Se tiver personalizado a senha do banco para sua instalação, não publique essa senha; mantenha no repositório a configuração padrão local do XAMPP.
4. Confira se todos os arquivos aparecem no repositório.
5. Copie o link do repositório e envie no local indicado pelo professor.

A publicação no GitHub e a participação de todos os integrantes na apresentação são etapas a serem realizadas pelo grupo. O projeto não depende de hospedagem externa para funcionar.
