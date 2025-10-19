<?php
require_once 'conexao.php';

header('Content-Type: application/json; charset=utf-8');

try {
	$id_turma = isset($_GET['id_turma']) ? (int)$_GET['id_turma'] : 0;
	if ($id_turma <= 0) {
		echo json_encode([]);
		exit;
	}

	$sql = "SELECT id_aluno, nome, numero_chamada FROM alunos WHERE id_turma = :id_turma AND status = 'matricula' ORDER BY numero_chamada";
	$stmt = $conexao->prepare($sql);
	$stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT);
	$stmt->execute();
	$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($alunos);
} catch (Throwable $e) {
	echo json_encode([]);
}
