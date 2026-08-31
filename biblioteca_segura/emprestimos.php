<?php
require 'config.php';
exigirLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verificar_csrf();

    if (isset($_POST['registrar'])) {
        $livro_id = (int) ($_POST['livro_id'] ?? 0);
        $leitor   = $_POST['leitor'] ?? '';
        $prevista = $_POST['data_prevista'] ?? '';
        $hoje = date('Y-m-d');

        $stmt = mysqli_prepare($conn,
            "INSERT INTO emprestimos (livro_id, leitor, data_emprestimo, data_prevista, devolvido) VALUES (?,?,?,?,0)");
        mysqli_stmt_bind_param($stmt, 'isss', $livro_id, $leitor, $hoje, $prevista);
        mysqli_stmt_execute($stmt);

        $stmt = mysqli_prepare($conn, "UPDATE livros SET disponivel = 0 WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $livro_id);
        mysqli_stmt_execute($stmt);
    }

    if (isset($_POST['devolver'])) {
        $dev = (int) $_POST['devolver'];
        $stmt = mysqli_prepare($conn, "SELECT livro_id FROM emprestimos WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $dev);
        mysqli_stmt_execute($stmt);
        $e = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

        if ($e) {
            $stmt = mysqli_prepare($conn, "UPDATE emprestimos SET devolvido = 1 WHERE id = ?");
            mysqli_stmt_bind_param($stmt, 'i', $dev);
            mysqli_stmt_execute($stmt);

            $stmt = mysqli_prepare($conn, "UPDATE livros SET disponivel = 1 WHERE id = ?");
            mysqli_stmt_bind_param($stmt, 'i', $e['livro_id']);
            mysqli_stmt_execute($stmt);
        }
    }

    header('Location: emprestimos.php');
    exit;
}
?>

<?php require 'includes/header.php'; ?>

<a href="painel.php" class="btn btn-cinza"><i class="bi bi-arrow-left"></i> Voltar</a>

<h1 style="margin-top:16px"><i class="bi bi-arrow-left-right"></i> Empréstimos</h1>

<table>
    <tr><th>ID</th><th>Livro</th><th>Leitor</th><th>Retirada</th><th>Prazo</th><th>Status</th><th>Ações</th></tr>
<?php
$sql = "SELECT e.*, l.titulo FROM emprestimos e LEFT JOIN livros l ON l.id = e.livro_id ORDER BY e.id DESC";
$res = mysqli_query($conn, $sql);
while ($e = mysqli_fetch_assoc($res)) {
?>
    <tr>
        <td><?php echo (int)$e['id']; ?></td>
        <td><?php echo e($e['titulo']); ?></td>
        <td><?php echo e($e['leitor']); ?></td>
        <td><?php echo e($e['data_emprestimo']); ?></td>
        <td><?php echo e($e['data_prevista']); ?></td>
        <td><?php echo $e['devolvido'] ? '<span class="tag tag-ok">Devolvido</span>' : '<span class="tag tag-no">Em aberto</span>'; ?></td>
        <td>
            <?php if (!$e['devolvido']): ?>
            <form method="post" action="emprestimos.php">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="devolver" value="<?php echo (int)$e['id']; ?>">
                <button class="btn" style="padding:5px 9px" type="submit"><i class="bi bi-check2"></i> Devolver</button>
            </form>
            <?php endif; ?>
        </td>
    </tr>
<?php } ?>
</table>

<h2><i class="bi bi-plus-lg"></i> Registrar empréstimo</h2>
<div class="form-box">
    <form method="post" action="emprestimos.php">
        <?php echo csrf_field(); ?>
        <label>Livro</label>
        <select name="livro_id">
            <?php
            $livros = mysqli_query($conn, "SELECT * FROM livros ORDER BY titulo");
            while ($l = mysqli_fetch_assoc($livros)) {
                echo '<option value="' . (int)$l['id'] . '">' . e($l['titulo']) . '</option>';
            }
            ?>
        </select>
        <label>Nome do leitor</label>
        <input type="text" name="leitor">
        <label>Devolução prevista</label>
        <input type="date" name="data_prevista">
        <br><br>
        <button class="btn" type="submit" name="registrar"><i class="bi bi-save"></i> Registrar</button>
    </form>
</div>

<?php require 'includes/footer.php'; ?>
