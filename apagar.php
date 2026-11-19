<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/conexao.php';
require_once __DIR__ . '/funcoes.php';

$id = id_cliente($_GET['id'] ?? 0);
$stmt = $pdo->prepare('SELECT id, nome, email, telefone FROM clientes WHERE id = ?');
$stmt->execute([$id]);
$cliente = $stmt->fetch();
$mensagem = '';

if (!$cliente) {
    http_response_code(404);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!formulario_valido()) {
        http_response_code(403);
        $mensagem = 'O formulário expirou. Recarregue a página e tente novamente.';
    } elseif (campo_post('confirmar') !== 'sim') {
        $mensagem = 'Confirme a exclusão no botão abaixo ou volte para a lista.';
    } else {
        try {
            $stmt = $pdo->prepare('DELETE FROM clientes WHERE id = ?');
            $stmt->execute([$id]);
            definir_aviso($stmt->rowCount() > 0
                ? 'Cliente excluído com sucesso!'
                : 'O cliente já havia sido removido.');
            header('Location: clientes.php', true, 303);
            exit;
        } catch (PDOException $erro) {
            http_response_code(500);
            $mensagem = 'Não foi possível excluir o cliente. Tente novamente.';
        }
    }
}

require_once __DIR__ . '/ui.php';
orbita_open('clientes', 'Excluir cliente', 'Confira o contato antes de confirmar a exclusão.');
?>
<section class="panel feedback-panel">
    <span class="feedback-icon"><?php echo orbita_icon($cliente ? 'trash' : 'search'); ?></span>
    <p class="eyebrow">REDE DE CONTATOS</p>
    <?php if ($cliente): ?>
        <h2>Excluir este cliente?</h2>
        <p>O contato abaixo será removido da sua lista.</p>
        <div class="delete-details">
            <strong><?php echo htmlspecialchars($cliente['nome']); ?></strong>
            <span><?php echo htmlspecialchars($cliente['email']); ?></span>
            <span><?php echo htmlspecialchars($cliente['telefone']); ?></span>
        </div>
        <?php if ($mensagem !== ''): ?>
        <div class="alert alert-error" role="alert"><?php echo htmlspecialchars($mensagem); ?></div>
        <?php endif; ?>
        <form method="POST" action="apagar.php?id=<?php echo $id; ?>" class="delete-confirmation">
            <input type="hidden" name="csrf_token" value="<?php echo token_formulario(); ?>">
            <input type="hidden" name="confirmar" value="sim">
            <a href="clientes.php" class="btn btn-secondary">Cancelar e voltar</a>
            <button type="submit" class="btn btn-danger"><?php echo orbita_icon('trash'); ?>Confirmar exclusão</button>
        </form>
    <?php else: ?>
        <h2>Cliente não encontrado.</h2>
        <p>Esse contato não existe ou já foi removido.</p>
        <a href="clientes.php" class="btn btn-primary">Voltar para meus clientes<?php echo orbita_icon('arrow'); ?></a>
    <?php endif; ?>
</section>
<?php orbita_close(); ?>
