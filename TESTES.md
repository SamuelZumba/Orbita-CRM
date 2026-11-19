# Verificação do Órbita CRM

## Ambiente da verificação

A verificação utilizou PHP 8.4.24, PDO MySQL e MariaDB 11.8.6-MariaDB-0+deb13u1 from Debian, em Linux, com banco isolado. As páginas foram acessadas por HTTP usando o servidor de desenvolvimento do PHP. Esta execução não utilizou o painel XAMPP do computador do grupo; o roteiro abaixo permite repetir os testes nessa instalação.

O SQL e os arquivos PHP utilizados foram os mesmos desta entrega. Os dados foram conferidos diretamente na tabela `mini_sistema.clientes`, além da análise das respostas HTML das páginas.

## Testes exigidos no enunciado

| Teste | Execução | Resultado |
| --- | --- | --- |
| Cadastro | Cadastrar cinco clientes com nome, e-mail e telefone pelas páginas PHP e consultar o banco após cada cadastro. | Cinco registros persistidos, com cinco IDs distintos. |
| Consulta | Abrir `clientes.php` após os cinco cadastros. | Todos os cinco contatos aparecem, com dados e ações de edição e exclusão. |
| Atualização | Alterar nome, e-mail e telefone de um cliente usando seu ID. | Os três valores foram atualizados no banco; os outros quatro contatos permaneceram intactos. |
| Exclusão | Abrir a confirmação, cancelar, testar envio inválido e, depois, confirmar a exclusão de um cliente. | Abertura e cancelamento preservaram o contato. Somente a confirmação válida excluiu o ID escolhido, restando quatro registros. |
| Navegação | Acessar a página inicial, cadastro, listagem, edição, confirmação de exclusão e seus recursos locais. | As referências locais verificadas responderam sem erro 404. |

## Outras verificações

Foram aprovadas **53 verificações**, incluindo sintaxe, estrutura, autenticação, persistência e validação. Registro completo:

- Sintaxe PHP: apagar.php.
- Sintaxe PHP: atualizar.php.
- Sintaxe PHP: auth.php.
- Sintaxe PHP: cadastro.php.
- Sintaxe PHP: clientes.php.
- Sintaxe PHP: conexao.php.
- Sintaxe PHP: funcoes.php.
- Sintaxe PHP: index.php.
- Sintaxe PHP: login.php.
- Sintaxe PHP: logout.php.
- Sintaxe PHP: sessao.php.
- Sintaxe PHP: ui.php.
- SQL pode ser importado duas vezes sem duplicar o administrador.
- Tabela clientes tem ID primário com AUTO_INCREMENT.
- Entrada /sistema abre a página index.html.
- Página inicial contém cadastro e listagem.
- Pastas obrigatórias existem.
- Acesso sem sessão exige login.
- Senha incorreta é recusada.
- Login padrão funciona e abre clientes.
- Usuário do login não aparece na lista de clientes.
- Cadastro 1/5 grava no banco e mostra sucesso.
- Cadastro 2/5 grava no banco e mostra sucesso.
- Cadastro 3/5 grava no banco e mostra sucesso.
- Cadastro 4/5 grava no banco e mostra sucesso.
- Cadastro 5/5 grava no banco e mostra sucesso.
- Cinco clientes distintos persistidos.
- Listagem apresenta os cinco registros.
- Reimportação mantém os cinco clientes e o login.
- Edição carrega os dados pelo ID.
- Atualização persiste nome, e-mail e telefone.
- Atualização mantém os demais clientes intactos.
- Validação no servidor: nome.
- Validação no servidor: email.
- Validação no servidor: telefone.
- Campos inválidos continuam no formulário.
- Token inválido bloqueia alteração.
- Abrir exclusão exige confirmação sem apagar.
- Cancelar a exclusão preserva o registro.
- Exclusão com token inválido não apaga.
- Exclusão confirmada remove somente o ID escolhido.
- ID inexistente recebe página amigável.
- ID malformado não exclui registros.
- Apóstrofos e HTML tratados sem executar código.
- Página acessível: index.html.
- Página acessível: cadastro.php.
- Página acessível: clientes.php.
- Página acessível: atualizar.php?id=1.
- Página acessível: apagar.php?id=2.
- Página acessível: login.php.
- Links, botões de navegação e assets locais sem 404.
- Logout encerra a sessão.
- Login retorna à edição do mesmo ID.

## Repetir os testes no XAMPP

1. Importe `banco.sql` e abra `http://localhost/sistema`.
2. Entre com o administrador e cadastre cinco contatos de teste, com e-mails distintos e telefone preenchido.
3. No phpMyAdmin, selecione o banco `mini_sistema` e execute:

```sql
SELECT id, nome, email, telefone
FROM clientes
ORDER BY id;
```

4. Abra Meus clientes e confira se os cinco registros aparecem.
5. Edite um contato, salve e execute a consulta novamente. Confira os três dados e o mesmo ID.
6. Abra Excluir em outro contato. Cancele uma vez e confirme que ele continua na lista. Abra novamente e confirme a exclusão.
7. Execute a consulta para verificar que somente o registro selecionado foi removido.
8. Navegue pelos botões da página inicial, pelo menu, pela busca da lista e pelos botões de retorno e saída.

O teste pode ser repetido com dados fictícios. A importação do SQL não inclui clientes de demonstração e não apaga clientes existentes.
