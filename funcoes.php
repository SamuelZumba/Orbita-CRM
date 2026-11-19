<?php
declare(strict_types=1);

require_once __DIR__ . '/sessao.php';

function campo_post(string $nome): string
{
    $valor = $_POST[$nome] ?? '';
    return is_string($valor) ? trim($valor) : '';
}

function token_formulario(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function formulario_valido(): bool
{
    $token = campo_post('csrf_token');
    return $token !== '' && hash_equals(token_formulario(), $token);
}

function dados_cliente(): array
{
    return [
        'nome' => campo_post('nome'),
        'email' => campo_post('email'),
        'telefone' => campo_post('telefone'),
    ];
}

function validar_cliente(array $dados): string
{
    $tamanho_nome = preg_match_all('/./us', $dados['nome']);
    if ($tamanho_nome === false || $tamanho_nome < 3 || $tamanho_nome > 100) {
        return 'Informe um nome com 3 a 100 caracteres.';
    }
    if (strlen($dados['email']) > 100 || !filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
        return 'Informe um e-mail válido, com até 100 caracteres.';
    }
    if ($dados['telefone'] === '' || strlen($dados['telefone']) > 20 || !preg_match('/[0-9]/', $dados['telefone'])) {
        return 'Informe o telefone do cliente, com até 20 caracteres.';
    }
    return '';
}

function id_cliente($valor): int
{
    $id = filter_var($valor, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    return $id === false ? 0 : (int) $id;
}

function definir_aviso(string $mensagem): void
{
    $_SESSION['aviso'] = $mensagem;
}

function consumir_aviso(): string
{
    $mensagem = $_SESSION['aviso'] ?? '';
    unset($_SESSION['aviso']);
    return is_string($mensagem) ? $mensagem : '';
}
