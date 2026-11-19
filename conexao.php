<?php
declare(strict_types=1);

$host = '127.0.0.1';
$dbname = 'mini_sistema';
$user = 'root';
$password = '';
$port = (int) (getenv('DB_PORT') ?: 3306);

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );
} catch (PDOException $exception) {
    http_response_code(500);
    exit('Não foi possível conectar ao banco. Confira o MySQL no XAMPP, importe banco.sql e revise conexao.php.');
}
