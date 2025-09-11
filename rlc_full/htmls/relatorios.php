<?php // relatorios.php convertido de relatorios.html
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.html');
    exit;
}

require_once '../php/conexao.php';

$nivel = $_SESSION['nivel_acesso'] ?? '';
$usuarioId = $_SESSION['id_usuario'];

// Apenas pedagogo ou coordenador
if ($nivel !== 'pedagogo' && $nivel !== 'coordenador') {
    header('Location: pg2.php');
    exit;
}

// Buscar turmas vinculadas ao usuário logado
if ($nivel === 'pedagogo') {
    $sql = "SELECT t.id_turma, t.nome_turma, t.ano,
            (SELECT COUNT(*) FROM alunos a WHERE a.id_turma = t.id_turma) AS total_alunos,
            u1.nome AS nome_coordenador, u2.nome AS nome_pedagogo
        FROM turmas t
        LEFT JOIN usuarios u1 ON t.id_coordenador = u1.id_usuario
        LEFT JOIN usuarios u2 ON t.id_pedagogo = u2.id_usuario
        WHERE t.id_pedagogo = :id_usuario
        ORDER BY t.nome_turma";
} else {
    $sql = "SELECT t.id_turma, t.nome_turma, t.ano,
            (SELECT COUNT(*) FROM alunos a WHERE a.id_turma = t.id_turma) AS total_alunos,
            u1.nome AS nome_coordenador, u2.nome AS nome_pedagogo
        FROM turmas t
        LEFT JOIN usuarios u1 ON t.id_coordenador = u1.id_usuario
        LEFT JOIN usuarios u2 ON t.id_pedagogo = u2.id_usuario
        WHERE t.id_coordenador = :id_usuario
        ORDER BY t.nome_turma";
}

$stmt = $conexao->prepare($sql);
$stmt->bindParam(':id_usuario', $usuarioId);
$stmt->execute();
$turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios - Minhas Turmas</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/internal.css">
</head>
<body>
    <header id="sair">
        <a href="../php/logout.php">
            <button class="Btn">
                <div class="sign"><img src="../img/sair.png" alt="Logout"></div>
                <div class="text">Logout</div>
            </button>
        </a>
    </header>
    <main class="internal-container">
        <h1 style="text-align:center; margin-top:70px;">Minhas Turmas</h1>
        <?php if (empty($turmas)): ?>
            <p style="text-align:center; color:#666;">Nenhuma turma vinculada ao seu usuário.</p>
        <?php else: ?>
            <section class="cards-grid">
                <?php foreach ($turmas as $turma): ?>
                    <article class="card">
                        <h2 style="margin-top:0; color:#23939d;">
                            <?= htmlspecialchars($turma['nome_turma']) ?>
                        </h2>
                        <p><b>Ano:</b> <?= htmlspecialchars($turma['ano']) ?></p>
                        <p><b>Total de alunos:</b> <?= (int)$turma['total_alunos'] ?></p>
                        <p><b>Coordenador(a):</b> <?= htmlspecialchars($turma['nome_coordenador'] ?? '—') ?></p>
                        <p><b>Pedagogo(a):</b> <?= htmlspecialchars($turma['nome_pedagogo'] ?? '—') ?></p>
                        <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:10px;">
                            <a class="btn btn-primary" href="relatorios_detalhes.php?id_turma=<?= (int)$turma['id_turma'] ?>">Detalhes</a>
                            <a class="btn btn-secondary" href="relatorios_observacoes.php?id_turma=<?= (int)$turma['id_turma'] ?>">Observações</a>
                            <a class="btn" style="background:#28a745;color:#fff;" href="../php/exportar_relatorio_csv.php?id_turma=<?= (int)$turma['id_turma'] ?>">Exportar CSV</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>