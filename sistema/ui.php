<?php
// Componentes de apresentação compartilhados entre as páginas.
function orbita_icon($name) {
    $paths = [
        'home' => '<path d="m3 10 9-7 9 7v10a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1Z"/>',
        'users' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m20 0v-2a4 4 0 0 0-3-3.87M15 3.13a4 4 0 0 1 0 7.75"/><circle cx="9" cy="7" r="4"/>',
        'plus' => '<path d="M12 5v14M5 12h14"/>',
        'arrow' => '<path d="M5 12h14m-6-6 6 6-6 6"/>',
        'edit' => '<path d="m16 3 5 5M4 20l5-1L21 7a2.8 2.8 0 0 0-4-4L5 15Z"/>',
        'trash' => '<path d="M3 6h18M9 6V3h6v3M5 6l1 15h12l1-15M10 10v7m4-7v7"/>',
        'search' => '<circle cx="10.5" cy="10.5" r="7"/><path d="m16 16 5 5"/>',
        'logout' => '<path d="M9 21H4V3h5m7 4 5 5-5 5m-8-5h13"/>',
        'mail' => '<rect x="3" y="5" width="18" height="14" rx="3"/><path d="m3 7 9 6 9-6"/>',
        'phone' => '<path d="m8 3 2 5-3 2a14 14 0 0 0 7 7l2-3 5 2v3a2 2 0 0 1-2 2A18 18 0 0 1 3 5a2 2 0 0 1 2-2Z"/>',
        'person' => '<circle cx="12" cy="7" r="4"/><path d="M4 21v-2a8 8 0 0 1 16 0v2"/>',
        'lock' => '<rect x="4" y="10" width="16" height="11" rx="3"/><path d="M8 10V6a4 4 0 0 1 8 0v4m-4 5v2"/>',
        'check' => '<path d="m5 12 4 4L19 6"/>',
        'save' => '<path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12l4 4v12a2 2 0 0 1-2 2Z"/><path d="M7 3v6h10V3M7 21v-8h10v8"/>',
    ];
    return '<svg class="icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($paths[$name] ?? $paths['arrow']) . '</svg>';
}

function orbita_head($title) { ?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#172b25">
    <title><?php echo htmlspecialchars($title); ?> · Órbita CRM</title>
    <link rel="icon" type="image/svg+xml" href="img/orbita.svg">
    <link rel="stylesheet" href="css/orbita.css">
</head>
<?php }

function orbita_open($page, $title, $description, $action = false) {
    orbita_head($title);
    $nav = [
        ['home', 'index.html', 'Visão geral', 'home'],
        ['clientes', 'clientes.php', 'Meus clientes', 'users'],
        ['cadastro', 'cadastro.php', 'Novo cliente', 'plus'],
    ]; ?>
<body class="app-body">
<a class="skip-link" href="#conteudo">Ir para o conteúdo</a>
<div class="app-layout">
    <aside class="sidebar" aria-label="Menu principal">
        <a class="brand" href="index.html" aria-label="Órbita CRM — início">
            <img src="img/orbita.svg" alt="" width="40" height="40">
            <span>órbita<span class="brand-suffix">CRM</span></span>
        </a>
        <p class="nav-caption">SEU ESPAÇO DE GESTÃO</p>
        <nav class="main-nav" aria-label="Navegação">
            <?php foreach ($nav as $item): ?>
            <a class="nav-link<?php echo $page === $item[0] ? ' active' : ''; ?>" href="<?php echo $item[1]; ?>"<?php echo $page === $item[0] ? ' aria-current="page"' : ''; ?>>
                <?php echo orbita_icon($item[3]); ?><span><?php echo $item[2]; ?></span>
                <?php if ($page === $item[0]): ?><span class="nav-dot"></span><?php endif; ?>
            </a>
            <?php endforeach; ?>
        </nav>
        <div class="sidebar-note">
            <span class="small-orbit" aria-hidden="true">✳</span>
            <p>Boas conexões.<br><strong>Novas possibilidades.</strong></p>
            <span>Seus contatos, mais perto.</span>
        </div>
        <div class="sidebar-account">
            <span class="account-avatar"><?php echo orbita_icon('person'); ?></span>
            <div><span class="account-caption">CONECTADO COMO</span><strong><?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></strong></div>
            <a class="logout-link" href="logout.php" aria-label="Sair da conta" title="Sair da conta"><?php echo orbita_icon('logout'); ?></a>
        </div>
    </aside>
    <div class="workspace">
        <header class="topbar">
            <div class="breadcrumb"><span>Workspace</span><span class="breadcrumb-divider">/</span><strong><?php echo htmlspecialchars($title); ?></strong></div>
            <span class="workspace-label"><span></span> Gestão de clientes</span>
        </header>
        <main id="conteudo" class="main-content">
            <div class="page-heading">
                <div><p class="eyebrow">ÓRBITA CRM</p><h1><?php echo htmlspecialchars($title); ?></h1><p class="page-description"><?php echo htmlspecialchars($description); ?></p></div>
                <?php if ($action): ?><a class="btn btn-primary" href="cadastro.php"><?php echo orbita_icon('plus'); ?>Novo cliente</a><?php endif; ?>
            </div>
<?php }

function orbita_close($script = null) { ?>
        </main>
        <footer class="app-footer"><span>Órbita CRM <span class="footer-divider">/</span> Pessoas no centro. Gestão em movimento.</span><span>© 2026 Órbita</span></footer>
    </div>
</div>
<?php if ($script): ?><script src="<?php echo htmlspecialchars($script); ?>"></script><?php endif; ?>
</body>
</html>
<?php }
