<?php require 'config.php'; ?>
<?php require 'includes/header.php'; ?>

<?php $q = $_GET['q'] ?? ''; ?>

<h1><i class="bi bi-search"></i> Resultado da busca</h1>
<p class="subtitulo">Você buscou por: <?php echo e($q); ?></p>

<form class="busca" action="buscar.php" method="get">
    <input type="text" name="q" value="<?php echo e($q); ?>" placeholder="Buscar por título ou autor...">
    <button class="btn" type="submit"><i class="bi bi-search"></i> Buscar</button>
</form>

<div class="grade">
<?php
$like = '%' . $q . '%';
$stmt = mysqli_prepare($conn, "SELECT * FROM livros WHERE titulo LIKE ? OR autor LIKE ? ORDER BY titulo");
mysqli_stmt_bind_param($stmt, 'ss', $like, $like);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($res) == 0) {
    echo '<p>Nenhum livro encontrado.</p>';
} else {
    while ($livro = mysqli_fetch_assoc($res)) {
?>
    <a class="card" href="livro.php?id=<?php echo (int)$livro['id']; ?>" style="text-decoration:none;color:inherit">
        <img src="<?php echo e($livro['capa']); ?>" alt="capa">
        <div class="info">
            <h3><?php echo e($livro['titulo']); ?></h3>
            <p><i class="bi bi-person"></i> <?php echo e($livro['autor']); ?></p>
        </div>
    </a>
<?php
    }
}
?>
</div>

<?php require 'includes/footer.php'; ?>
