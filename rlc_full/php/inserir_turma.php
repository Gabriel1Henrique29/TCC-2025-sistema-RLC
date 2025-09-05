<?php
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Dados do formulário
        $serie = $_POST["serie"]; // 1º, 2º, 3º
        $turma_letra = strtoupper(trim($_POST["turma_letra"])); // Ex: J
        $curso = $_POST["curso"];
        $turno = $_POST["turno"]; // Matutino, Vespertino
        $ano = date("Y");

        // Monta nome da turma
        $nome_turma = $serie . " " . $turma_letra;

        // Insere na tabela
        $sql = "INSERT INTO turmas (nome_turma, curso, turno, ano, id_coordenador) VALUES (:nome_turma, :curso, :turno, :ano, NULL)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':nome_turma', $nome_turma);
        $stmt->bindParam(':curso', $curso);
        $stmt->bindParam(':turno', $turno);
        $stmt->bindParam(':ano', $ano);

        if ($stmt->execute()) {
            echo "<script>alert('Turma inserida com sucesso!'); window.location.href = '../htmls/controle-adm.php';</script>";
        } else {
            echo "Erro ao inserir turma.";
        }
    } catch(PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    echo "Acesso inválido.";
}
?>
