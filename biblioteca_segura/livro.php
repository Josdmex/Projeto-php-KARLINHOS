<?php require 'config.php'; ?>
<?php require 'includes/header.php'; ?>

<?php
$id = (int) ($_GET['id'] ?? 0);
$stmt = mysqli_prepare($conn, "SELECT * FROM livros WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$livro = mysqli_fetch_assoc($res);

if (!$livro) {
    echo '<p class="aviso">Livro não encontrado.</p>';
    require 'includes/footer.php';
    exit;
}
?>

<a href="index.php" class="btn btn-cinza"><i class="bi bi-arrow-left"></i> Voltar ao acervo</a>

<div class="detalhe" style="margin-top:18px">
    <img src="<?php echo e($livro['capa']); ?>" alt="capa">
    <div class="dados">
        <h1><?php echo e($livro['titulo']); ?></h1>
        <p><i class="bi bi-person"></i> <strong>Autor:</strong> <?php echo e($livro['autor']); ?></p>
        <p><i class="bi bi-tag"></i> <strong>Categoria:</strong> <?php echo e($livro['categoria']); ?></p>
        <p><i class="bi bi-calendar"></i> <strong>Ano:</strong> <?php echo e($livro['ano']); ?></p>
        <p><i class="bi bi-upc"></i> <strong>ISBN:</strong> <?php echo e($livro['isbn']); ?></p>
        <p><i class="bi bi-info-circle"></i> <?php echo e($livro['descricao']); ?></p>
        <?php if ($livro['disponivel']): ?>
            <p><span class="tag tag-ok"><i class="bi bi-check-circle"></i> Disponível</span></p>
        <?php else: ?>
            <p><span class="tag tag-no"><i class="bi bi-x-circle"></i> Emprestado</span></p>
        <?php endif; ?>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
