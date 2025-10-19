<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../index.html");
    exit();
}

// Registra o logout no log do sistema (opcional)
$usuario_id = $_SESSION['usuario_id'];
$data_logout = date('Y-m-d H:i:s');
// Aqui você pode adicionar código para registrar o logout no banco de dados

// Limpa todas as variáveis da sessão
$_SESSION = array();

// Destrói o cookie da sessão se existir
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Destrói a sessão
session_destroy();

// Limpa o cache do navegador
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redireciona para a página de login com uma mensagem de sucesso
header("Location: ../index.php?logout=success");
exit();
?>
