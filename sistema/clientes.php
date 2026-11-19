<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/conexao.php';
require_once __DIR__ . '/funcoes.php';

$clientes = $pdo->query('SELECT id, nome, email, telefone FROM clientes ORDER BY id DESC')->fetchAll();
$mensagem = consumir_aviso();
?>
<?php require_once __DIR__ . '/ui.php'; ?>
<?php orbita_open('clientes', 'Meus clientes', 'Todas as suas conexões, organizadas em um só lugar.', true); ?>
<?php if ($mensagem !== ''): ?>
<div class="alert alert-success" role="status"><?php echo orbita_icon('check'); ?><span><?php echo htmlspecialchars($mensagem); ?></span></div>
<?php endif; ?>
<section class="panel contacts-panel">
    <div class="list-heading"><div><span class="list-heading-icon"><?php echo orbita_icon('users'); ?></span><h2>Rede de contatos</h2><span class="count-badge"><?php echo count($clientes); ?></span></div><span class="list-caption">Nome, e-mail e telefone sempre à mão.</span></div>
    <div class="search-row"><div class="search-bar"><label class="sr-only" for="buscaClientes">Buscar por nome, e-mail ou telefone</label><?php echo orbita_icon('search'); ?><input type="search" id="buscaClientes" placeholder="Buscar por nome, e-mail ou telefone..." autocomplete="off"></div><span class="search-caption">Encontre sua próxima conexão.</span></div>
    <?php if (empty($clientes)): ?>
    <div class="empty-message"><span class="empty-icon"><?php echo orbita_icon('users'); ?></span><h3>Sua rede começa com uma pessoa.</h3><p>Cadastre seu primeiro cliente para começar a organizar os contatos.</p><a class="btn btn-primary" href="cadastro.php"><?php echo orbita_icon('plus'); ?>Adicionar primeiro cliente</a></div>
    <?php else: ?>
    <div class="table-responsive"><table><caption class="sr-only">Clientes cadastrados e ações de edição e exclusão</caption><thead><tr><th scope="col">ID</th><th scope="col">Cliente</th><th scope="col">E-mail</th><th scope="col">Telefone</th><th scope="col" class="actions-heading">Ações</th></tr></thead><tbody>
    <?php foreach ($clientes as $cliente): ?>
    <tr data-cliente-row data-search="<?php echo htmlspecialchars(strtolower($cliente['nome'] . ' ' . $cliente['email'] . ' ' . ($cliente['telefone'] ?? ''))); ?>">
        <td class="id-cell">#<?php echo $cliente['id']; ?></td>
        <td><div class="table-person"><span class="client-avatar"><?php echo orbita_icon('person'); ?></span><strong><?php echo htmlspecialchars($cliente['nome']); ?></strong></div></td>
        <td class="email-cell"><?php echo htmlspecialchars($cliente['email']); ?></td>
        <td class="phone-cell"><?php echo htmlspecialchars($cliente['telefone'] ?? '-'); ?></td>
        <td><div class="action-buttons"><a href="atualizar.php?id=<?php echo $cliente['id']; ?>" class="table-action" aria-label="Editar <?php echo htmlspecialchars($cliente['nome']); ?>" title="Editar cliente"><?php echo orbita_icon('edit'); ?><span>Editar</span></a><a href="apagar.php?id=<?php echo $cliente['id']; ?>" class="table-action delete-action" aria-label="Excluir <?php echo htmlspecialchars($cliente['nome']); ?>" title="Excluir cliente"><?php echo orbita_icon('trash'); ?><span class="sr-only">Excluir</span></a></div></td>
    </tr>
    <?php endforeach; ?>
    </tbody></table></div>
    <div class="list-footer"><p id="resultadoBusca" class="list-summary" aria-live="polite">Total de clientes: <?php echo count($clientes); ?></p><span>Boas conexões merecem cuidado.</span></div>
    <?php endif; ?>
</section>
<?php orbita_close('js/clientes.js'); ?>
