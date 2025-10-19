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
$data = isset($_GET['data']) ? $_GET['data'] : '';

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

if ($id_turma <= 0 || !$data) {
	echo '<script>alert("Turma ou data inválida."); history.back();</script>';
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

// Busca alunos da turma e status na data
$alunos_stmt = $conexao->prepare("SELECT a.id_aluno, a.nome, a.numero_chamada FROM alunos a WHERE a.id_turma = :id_turma AND a.status = 'matricula' ORDER BY a.numero_chamada");
$alunos_stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT);
$alunos_stmt->execute();
$alunos = $alunos_stmt->fetchAll(PDO::FETCH_ASSOC);

$regs_stmt = $conexao->prepare('SELECT id_aluno, status FROM registros_presenca WHERE id_turma = :id_turma AND data = :data');
$regs_stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT);
$regs_stmt->bindParam(':data', $data);
$regs_stmt->execute();
$regs = $regs_stmt->fetchAll(PDO::FETCH_KEY_PAIR);

function statusClass($s) { return $s === 'presente' ? 'presente' : ($s === 'falta' ? 'falta' : 'atraso'); }
function statusLetter($s) { return $s === 'presente' ? 'C' : ($s === 'falta' ? 'F' : ($s === 'atrasado' ? 'A' : 'C')); }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Chamada do dia</title>
	<link rel="stylesheet" href="../css/chamada.css">
	<style>
		.print-button {
			background-color: #1976d2;
			color: #fff;
			padding: 10px 16px;
			border: none;
			border-radius: 8px;
			cursor: pointer;
			margin-left: 8px;
		}
		.print-button:hover { background-color: #1565c0; }

		@media print {
			header, .back-button, .print-button { display: none !important; }
			.table-responsive { overflow: visible; }
			body { background: #fff; }
			.tabela-chamada { max-width: 100%; width: 100%; }
			.title { margin-top: 0; }
		}
	</style>
</head>
<body class="chamada">
	<header>
		<div class="container-logo">
			<div class="logoimagem"><img src="../img/RLClogo.jpg" alt="Logo"></div>
		</div>
	</header>

    <div style="text-align: center; margin-top: 12px;">
        <a href="chamada_datas.php?turma=<?= (int)$id_turma ?>" class="back-button">Voltar</a>
        <button class="print-button" onclick="window.print()">Imprimir</button>
    </div>

	<h1 class="title">Chamada de Alunos - <span><?= htmlspecialchars($turma_info['nome_turma'] ?? '') ?></span></h1>
	<p class="data-atual">Data: <?= date('d/m/Y', strtotime($data)) ?></p>

    <div class="attendance-button table-responsive">
        <table class="tabela-chamada">
			<thead>
				<tr>
					<th>Nº</th>
					<th>Nome</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($alunos as $aluno): $stat = $regs[$aluno['id_aluno']] ?? null; $letter = statusLetter($stat); $cls = statusClass($stat); ?>
				<tr>
					<td><?= htmlspecialchars((string)$aluno['numero_chamada']) ?></td>
					<td><?= htmlspecialchars($aluno['nome']) ?></td>
					<td><button class="status-btn <?= $cls ?>" disabled><?= $letter ?></button></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</body>
</html>
