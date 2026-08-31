<?php
require 'config.php';
exigirLogin();
verificar_csrf();

$id         = (int) ($_POST['id'] ?? 0);
$titulo     = $_POST['titulo'] ?? '';
$autor      = $_POST['autor'] ?? '';
$categoria  = $_POST['categoria'] ?? '';
$ano        = (int) ($_POST['ano'] ?? 0);
$isbn       = $_POST['isbn'] ?? '';
$capa       = $_POST['capa'] ?? '';
$descricao  = $_POST['descricao'] ?? '';
$disponivel = (int) ($_POST['disponivel'] ?? 1);

if ($id) {
    $stmt = mysqli_prepare($conn,
        "UPDATE livros SET titulo=?, autor=?, categoria=?, ano=?, isbn=?, capa=?, descricao=?, disponivel=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'sssisssii',
        $titulo, $autor, $categoria, $ano, $isbn, $capa, $descricao, $disponivel, $id);
} else {
    $stmt = mysqli_prepare($conn,
        "INSERT INTO livros (titulo, autor, categoria, ano, isbn, capa, descricao, disponivel) VALUES (?,?,?,?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt, 'sssisssi',
        $titulo, $autor, $categoria, $ano, $isbn, $capa, $descricao, $disponivel);
}

mysqli_stmt_execute($stmt);
header('Location: painel.php');
exit;
