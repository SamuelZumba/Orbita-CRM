<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/conexao.php';
require_once __DIR__ . '/funcoes.php';

$mensagem = consumir_aviso();
$tipo_mensagem = $mensagem !== '' ? 'success' : '';
$dados = ['nome' => '', 'email' => '', 'telefone' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = dados_cliente();
    $mensagem = formulario_valido()
        ? validar_cliente($dados)
        : 'O formulário expirou. Recarregue a página e tente novamente.';
    if (!formulario_valido()) {
        http_response_code(403);
    }
    if ($mensagem === '') {
        try {
            $stmt = $pdo->prepare('INSERT INTO clientes (nome, email, telefone) VALUES (?, ?, ?)');
            $stmt->execute([$dados['nome'], $dados['email'], $dados['telefone']]);
            definir_aviso('Cliente cadastrado com sucesso!');
            header('Location: cadastro.php', true, 303);
            exit;
        } catch (PDOException $erro) {
            $mensagem = 'Não foi possível cadastrar o cliente. Confira a tabela clientes e tente novamente.';
            http_response_code(500);
        }
    }
    $tipo_mensagem = 'error';
}
?>
<?php require_once __DIR__ . '/ui.php'; ?>
<?php orbita_open('cadastro', 'Novo cliente', 'Uma nova pessoa para fazer parte da sua rede.'); ?>
<div class="form-layout"><section class="panel contact-panel"><div class="panel-heading"><div><h2>Informações do cliente</h2><p>Preencha os dados abaixo. Campos com * são obrigatórios.</p></div><span class="panel-icon"><?php echo orbita_icon('person'); ?></span></div>
<?php if (!empty($mensagem)): ?>
<div class="alert alert-<?php echo $tipo_mensagem; ?>" role="status"><?php echo orbita_icon($tipo_mensagem === 'success' ? 'check' : 'lock'); ?><span><?php echo htmlspecialchars($mensagem); ?></span></div>
<?php endif; ?>
<form method="POST" action="" id="formCadastro">
<input type="hidden" name="csrf_token" value="<?php echo token_formulario(); ?>">
<div class="form-group"><label for="nome">Nome completo <span class="required-marker">*</span></label><input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($dados['nome']); ?>" maxlength="100" placeholder="Ex.: Mariana Oliveira" autocomplete="name" required aria-describedby="help-nome"><small class="field-help" id="help-nome">Informe nome e sobrenome, com pelo menos 3 caracteres.</small></div>
<div class="form-group"><label for="email">E-mail <span class="required-marker">*</span></label><input type="email" id="email" name="email" value="<?php echo htmlspecialchars($dados['email']); ?>" maxlength="100" placeholder="Ex.: mariana@email.com" autocomplete="email" required aria-describedby="help-email"><small class="field-help" id="help-email">O e-mail identifica o cadastro do cliente.</small></div>
<div class="form-group"><label for="telefone">Telefone <span class="required-marker">*</span></label><input type="tel" id="telefone" name="telefone" value="<?php echo htmlspecialchars($dados['telefone']); ?>" placeholder="(11) 99999-9999" autocomplete="tel" inputmode="numeric" required maxlength="20" aria-describedby="help-telefone"><small class="field-help" id="help-telefone">Inclua o DDD. A formatação é automática.</small></div>

<div class="form-actions"><button type="submit" class="btn btn-primary"><?php echo orbita_icon('save'); ?>Cadastrar cliente</button><a href="clientes.php" class="btn btn-secondary">Ver clientes</a></div>

</form></section>
<aside class="form-aside"><span class="record-badge">NOVO CONTATO</span><div class="aside-illustration" aria-hidden="true"><span><?php echo orbita_icon('person'); ?></span><i></i><i></i><i></i></div><h2>Comece uma boa conexão.</h2><p>Contatos organizados deixam sua rotina mais simples e aproximam você dos seus clientes.</p><div class="aside-tip"><?php echo orbita_icon('check'); ?><span>Confira o e-mail e o telefone antes de salvar.</span></div><a class="text-link" href="clientes.php">Explorar meus clientes<?php echo orbita_icon('arrow'); ?></a></aside>
</div>
<?php orbita_close('js/cadastro.js'); ?>
