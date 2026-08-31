<?php
require 'config.php';
exigirLogin();
?>

<?php require 'includes/header.php'; ?>

<div class="painel-topo">
    <div>
        <h1><i class="bi bi-speedometer2"></i> Painel de gerenciamento</h1>
        <p class="subtitulo">Bem-vindo, <?php echo e($_SESSION['usuario']); ?>.</p>
    </div>
    <div>
        <a href="livro_form.php" class="btn"><i class="bi bi-plus-lg"></i> Novo livro</a>
        <?php if (($_SESSION['nivel'] ?? '') === 'admin'): ?>
            <a href="usuarios.php" class="btn btn-cinza"><i class="bi bi-people"></i> Usuários</a>
        <?php endif; ?>
        <a href="emprestimos.php" class="btn btn-cinza"><i class="bi bi-arrow-left-right"></i> Empréstimos</a>
    </div>
</div>

<h2><i class="bi bi-book"></i> Livros cadastrados</h2>
<table>
    <tr>
        <th>ID</th><th>Título</th><th>Autor</th><th>Categoria</th><th>Ano</th><th>Situação</th><th>Ações</th>
    </tr>
<?php
$res = mysqli_query($conn, "SELECT * FROM livros ORDER BY id DESC");
while ($l = mysqli_fetch_assoc($res)) {
?>
    <tr>
        <td><?php echo (int)$l['id']; ?></td>
        <td><?php echo e($l['titulo']); ?></td>
        <td><?php echo e($l['autor']); ?></td>
        <td><?php echo e($l['categoria']); ?></td>
        <td><?php echo e($l['ano']); ?></td>
        <td>
            <?php echo $l['disponivel'] ? '<span class="tag tag-ok">Disponível</span>' : '<span class="tag tag-no">Emprestado</span>'; ?>
        </td>
        <td style="display:flex;gap:6px">
            <a href="livro_form.php?id=<?php echo (int)$l['id']; ?>" class="btn" style="padding:5px 9px"><i class="bi bi-pencil"></i></a>
            <form method="post" action="livro_excluir.php" onsubmit="return confirm('Excluir este livro?')">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo (int)$l['id']; ?>">
                <button class="btn btn-vermelho" style="padding:5px 9px" type="submit"><i class="bi bi-trash"></i></button>
            </form>
        </td>
    </tr>
<?php } ?>
</table>

<?php require 'includes/footer.php'; ?>
