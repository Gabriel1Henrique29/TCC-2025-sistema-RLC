<?php
require_once '../php/conexao.php';
session_start();

$nivel_acesso = $_SESSION['nivel_acesso'] ?? '';
$id_usuario = $_SESSION['id_usuario'] ?? 0;

if (!$id_usuario) {
	header('Location: ../php/login_rlc.php');
	exit;
}

$id_turma = isset($_GET['turma']) ? (int)$_GET['turma'] : (isset($_GET['id_turma']) ? (int)$_GET['id_turma'] : 0);

function turmaAutorizada(PDO $conexao, int $idTurma, int $idUsuario, string $nivel): bool {
	if ($nivel === 'representante') {
		$sql = "SELECT 1 FROM representantes_turma WHERE id_turma = :id_turma AND id_usuario = :id_usuario AND status = 'ativo'";
		$stmt = $conexao->prepare($sql);
		$stmt->bindParam(':id_turma', $idTurma, PDO::PARAM_INT);
		$stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
		$stmt->execute();
		return (bool)$stmt->fetchColumn();
	}
	if ($nivel === 'pedagogo') {
		$sql = "SELECT 1 FROM turmas WHERE id_turma = :id_turma AND id_pedagogo = :id_usuario";
		$stmt = $conexao->prepare($sql);
		$stmt->bindParam(':id_turma', $idTurma, PDO::PARAM_INT);
		$stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
		$stmt->execute();
		return (bool)$stmt->fetchColumn();
	}
	if ($nivel === 'coordenador') {
		$sql = "SELECT 1 FROM turmas WHERE id_turma = :id_turma AND id_coordenador = :id_usuario";
		$stmt = $conexao->prepare($sql);
		$stmt->bindParam(':id_turma', $idTurma, PDO::PARAM_INT);
		$stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
		$stmt->execute();
		return (bool)$stmt->fetchColumn();
	}
	return false;
}

if ($id_turma <= 0) {
	echo '<script>alert("Turma não informada."); history.back();</script>';
	exit;
}

if (!turmaAutorizada($conexao, $id_turma, $id_usuario, $nivel_acesso)) {
	echo '<script>alert("Acesso não autorizado para esta turma."); history.back();</script>';
	exit;
}

$turma = $conexao->prepare('SELECT nome_turma, ano FROM turmas WHERE id_turma = :id');
$turma->bindParam(':id', $id_turma, PDO::PARAM_INT);
$turma->execute();
$turma_info = $turma->fetch(PDO::FETCH_ASSOC);

$datas_stmt = $conexao->prepare('SELECT DISTINCT data FROM registros_presenca WHERE id_turma = :id_turma ORDER BY data DESC');
$datas_stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT);
$datas_stmt->execute();
$datas = $datas_stmt->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Selecionar Data - Chamada</title>
	<link rel="stylesheet" href="../css/chamada.css">
	<style>
		.data-card { max-width: 520px; margin: 24px auto; background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); }
		.data-card h2 { margin: 0 0 12px 0; }
		.data-row { display: flex; gap: 12px; margin-top: 12px; }
		.data-row select { flex: 1; padding: 8px 10px; border-radius: 6px; border: 1px solid #ccc; }
		.data-row button { padding: 8px 14px; border-radius: 6px; border: none; background: #1976d2; color: #fff; cursor: pointer; }
		.data-row button:hover { background: #1565c0; }
		.header { text-align: center; margin-top: 16px; }
		/* usar .back-button global do chamada.css */
	</style>
</head>
<body class="chamada">
	<header class="header">
		<div class="container-logo">
			<div class="logoimagem"><img src="../img/RLClogo.jpg" alt="Logo"></div>
		</div>
		<a class="back-button" href="<?= $nivel_acesso === 'representante' ? 'pg1.php' : 'pg2.php' ?>">Voltar ao menu</a>
	</header>

	<main class="data-card">
		<h2>Selecionar data</h2>
		<div><b>Turma:</b> <?= htmlspecialchars($turma_info['nome_turma'] ?? '') ?> (<?= htmlspecialchars((string)($turma_info['ano'] ?? '')) ?>)</div>
		<?php if (empty($datas)): ?>
			<p style="margin-top:12px;">Não existem chamadas registradas para esta turma.</p>
		<?php else: ?>
			<div class="data-row">
				<select id="dataSelect">
					<?php foreach ($datas as $d): ?>
						<option value="<?= htmlspecialchars($d) ?>"><?= date('d/m/Y', strtotime($d)) ?></option>
					<?php endforeach; ?>
				</select>
				<button onclick="ir()">Ver chamada</button>
			</div>
		<?php endif; ?>
	</main>

	<script>
		function ir() {
			const data = document.getElementById('dataSelect').value;
			if (!data) return;
			window.location.href = `chamada_visualizar.php?turma=<?= (int)$id_turma ?>&data=${encodeURIComponent(data)}`;
		}
	</script>
</body>
</html>
