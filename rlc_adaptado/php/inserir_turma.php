<?php
require_once 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $nome_turma = trim($_POST["nome_turma"]);
        $ano = (int)($_POST["ano"] ?? date("Y"));
        $id_coordenador = !empty($_POST["id_coordenador"]) ? (int)$_POST["id_coordenador"] : null;
        $id_pedagogo = !empty($_POST["id_pedagogo"]) ? (int)$_POST["id_pedagogo"] : null;

        $sql = "INSERT INTO turmas (nome_turma, ano, id_coordenador, id_pedagogo)
                VALUES (:nome_turma, :ano, :id_coordenador, :id_pedagogo)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':nome_turma', $nome_turma);
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
        $stmt->bindParam(':id_coordenador', $id_coordenador, $id_coordenador === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindParam(':id_pedagogo', $id_pedagogo, $id_pedagogo === null ? PDO::PARAM_NULL : PDO::PARAM_INT);

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
