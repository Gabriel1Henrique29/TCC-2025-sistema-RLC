<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    http_response_code(302);
    header('Location: ../index.html');
    exit;
}
require_once 'conexao.php';

$nivel = $_SESSION['nivel_acesso'] ?? '';
if ($nivel !== 'pedagogo' && $nivel !== 'coordenador') {
    http_response_code(403);
    echo 'Acesso negado';
    exit;
}

$id_turma = isset($_GET['id_turma']) ? (int)$_GET['id_turma'] : 0;
if ($id_turma <= 0) {
    http_response_code(400);
    echo 'Parâmetro inválido';
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
    http_response_code(403);
    echo 'Acesso negado';
    exit;
}

// Montar CSV: Data, Nº, Aluno, Status, Observação
$stmt = $conexao->prepare(
    "SELECT rp.data, a.numero_chamada, a.nome, rp.status, rp.observacao
     FROM registros_presenca rp
     JOIN alunos a ON a.id_aluno = rp.id_aluno
     WHERE rp.id_turma = :id
     ORDER BY rp.data DESC, a.numero_chamada ASC"
);
$stmt->bindParam(':id', $id_turma);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Headers
$filename = 'relatorio_turma_' . $id_turma . '_' . date('Ymd_His') . '.csv';
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename=' . $filename);

// BOM UTF-8
echo "\xEF\xBB\xBF";

$out = fopen('php://output', 'w');
fputcsv($out, ['Data', 'Nº', 'Aluno', 'Status', 'Observação'], ';');

foreach ($rows as $r) {
    fputcsv($out, [
        isset($r['data']) ? date('d/m/Y', strtotime($r['data'])) : '',
        $r['numero_chamada'] ?? '',
        $r['nome'] ?? '',
        $r['status'] ?? '',
        $r['observacao'] ?? ''
    ], ';');
}

fclose($out);
exit;

