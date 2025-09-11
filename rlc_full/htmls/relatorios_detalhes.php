<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.html');
    exit;
}
require_once '../php/conexao.php';

$nivel = $_SESSION['nivel_acesso'] ?? '';
if ($nivel !== 'pedagogo' && $nivel !== 'coordenador') {
    header('Location: pg2.php');
    exit;
}

$id_turma = isset($_GET['id_turma']) ? (int)$_GET['id_turma'] : 0;
if ($id_turma <= 0) {
    header('Location: relatorios.php');
    exit;
}

// Garantir que a turma pertence ao usuário logado
if ($nivel === 'pedagogo') {
    $check = $conexao->prepare('SELECT 1 FROM turmas WHERE id_turma = :id AND id_pedagogo = :uid');
} else {
    $check = $conexao->prepare('SELECT 1 FROM turmas WHERE id_turma = :id AND id_coordenador = :uid');
}
$check->bindParam(':id', $id_turma);
$check->bindParam(':uid', $_SESSION['id_usuario']);
$check->execute();
if (!$check->fetch()) {
    header('Location: relatorios.php');
    exit;
}

// Dados da turma
$stmtTurma = $conexao->prepare("SELECT t.*, 
    (SELECT COUNT(*) FROM alunos a WHERE a.id_turma = t.id_turma) AS total_alunos
    FROM turmas t WHERE t.id_turma = :id");
$stmtTurma->bindParam(':id', $id_turma);
$stmtTurma->execute();
$turma = $stmtTurma->fetch(PDO::FETCH_ASSOC);

// Últimas presenças por aluno (última data)
$stmt = $conexao->prepare(
    "SELECT a.id_aluno, a.nome, a.numero_chamada,
            rp.status, rp.data
     FROM alunos a
     LEFT JOIN registros_presenca rp
       ON rp.id_aluno = a.id_aluno AND rp.id_turma = a.id_turma
     WHERE a.id_turma = :id
     GROUP BY a.id_aluno
     ORDER BY a.numero_chamada"
);
$stmt->bindParam(':id', $id_turma);
$stmt->execute();
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Turma</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/internal.css">
</head>
<body>
    <header id="sair">
        <a href="relatorios.php" class="btn" style="background:#23939d;color:#fff;">Voltar</a>
    </header>
    <main class="internal-container">
        <h1 style="text-align:center; margin-top:70px;">Detalhes - <?= htmlspecialchars($turma['nome_turma'] ?? '') ?></h1>
        <section class="card" style="margin: 0 auto; max-width:900px;">
            <p><b>Ano:</b> <?= htmlspecialchars($turma['ano'] ?? '') ?></p>
            <p><b>Total de alunos:</b> <?= (int)($turma['total_alunos'] ?? 0) ?></p>
        </section>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Aluno</th>
                        <th>Último status</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($alunos as $aluno): ?>
                    <tr>
                        <td><?= htmlspecialchars($aluno['numero_chamada']) ?></td>
                        <td><?= htmlspecialchars($aluno['nome']) ?></td>
                        <td><?= htmlspecialchars($aluno['status'] ?? '—') ?></td>
                        <td><?= htmlspecialchars(isset($aluno['data']) ? date('d/m/Y', strtotime($aluno['data'])) : '—') ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>

