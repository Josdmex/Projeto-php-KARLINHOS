<?php
require 'config.php';
exigirLogin();

$livro = ['id'=>'','titulo'=>'','autor'=>'','categoria'=>'','ano'=>'','isbn'=>'','descricao'=>'','capa'=>'','disponivel'=>1];

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM livros WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $encontrado = mysqli_fetch_assoc($res);
    if ($encontrado) {
        $livro = $encontrado;
    }
}
?>

<?php require 'includes/header.php'; ?>

<a href="painel.php" class="btn btn-cinza"><i class="bi bi-arrow-left"></i> Voltar</a>

<h1 style="margin-top:16px">
    <i class="bi bi-book"></i>
    <?php echo $livro['id'] ? 'Editar livro' : 'Novo livro'; ?>
</h1>

<div class="form-box">
    <form method="post" action="livro_salvar.php">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="id" value="<?php echo (int)$livro['id']; ?>">

        <label>Título</label>
        <input type="text" name="titulo" value="<?php echo e($livro['titulo']); ?>">

        <label>Autor</label>
        <input type="text" name="autor" value="<?php echo e($livro['autor']); ?>">

        <label>Categoria</label>
        <input type="text" name="categoria" value="<?php echo e($livro['categoria']); ?>">

        <label>Ano</label>
        <input type="text" name="ano" value="<?php echo e($livro['ano']); ?>">

        <label>ISBN</label>
        <input type="text" name="isbn" value="<?php echo e($livro['isbn']); ?>">

        <label>Capa (URL da imagem)</label>
        <input type="text" name="capa" value="<?php echo e($livro['capa']); ?>">

        <label>Descrição</label>
        <textarea name="descricao"><?php echo e($livro['descricao']); ?></textarea>

        <label>Situação</label>
        <select name="disponivel">
            <option value="1" <?php echo $livro['disponivel'] ? 'selected' : ''; ?>>Disponível</option>
            <option value="0" <?php echo !$livro['disponivel'] ? 'selected' : ''; ?>>Emprestado</option>
        </select>

        <br><br>
        <button class="btn" type="submit"><i class="bi bi-save"></i> Salvar</button>
    </form>
</div>

<?php require 'includes/footer.php'; ?>
