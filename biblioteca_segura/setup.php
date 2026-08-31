<?php
// Rode este arquivo UMA vez pelo navegador (http://localhost/.../setup.php)
// para criar os usuários iniciais com a senha guardada em hash.
// Depois de usar, APAGUE este arquivo.

require 'config.php';

$usuarios = [
    ['Administrador', 'admin@biblioteca.com.br', 'admin', 'admin123', 'admin'],
    ['Carla Menezes', 'carla@biblioteca.com.br', 'carla', 'biblio2024', 'comum'],
];

foreach ($usuarios as $u) {
    [$nome, $email, $login, $senha, $nivel] = $u;

    $stmt = mysqli_prepare($conn, "SELECT id FROM usuarios WHERE usuario = ?");
    mysqli_stmt_bind_param($stmt, 's', $login);
    mysqli_stmt_execute($stmt);
    if (mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))) {
        echo "Usuário '$login' já existe.<br>";
        continue;
    }

    $hash = password_hash($senha, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn,
        "INSERT INTO usuarios (nome, email, usuario, senha, nivel) VALUES (?,?,?,?,?)");
    mysqli_stmt_bind_param($stmt, 'sssss', $nome, $email, $login, $hash, $nivel);
    mysqli_stmt_execute($stmt);
    echo "Usuário '$login' criado.<br>";
}

echo "<br><strong>Pronto. Agora apague este arquivo (setup.php).</strong>";
