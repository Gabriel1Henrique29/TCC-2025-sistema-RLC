<?php
require_once 'conexao.php';
session_start();

// Verifica se o usuário está logado e é representante
if (!isset($_SESSION['id_usuario']) || $_SESSION['nivel_acesso'] !== 'representante') {
    echo json_encode(['error' => 'Acesso não autorizado']);
    exit;
}

// Verifica se é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Verifica qual turma o representante é responsável
        $sql = "SELECT rt.id_turma, t.nome_turma 
                FROM representantes_turma rt 
                JOIN turmas t ON rt.id_turma = t.id_turma 
                WHERE rt.id_usuario = :id_usuario 
                AND rt.status = 'ativo'";
        
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id_usuario', $_SESSION['id_usuario']);
        $stmt->execute();
        $turma = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$turma) {
            echo json_encode(['error' => 'Você não é representante de nenhuma turma']);
            exit;
        }

        // Recebe os dados da chamada
        $data = json_decode(file_get_contents('php://input'), true);
        $data_chamada = date('Y-m-d');
        $id_turma = $turma['id_turma'];

        // Inicia uma transação
        $conexao->beginTransaction();

        // Para cada aluno na chamada
        foreach ($data['chamada'] as $aluno) {
            $sql = "INSERT INTO registros_presenca 
                    (id_aluno, id_turma, data, status, observacao) 
                    VALUES (:id_aluno, :id_turma, :data, :status, :observacao)";
            
            $stmt = $conexao->prepare($sql);
            $stmt->bindParam(':id_aluno', $aluno['id']);
            $stmt->bindParam(':id_turma', $id_turma);
            $stmt->bindParam(':data', $data_chamada);
            $stmt->bindParam(':status', $aluno['status']);
            $stmt->bindParam(':observacao', $aluno['observacao']);
            $stmt->execute();
        }

        // Confirma a transação
        $conexao->commit();
        echo json_encode(['success' => 'Chamada registrada com sucesso']);

    } catch(PDOException $e) {
        // Em caso de erro, desfaz a transação
        $conexao->rollBack();
        echo json_encode(['error' => 'Erro ao registrar chamada: ' . $e->getMessage()]);
    }
} else {
    // Se não for POST, retorna a lista de alunos da turma E verifica chamada existente
    try {
        // Busca a turma do representante
        $sql = "SELECT rt.id_turma, t.nome_turma 
                FROM representantes_turma rt 
                JOIN turmas t ON rt.id_turma = t.id_turma 
                WHERE rt.id_usuario = :id_usuario 
                AND rt.status = 'ativo'";
        
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id_usuario', $_SESSION['id_usuario']);
        $stmt->execute();
        $turma = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$turma) {
            echo json_encode(['error' => 'Você não é representante de nenhuma turma']);
            exit;
        }

        $id_turma = $turma['id_turma'];
        $data_hoje = date('Y-m-d');

        // Verifica se já existe chamada para esta turma hoje
        $sql_verifica_chamada = "SELECT id_registro, id_aluno, status 
                                FROM registros_presenca 
                                WHERE id_turma = :id_turma 
                                AND data = :data_hoje";
        $stmt_verifica = $conexao->prepare($sql_verifica_chamada);
        $stmt_verifica->bindParam(':id_turma', $id_turma);
        $stmt_verifica->bindParam(':data_hoje', $data_hoje);
        $stmt_verifica->execute();
        $chamada_existente = $stmt_verifica->fetchAll(PDO::FETCH_ASSOC);

        $response = [
            'turma' => $turma,
            'chamada_existente' => false // Inicialmente assume que não existe
        ];

        if ($chamada_existente) {
            // Se existe, busca os alunos com os status registrados
            $response['chamada_existente'] = true;
            $response['registros'] = $chamada_existente;

            // Busca a lista completa de alunos da turma (necessário mesmo se existir chamada para popular a tabela)
            $sql_alunos = "SELECT a.id_aluno, a.nome, a.numero_chamada 
                           FROM alunos a 
                           WHERE a.id_turma = :id_turma 
                           AND a.status = 'matricula' 
                           ORDER BY a.numero_chamada";
            $stmt_alunos = $conexao->prepare($sql_alunos);
            $stmt_alunos->bindParam(':id_turma', $id_turma);
            $stmt_alunos->execute();
            $response['alunos'] = $stmt_alunos->fetchAll(PDO::FETCH_ASSOC);

        } else {
            // Se não existe chamada para hoje, busca a lista de alunos normalmente
            $sql_alunos = "SELECT a.id_aluno, a.nome, a.numero_chamada 
                           FROM alunos a 
                           WHERE a.id_turma = :id_turma 
                           AND a.status = 'matricula' 
                           ORDER BY a.numero_chamada";
            $stmt_alunos = $conexao->prepare($sql_alunos);
            $stmt_alunos->bindParam(':id_turma', $id_turma);
            $stmt_alunos->execute();
            $alunos = $stmt_alunos->fetchAll(PDO::FETCH_ASSOC);

            // Buscar a última chamada anterior para cada aluno
            $ultimos_status = [];
            foreach ($alunos as $aluno) {
                $sql_ultimo = "SELECT status, data FROM registros_presenca 
                                WHERE id_aluno = :id_aluno AND id_turma = :id_turma AND data < :data_hoje 
                                ORDER BY data DESC LIMIT 1";
                $stmt_ultimo = $conexao->prepare($sql_ultimo);
                $stmt_ultimo->bindParam(':id_aluno', $aluno['id_aluno']);
                $stmt_ultimo->bindParam(':id_turma', $id_turma);
                $stmt_ultimo->bindParam(':data_hoje', $data_hoje);
                $stmt_ultimo->execute();
                $ultimo = $stmt_ultimo->fetch(PDO::FETCH_ASSOC);
                $ultimos_status[$aluno['id_aluno']] = $ultimo ? $ultimo['status'] : null;
            }
            $response['alunos'] = $alunos;
            $response['ultimos_status'] = $ultimos_status;
        }

        echo json_encode($response);

    } catch(PDOException $e) {
        echo json_encode(['error' => 'Erro ao buscar alunos: ' . $e->getMessage()]);
    }
}
?> 