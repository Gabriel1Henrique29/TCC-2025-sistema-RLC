<?php
require_once 'conexao.php';
session_start();

// Defina o id_turma e a data conforme sua lógica de sessão ou parâmetro
$id_turma = 1; // Exemplo fixo, ideal pegar da sessão ou parâmetro
$data_hoje = date('Y-m-d');

if (isset($_POST['obs']) && is_array($_POST['obs'])) {
    foreach ($_POST['obs'] as $id_aluno => $observacao) {
        // Verifica se já existe registro de presença para o aluno na data
        $sql = "SELECT id_registro FROM registros_presenca WHERE id_aluno = ? AND id_turma = ? AND data = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->execute([$id_aluno, $id_turma, $data_hoje]);
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($registro) {
            // Atualiza observação
            $sql = "UPDATE registros_presenca SET observacao = ? WHERE id_registro = ?";
            $stmt = $conexao->prepare($sql);
            $stmt->execute([$observacao, $registro['id_registro']]);
        } else {
            // Insere novo registro de presença com observação
            $sql = "INSERT INTO registros_presenca (id_aluno, id_turma, data, status, observacao) VALUES (?, ?, ?, 'presente', ?)";
            $stmt = $conexao->prepare($sql);
            $stmt->execute([$id_aluno, $id_turma, $data_hoje, $observacao]);
        }
    }
    header('Location: ../htmls/obs.php?sucesso=1');
    exit();
} else {
    header('Location: ../htmls/obs.php?erro=1');
    exit();
} 