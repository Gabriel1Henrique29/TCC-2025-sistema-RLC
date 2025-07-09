<?php // obs.php convertido de obs.html ?>
<?php
require_once '../php/conexao.php';
session_start();

$id_turma = 1; // valor padrão
$nivel_acesso = $_SESSION['nivel_acesso'] ?? null;
$id_usuario = $_SESSION['id_usuario'] ?? null;

// Se for representante, buscar a turma que ele representa
if ($nivel_acesso === 'representante' && $id_usuario) {
    $stmt = $conexao->prepare("SELECT id_turma FROM representantes_turma WHERE id_usuario = ? AND status = 'ativo' LIMIT 1");
    $stmt->execute([$id_usuario]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $id_turma = $row['id_turma'];
    } else {
        ?>
        <style>
        .custom-modal-overlay {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(0,0,0,0.6);
            display: flex; align-items: center; justify-content: center;
            z-index: 9999;
        }
        .custom-modal {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.25);
            padding: 32px 24px;
            max-width: 90vw;
            width: 350px;
            text-align: center;
            font-family: 'Segoe UI', Arial, sans-serif;
            animation: popIn 0.3s;
        }
        .custom-modal h2 {
            color: #d32f2f;
            margin-bottom: 16px;
        }
        .custom-modal button {
            background: #1976d2;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 10px 28px;
            font-size: 1rem;
            margin-top: 18px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .custom-modal button:hover {
            background: #1565c0;
        }
        @keyframes popIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
        </style>
        <div class="custom-modal-overlay">
            <div class="custom-modal">
                <h2>Acesso Restrito</h2>
                <p>Você não é representante ativo de nenhuma turma.</p>
                <button onclick="window.location.href='pg1.php'">OK</button>
            </div>
        </div>
        <?php
        exit;
    }
}

// Data selecionada (GET ou padrão hoje)
$data_hoje = date('Y-m-d');
$data_selecionada = $_GET['data'] ?? $data_hoje;

$alunos = $conexao->query("SELECT id_aluno, nome, numero_chamada, status FROM alunos WHERE id_turma = $id_turma ORDER BY numero_chamada")->fetchAll(PDO::FETCH_ASSOC);
$obs_stmt = $conexao->prepare("SELECT id_aluno, observacao FROM registros_presenca WHERE id_turma = ? AND data = ?");
$obs_stmt->execute([$id_turma, $data_selecionada]);
$obs_map = [];
foreach ($obs_stmt as $row) {
    $obs_map[$row['id_aluno']] = $row['observacao'];
}
$editavel = ($data_selecionada === $data_hoje);

// Buscar dados da turma
$turma_stmt = $conexao->prepare("SELECT t.nome_turma, t.ano, u1.nome as nome_coordenador, u2.nome as nome_pedagogo FROM turmas t
    LEFT JOIN usuarios u1 ON t.id_coordenador = u1.id_usuario
    LEFT JOIN usuarios u2 ON t.id_pedagogo = u2.id_usuario
    WHERE t.id_turma = ? LIMIT 1");
$turma_stmt->execute([$id_turma]);
$turma = $turma_stmt->fetch(PDO::FETCH_ASSOC);

// Extrair curso e turno do nome_turma (exemplo: '3ºJ DESENVOLVIMENTO DE SISTEMAS')
$curso = $turno = '';
if ($turma && preg_match('/([0-9ºA-Z]+) (.+)/u', $turma['nome_turma'], $m)) {
    $turma_nome = $m[1];
    $resto = $m[2];
    $curso = $resto;
    // Exemplo: se quiser definir turno manualmente, pode usar um array ou lógica extra
    $turno = 'Tarde'; // ou buscar de outro campo se existir
} else {
    $turma_nome = $turma['nome_turma'] ?? '';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Observações da Turma</title>
    <style>
    .voltar-btn {
        background: #1976d2;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 8px 22px;
        font-size: 1rem;
        margin-bottom: 18px;
        cursor: pointer;
        transition: background 0.2s;
        margin-right: 10px;
    }
    .voltar-btn:hover { background: #1565c0; }
    .date-picker { font-size: 1rem; padding: 6px 10px; border-radius: 6px; border: 1px solid #ccc; }
    </style>
</head>
<body class="obs">
    <header class="obs-header">
        <div class="obs-header-row">
            <button class="voltar-btn" onclick="window.location.href='pg1.php'">
                <span style="font-size:1.3em;vertical-align:middle;">&#8592;</span> Voltar
            </button>
            <h1>Observações da Turma</h1>
        </div>
    </header>
    <main class="obs-main-container">
        <div class="turma-info-card">
            <div>Turma: <b><?= htmlspecialchars($turma_nome) ?></b> | Curso: <b><?= htmlspecialchars($curso) ?></b> | Turno: <b><?= htmlspecialchars($turno) ?></b></div>
            <div>Pedagoga Responsável: <b><?= htmlspecialchars($turma['nome_pedagogo'] ?? '---') ?></b> | Coordenadora de Curso: <b><?= htmlspecialchars($turma['nome_coordenador'] ?? '---') ?></b></div>
        </div>
        <form method="get" class="obs-date-form">
            <label for="data" class="obs-date-label">Selecionar data:</label>
            <input class="date-picker" type="date" id="data" name="data" value="<?= htmlspecialchars($data_selecionada) ?>" max="<?= $data_hoje ?>" onchange="this.form.submit()">
        </form>
        <?php if (isset($_GET['sucesso'])): ?>
            <div class="success-message">Observações salvas com sucesso!</div>
        <?php elseif (isset($_GET['erro'])): ?>
            <div class="error-message">Erro ao salvar observações!</div>
        <?php endif; ?>
        <form method="post" action="../php/salvar_obs.php<?= $editavel ? '' : '?data=' . urlencode($data_selecionada) ?>" class="obs-table-form">
            <div class="obs-table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Nº</th>
                            <th class="nome-col">Nome</th>
                            <th>Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($alunos as $aluno): ?>
                        <tr<?php if ($aluno['status'] == 'transferido') echo ' class="transferido"'; ?>>
                            <td><?= htmlspecialchars($aluno['numero_chamada']) ?></td>
                            <td class="nome-col"><?= htmlspecialchars($aluno['nome']) ?></td>
                            <td>
                                <?php if ($aluno['status'] == 'transferido'): ?>
                                    TRANSFERIDO
                                <?php else: ?>
                                    <input type="text" name="obs[<?= $aluno['id_aluno'] ?>]" value="<?= htmlspecialchars($obs_map[$aluno['id_aluno']] ?? '') ?>" placeholder="Fazer Observação" <?= $editavel ? '' : 'readonly style="background:#f3f3f3; color:#888;"' ?> >
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php if ($editavel): ?>
                <div class="obs-salvar-wrapper"><button type="submit" class="salvar">Salvar</button></div>
            <?php else: ?>
                <div style="margin: 16px 0; color: #1976d2; font-weight: bold; text-align:center;">Observações apenas para leitura nesta data.</div>
            <?php endif; ?>
        </form>
        <footer class="obs-footer">
            Última atualização: <?= date('d/m/Y', strtotime($data_selecionada)) ?>
        </footer>
    </main>
</body>
</html>
