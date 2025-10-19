<?php
require_once 'conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	echo 'Método inválido';
	exit;
}

try {
	$nome = trim($_POST['nome'] ?? '');
	$id_turma = isset($_POST['id_turma']) ? (int)$_POST['id_turma'] : 0;
	$numero_chamada = isset($_POST['numero_chamada']) ? (int)$_POST['numero_chamada'] : 0;

	if ($nome === '' || $id_turma <= 0 || $numero_chamada <= 0) {
		echo "<script>alert('Preencha todos os campos corretamente.'); window.history.back();</script>";
		exit;
	}

	// Verifica se já existe o mesmo número de chamada na turma
	$sqlCheck = "SELECT 1 FROM alunos WHERE id_turma = :id_turma AND numero_chamada = :num LIMIT 1";
	$stmt = $conexao->prepare($sqlCheck);
	$stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT);
	$stmt->bindParam(':num', $numero_chamada, PDO::PARAM_INT);
	$stmt->execute();
	if ($stmt->fetchColumn()) {
		echo "<script>alert('Número na chamada já utilizado nesta turma.'); window.history.back();</script>";
		exit;
	}

	$sql = "INSERT INTO alunos (nome, id_turma, numero_chamada, status) VALUES (:nome, :id_turma, :numero_chamada, 'matricula')";
	$stmt = $conexao->prepare($sql);
	$stmt->bindParam(':nome', $nome);
	$stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT);
	$stmt->bindParam(':numero_chamada', $numero_chamada, PDO::PARAM_INT);
	$stmt->execute();

	echo "<script>alert('Aluno inserido com sucesso!'); window.location.href = '../htmls/controle-adm.php';</script>";
} catch (PDOException $e) {
	echo "<script>alert('Erro: ".$e->getMessage()."'); window.history.back();</script>";
}

