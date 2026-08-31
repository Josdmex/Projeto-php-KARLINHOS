<?php require 'config.php'; ?>
<?php require 'includes/header.php'; ?>

<h1><i class="bi bi-collection"></i> Acervo da Biblioteca</h1>
<p class="subtitulo">Consulte os livros disponíveis e faça sua reserva na recepção.</p>

<form class="busca" action="buscar.php" method="get">
    <input type="text" name="q" placeholder="Buscar por título ou autor...">
    <button class="btn" type="submit"><i class="bi bi-search"></i> Buscar</button>
</form>

<div class="grade">
<?php
$res = mysqli_query($conn, "SELECT * FROM livros ORDER BY titulo");
while ($livro = mysqli_fetch_assoc($res)) {
?>
    <a class="card" href="livro.php?id=<?php echo (int)$livro['id']; ?>" style="text-decoration:none;color:inherit">
        <img src="<?php echo e($livro['capa']); ?>" alt="capa">
        <div class="info">
            <h3><?php echo e($livro['titulo']); ?></h3>
            <p><i class="bi bi-person"></i> <?php echo e($livro['autor']); ?></p>
            <?php if ($livro['disponivel']): ?>
                <span class="tag tag-ok"><i class="bi bi-check-circle"></i> Disponível</span>
            <?php else: ?>
                <span class="tag tag-no"><i class="bi bi-x-circle"></i> Emprestado</span>
            <?php endif; ?>
        </div>
    </a>
<?php } ?>
</div>

<?php require 'includes/footer.php'; ?>
