<?php
session_start();
require 'conexao.php'; // Arquivo para conectar ao banco

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_tipo'] = $user['tipo'];
        header("Location: dashboard.php"); // Redireciona para o painel
        exit();
    } else {
        echo "Login inválido!";
    }
}
?>
