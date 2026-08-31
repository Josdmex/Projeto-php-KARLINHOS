<?php
require 'config.php';
exigirAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verificar_csrf();

    if (isset($_POST['cadastrar'])) {
        $nome    = $_POST['nome'] ?? '';
        $email   = $_POST['email'] ?? '';
        $usuario = $_POST['usuario'] ?? '';
        $senha   = $_POST['senha'] ?? '';
        $nivel   = ($_POST['nivel'] ?? 'comum') === 'admin' ? 'admin' : 'comum';
        $hash    = password_hash($senha, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($conn,
            "INSERT INTO usuarios (nome, email, usuario, senha, nivel) VALUES (?,?,?,?,?)");
        mysqli_stmt_bind_param($stmt, 'sssss', $nome, $email, $usuario, $hash, $nivel);
        mysqli_stmt_execute($stmt);
    }

    if (isset($_POST['excluir'])) {
        $ex = (int) $_POST['excluir'];
        $stmt = mysqli_prepare($conn, "DELETE FROM usuarios WHERE id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $ex);
        mysqli_stmt_execute($stmt);
    }

    header('Location: usuarios.php');
    exit;
}
?>

<?php require 'includes/header.php'; ?>

<a href="painel.php" class="btn btn-cinza"><i class="bi bi-arrow-left"></i> Voltar</a>

<h1 style="margin-top:16px"><i class="bi bi-people"></i> Usuários do sistema</h1>

<table>
    <tr><th>ID</th><th>Nome</th><th>E-mail</th><th>Usuário</th><th>Nível</th><th>Ações</th></tr>
<?php
$res = mysqli_query($conn, "SELECT id, nome, email, usuario, nivel FROM usuarios ORDER BY id");
while ($u = mysqli_fetch_assoc($res)) {
?>
    <tr>
        <td><?php echo (int)$u['id']; ?></td>
        <td><?php echo e($u['nome']); ?></td>
        <td><?php echo e($u['email']); ?></td>
        <td><?php echo e($u['usuario']); ?></td>
        <td><?php echo e($u['nivel']); ?></td>
        <td>
            <form method="post" action="usuarios.php" onsubmit="return confirm('Excluir este usuário?')">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="excluir" value="<?php echo (int)$u['id']; ?>">
                <button class="btn btn-vermelho" style="padding:5px 9px" type="submit"><i class="bi bi-trash"></i></button>
            </form>
        </td>
    </tr>
<?php } ?>
</table>

<h2><i class="bi bi-person-plus"></i> Cadastrar novo usuário</h2>
<div class="form-box">
    <form method="post" action="usuarios.php">
        <?php echo csrf_field(); ?>
        <label>Nome</label>
        <input type="text" name="nome">
        <label>E-mail</label>
        <input type="text" name="email">
        <label>Usuário</label>
        <input type="text" name="usuario">
        <label>Senha</label>
        <input type="password" name="senha">
        <label>Nível</label>
        <select name="nivel">
            <option value="comum">Comum</option>
            <option value="admin">Administrador</option>
        </select>
        <br><br>
        <button class="btn" type="submit" name="cadastrar"><i class="bi bi-save"></i> Cadastrar</button>
    </form>
</div>

<?php require 'includes/footer.php'; ?>
