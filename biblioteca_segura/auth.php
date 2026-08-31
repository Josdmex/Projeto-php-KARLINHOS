<?php
// Escapa texto para exibir com segurança no HTML (contra XSS).
function e($txt) {
    return htmlspecialchars($txt ?? '', ENT_QUOTES, 'UTF-8');
}

// Exige que o usuário esteja logado.
function exigirLogin() {
    if (empty($_SESSION['logado'])) {
        header('Location: login.php');
        exit;
    }
}

// Exige nível administrador.
function exigirAdmin() {
    exigirLogin();
    if (($_SESSION['nivel'] ?? '') !== 'admin') {
        http_response_code(403);
        exit('Acesso negado.');
    }
}

// Campo escondido com o token, para colocar nos formulários.
function csrf_field() {
    return '<input type="hidden" name="csrf" value="' . e($_SESSION['csrf']) . '">';
}

// Confere o token nas ações que recebem POST.
function verificar_csrf() {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419);
        exit('Token invalido.');
    }
}
