<?php
declare(strict_types=1);

require_once __DIR__ . '/sessao.php';

// Protege a página atual: se não houver usuário autenticado na sessão,
// redireciona para a tela de login, guardando a página de destino.
if (!isset($_SESSION['usuario_id'])) {
    $destino = basename($_SERVER['SCRIPT_NAME']);
    $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if (in_array($destino, ['atualizar.php', 'apagar.php'], true) && $id) {
        $destino .= '?id=' . $id;
    }
    header('Location: login.php?redirect=' . urlencode($destino));
    exit;
}
