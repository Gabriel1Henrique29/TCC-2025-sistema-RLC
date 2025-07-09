<?php
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $nome = $_POST["nome"];
        $curso = $_POST["curso"];
        $id_usuario = $_POST["id_usuario"];

        $sql = "INSERT INTO coordenadores (nome, curso, id_usuario) VALUES (:nome, :curso, :id_usuario)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':curso', $curso);
        $stmt->bindParam(':id_usuario', $id_usuario);

        if ($stmt->execute()) {
            echo "<script>alert('Coordenador inserido com sucesso!'); window.history.back();</script>";
        } else {
            echo "Erro ao inserir coordenador.";
        }
    } catch(PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>
