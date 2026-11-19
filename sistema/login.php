<?php
declare(strict_types=1);

require_once __DIR__ . '/funcoes.php';
require_once __DIR__ . '/conexao.php';

// Se já estiver logado, vai direto para o sistema
if (isset($_SESSION['usuario_id'])) {
    header('Location: index.html');
    exit;
}

$mensagem = '';
$tipo_mensagem = '';
$email_preenchido = '';

// Página para onde o usuário será enviado após o login
$redirect = $_GET['redirect'] ?? ($_POST['redirect'] ?? 'index.html');
if (!is_string($redirect) || !preg_match('/^(?:index\.html|clientes\.php|cadastro\.php|(?:atualizar|apagar)\.php(?:\?id=[1-9][0-9]*)?)$/D', $redirect)) {
    $redirect = 'index.html';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = campo_post('email');
    $senha = isset($_POST['senha']) && is_string($_POST['senha']) ? $_POST['senha'] : '';
    $email_preenchido = $email;

    if (!formulario_valido()) {
        http_response_code(403);
        $mensagem = 'O formulário expirou. Recarregue a página e tente novamente.';
        $tipo_mensagem = 'error';
    } elseif (empty($email) || empty($senha)) {
        $mensagem = 'Informe email e senha!';
        $tipo_mensagem = 'error';
    } else {
        $stmt = $pdo->prepare('SELECT ID, NOME, EMAIL, SENHA FROM usuarios WHERE EMAIL = ?');
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['SENHA'])) {
            session_regenerate_id(true);
            unset($_SESSION['csrf_token']);
            $_SESSION['usuario_id'] = $usuario['ID'];
            $_SESSION['usuario_nome'] = $usuario['NOME'];
            $_SESSION['usuario_email'] = $usuario['EMAIL'];

            header('Location: ' . $redirect);
            exit;
        }

        $mensagem = 'Email ou senha inválidos!';
        $tipo_mensagem = 'error';
    }
}
?>
<?php require_once __DIR__ . '/ui.php'; ?>
<?php orbita_head('Entrar'); ?>
<body class="login-body">
<main class="login-layout">
    <section class="login-story" aria-label="Bem-vindo à Órbita">
        <a class="brand" href="login.php"><img src="img/orbita.svg" alt="" width="44" height="44"><span>órbita<span class="brand-suffix">CRM</span></span></a>
        <div class="story-copy"><p class="eyebrow">CONEXÕES QUE IMPORTAM</p><h1>Seu próximo<br>bom relacionamento<br> começa aqui<span>.</span></h1><p>Um lugar simples para organizar seus clientes<br class="desktop-break"> e cuidar de cada conexão.</p></div>
        <div class="connection-art" aria-hidden="true"><div class="orbit-ring ring-one"></div><div class="orbit-ring ring-two"></div><div class="orbit-ring ring-three"></div><div class="orbit-center"><img src="img/orbita.svg" alt=""></div><span class="orbit-point point-one"><?php echo orbita_icon('person'); ?></span><span class="orbit-point point-two"><?php echo orbita_icon('mail'); ?></span><span class="orbit-point point-three"><?php echo orbita_icon('phone'); ?></span><span class="art-label"><span></span> Pessoas no centro de tudo.</span></div>
        <p class="story-footer">GESTÃO SIMPLES. POSSIBILIDADES INFINITAS.</p>
    </section>
    <section class="login-form-area">
        <div class="login-card"><div class="login-intro-icon"><?php echo orbita_icon('lock'); ?></div><p class="eyebrow">BOM TER VOCÊ POR AQUI</p><h2>Acesse seu espaço.</h2><p class="login-subtitle">Entre com seu e-mail e senha para continuar.</p>
        <?php if (!empty($mensagem)): ?>
<div class="alert alert-<?php echo $tipo_mensagem; ?>" role="status"><?php echo orbita_icon($tipo_mensagem === 'success' ? 'check' : 'lock'); ?><span><?php echo htmlspecialchars($mensagem); ?></span></div>
<?php endif; ?>
        <form method="POST" action="login.php" id="formLogin">
            <input type="hidden" name="csrf_token" value="<?php echo token_formulario(); ?>">
            <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
            <div class="form-group"><label for="email">E-mail</label><div class="input-wrap"><?php echo orbita_icon('mail'); ?><input type="email" id="email" name="email" placeholder="seu@email.com" value="<?php echo htmlspecialchars($email_preenchido); ?>" autocomplete="username" required autofocus></div></div>
            <div class="form-group"><label for="senha">Senha</label><div class="input-wrap"><?php echo orbita_icon('lock'); ?><input type="password" id="senha" name="senha" placeholder="Digite sua senha" autocomplete="current-password" required></div></div>
            <button type="submit" class="btn btn-primary login-submit">Entrar no Órbita<?php echo orbita_icon('arrow'); ?></button>
        </form>
        <div class="demo-access"><span class="demo-caption">ACESSO PADRÃO DO PROJETO</span><p>admin@sistema.com <span>·</span> admin123</p></div>
        </div><p class="login-footer">© 2026 Órbita CRM · Cada contato, uma possibilidade.</p>
    </section>
</main>
</body></html>
