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

// Observações recentes da turma
$stmt = $conexao->prepare(
    "SELECT a.numero_chamada, a.nome, rp.observacao, rp.data
     FROM registros_presenca rp
     JOIN alunos a ON a.id_aluno = rp.id_aluno
     WHERE rp.id_turma = :id
       AND rp.observacao IS NOT NULL AND rp.observacao <> ''
     ORDER BY rp.data DESC, a.numero_chamada ASC
     LIMIT 200"
);
$stmt->bindParam(':id', $id_turma);
$stmt->execute();
$observacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Observações da Turma</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/internal.css">
</head>
<body>
    <header id="sair">
        <a href="relatorios.php" class="btn" style="background:#23939d;color:#fff;">Voltar</a>
    </header>
    <main class="internal-container">
        <h1 style="text-align:center; margin-top:70px;">Observações</h1>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Nº</th>
                        <th>Aluno</th>
                        <th>Observação</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($observacoes as $obs): ?>
                    <tr>
                        <td><?= htmlspecialchars(date('d/m/Y', strtotime($obs['data']))) ?></td>
                        <td><?= htmlspecialchars($obs['numero_chamada']) ?></td>
                        <td><?= htmlspecialchars($obs['nome']) ?></td>
                        <td><?= htmlspecialchars($obs['observacao']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php if (empty($observacoes)): ?>
            <p style="text-align:center; color:#666;">Sem observações registradas.</p>
        <?php endif; ?>
    </main>
</body>
</html>

