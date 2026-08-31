<?php
// Em produção, o ideal é manter estas credenciais fora da pasta pública do site.
$host    = 'localhost';
$usuario = 'root';
$senha   = '';
$banco   = 'biblioteca';

// Não mostrar detalhes técnicos de erro ao usuário; registrar internamente.
ini_set('display_errors', '0');
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = mysqli_connect($host, $usuario, $senha, $banco);
    mysqli_set_charset($conn, 'utf8mb4');
} catch (Throwable $e) {
    error_log('Erro de conexao: ' . $e->getMessage());
    http_response_code(500);
    exit('Ocorreu um erro. Tente novamente mais tarde.');
}

// Cookie de sessão protegido
session_set_cookie_params([
    'httponly' => true,   // JavaScript não consegue ler o cookie
    'samesite' => 'Lax',  // ajuda contra CSRF
    'secure'   => false,  // troque para true quando usar HTTPS
]);
session_start();

// Token CSRF único por sessão
if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/auth.php';
