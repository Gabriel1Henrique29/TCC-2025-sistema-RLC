<?php
require_once 'conexao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	echo "Método inválido";
	exit;
}

$tipo_vinculo = $_POST['tipo_vinculo'] ?? '';
$id_turma = isset($_POST['id_turma']) ? (int)$_POST['id_turma'] : 0;
$id_usuario = isset($_POST['id_usuario']) ? (int)$_POST['id_usuario'] : 0;
$id_aluno = isset($_POST['id_aluno']) ? (int)$_POST['id_aluno'] : 0;

try {
	if (!$tipo_vinculo || $id_turma <= 0 || $id_usuario <= 0) {
		echo "<script>alert('Preencha todos os campos obrigatórios.'); window.history.back();</script>";
		exit;
	}

	if ($tipo_vinculo === 'representante') {
		if ($id_aluno <= 0) {
			echo "<script>alert('Selecione um aluno para o representante.'); window.history.back();</script>";
			exit;
		}

		// Verifica se já existe representante ativo na turma
		$sql = "SELECT 1 FROM representantes_turma WHERE id_turma = :id_turma AND status = 'ativo' LIMIT 1";
		$stmt = $conexao->prepare($sql);
		$stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->fetchColumn()) {
			echo "<script>alert('Já existe um representante ativo para esta turma.'); window.history.back();</script>";
			exit;
		}

		// Insere representante
		$sql = "INSERT INTO representantes_turma (id_aluno, id_turma, id_usuario, data_inicio, status) VALUES (:id_aluno, :id_turma, :id_usuario, CURDATE(), 'ativo')";
		$stmt = $conexao->prepare($sql);
		$stmt->bindParam(':id_aluno', $id_aluno, PDO::PARAM_INT);
		$stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT);
		$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
		$stmt->execute();

		echo "<script>alert('Representante vinculado com sucesso!'); window.location.href = '../htmls/controle-adm.php';</script>";
		exit;
	}

	if ($tipo_vinculo === 'coordenador') {
		$sql = "UPDATE turmas SET id_coordenador = :id_usuario WHERE id_turma = :id_turma";
		$stmt = $conexao->prepare($sql);
		$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
		$stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT);
		$stmt->execute();

		echo "<script>alert('Coordenador vinculado à turma!'); window.location.href = '../htmls/controle-adm.php';</script>";
		exit;
	}

	if ($tipo_vinculo === 'pedagogo') {
		$sql = "UPDATE turmas SET id_pedagogo = :id_usuario WHERE id_turma = :id_turma";
		$stmt = $conexao->prepare($sql);
		$stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
		$stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT);
		$stmt->execute();

		echo "<script>alert('Pedagogo vinculado à turma!'); window.location.href = '../htmls/controle-adm.php';</script>";
		exit;
	}

	echo "<script>alert('Tipo de vínculo inválido.'); window.history.back();</script>";
} catch (PDOException $e) {
	echo "<script>alert('Erro: ".$e->getMessage()."'); window.history.back();</script>";
}
