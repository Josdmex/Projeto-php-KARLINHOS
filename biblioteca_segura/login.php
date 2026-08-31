<?php
require 'config.php';

$erro = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verificar_csrf();
    $usuario = $_POST['usuario'] ?? '';
    $senha   = $_POST['senha'] ?? '';

    $stmt = mysqli_prepare($conn, "SELECT * FROM usuarios WHERE usuario = ?");
    mysqli_stmt_bind_param($stmt, 's', $usuario);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $u = mysqli_fetch_assoc($res);

    if ($u && password_verify($senha, $u['senha'])) {
        session_regenerate_id(true);
        $_SESSION['logado']  = true;
        $_SESSION['id']      = $u['id'];
        $_SESSION['usuario'] = $u['usuario'];
        $_SESSION['nivel']   = $u['nivel'];
        header('Location: painel.php');
        exit;
    } else {
        $erro = 'Usuário ou senha inválidos.';
    }
}
?>

<?php require 'includes/header.php'; ?>

<div class="login-wrap">
    <div class="form-box">
        <h1><i class="bi bi-person-circle"></i> Acesso restrito</h1>
        <p class="subtitulo">Área de funcionários</p>

        <?php if ($erro): ?><div class="aviso"><?php echo e($erro); ?></div><?php endif; ?>

        <form method="post" action="login.php">
            <?php echo csrf_field(); ?>
            <label>Usuário</label>
            <input type="text" name="usuario">
            <label>Senha</label>
            <input type="password" name="senha">
            <br><br>
            <button class="btn" type="submit" name="entrar"><i class="bi bi-box-arrow-in-right"></i> Entrar</button>
        </form>
    </div>
</div>

<?php require 'includes/footer.php'; ?>
