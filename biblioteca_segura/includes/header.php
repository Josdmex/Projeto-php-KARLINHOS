<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Biblioteca Municipal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
<header class="topo">
    <div class="container topo-flex">
        <a href="index.php" class="logo"><i class="bi bi-book-half"></i> Biblioteca Municipal</a>
        <nav class="menu">
            <a href="index.php"><i class="bi bi-collection"></i> Acervo</a>
            <?php if (!empty($_SESSION['logado'])): ?>
                <a href="painel.php"><i class="bi bi-speedometer2"></i> Painel</a>
                <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Sair (<?php echo e($_SESSION['usuario']); ?>)</a>
            <?php else: ?>
                <a href="login.php"><i class="bi bi-person-circle"></i> Entrar</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="container conteudo">
