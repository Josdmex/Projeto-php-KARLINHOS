<?php
require 'config.php';
exigirLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método não permitido.');
}
verificar_csrf();

$id = (int) ($_POST['id'] ?? 0);
$stmt = mysqli_prepare($conn, "DELETE FROM livros WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);

header('Location: painel.php');
exit;
