<?php
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $nome = $_POST["nome"];
        $id_usuario = (int)$_POST["id_usuario"];
        $id_curso = (int)$_POST["id_curso"];
        $id_turma = (int)$_POST["id_turma"];

        $sql = "INSERT INTO pedagogos (nome, id_usuario, id_curso, id_turma) VALUES (:nome, :id_usuario, :id_curso, :id_turma)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);
        $stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT);

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
