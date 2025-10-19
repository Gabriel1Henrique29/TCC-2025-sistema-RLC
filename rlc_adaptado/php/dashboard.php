<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login_rlc.php");
    exit();
}

// Conectar ao banco para buscar informações do usuário
$servername = "localhost";
$username = "root";
$password = "ghg159357**";
$dbname = "rlc";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

$id = $_SESSION['id_usuario']; // Corrigido para 'id_usuario'
$sql = "SELECT nome FROM usuarios WHERE id_usuario = ?"; // Corrigido para 'id_usuario'
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$conn->close();
?>
