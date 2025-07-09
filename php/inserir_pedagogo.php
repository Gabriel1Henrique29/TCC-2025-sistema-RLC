<?php
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $nome = $_POST["nome"];
        $id_usuario = $_POST["id_usuario"];

        $sql = "INSERT INTO pedagogos (nome, id_usuario) VALUES (:nome, :id_usuario)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':id_usuario', $id_usuario);

        if ($stmt->execute()) {
            echo "<script>alert('Pedagogo inserido com sucesso!'); window.history.back();</script>";
        } else {
            echo "Erro ao inserir pedagogo.";
        }
    } catch(PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>
