<?php
require_once 'conexao.php';

// Função para verificar se um aluno é representante de uma turma
function verificarRepresentante($conexao, $id_aluno, $id_turma) {
    $sql = "SELECT rt.*, u.id_usuario, u.nome as nome_usuario 
            FROM representantes_turma rt 
            JOIN usuarios u ON rt.id_usuario = u.id_usuario
            WHERE rt.id_aluno = :id_aluno 
            AND rt.id_turma = :id_turma 
            AND rt.status = 'ativo'";
    
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id_aluno', $id_aluno);
    $stmt->bindParam(':id_turma', $id_turma);
    $stmt->execute();
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Função para adicionar um representante
function adicionarRepresentante($conexao, $id_aluno, $id_turma, $id_usuario) {
    try {
        // Verifica se já existe um representante ativo para esta turma
        $sql = "SELECT * FROM representantes_turma 
                WHERE id_turma = :id_turma 
                AND status = 'ativo'";
        
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id_turma', $id_turma);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return "Já existe um representante ativo para esta turma.";
        }

        // Verifica se o usuário já é representante de outra turma
        $sql = "SELECT * FROM representantes_turma 
                WHERE id_usuario = :id_usuario 
                AND status = 'ativo'";
        
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return "Este usuário já é representante de outra turma.";
        }
        
        // Adiciona o novo representante
        $sql = "INSERT INTO representantes_turma (id_aluno, id_turma, id_usuario, data_inicio) 
                VALUES (:id_aluno, :id_turma, :id_usuario, CURDATE())";
        
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id_aluno', $id_aluno);
        $stmt->bindParam(':id_turma', $id_turma);
        $stmt->bindParam(':id_usuario', $id_usuario);
        
        if ($stmt->execute()) {
            return "Representante adicionado com sucesso!";
        } else {
            return "Erro ao adicionar representante.";
        }
    } catch(PDOException $e) {
        return "Erro: " . $e->getMessage();
    }
}

// Função para remover um representante
function removerRepresentante($conexao, $id_representante_turma) {
    try {
        $sql = "UPDATE representantes_turma 
                SET status = 'inativo', data_fim = CURDATE() 
                WHERE id_representante_turma = :id";
        
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id', $id_representante_turma);
        
        if ($stmt->execute()) {
            return "Representante removido com sucesso!";
        } else {
            return "Erro ao remover representante.";
        }
    } catch(PDOException $e) {
        return "Erro: " . $e->getMessage();
    }
}

// Função para listar representantes de uma turma
function listarRepresentantesTurma($conexao, $id_turma) {
    try {
        $sql = "SELECT rt.*, a.nome as nome_aluno, u.nome as nome_usuario 
                FROM representantes_turma rt 
                JOIN alunos a ON rt.id_aluno = a.id_aluno 
                JOIN usuarios u ON rt.id_usuario = u.id_usuario
                WHERE rt.id_turma = :id_turma 
                ORDER BY rt.status DESC, rt.data_inicio DESC";
        
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id_turma', $id_turma);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return [];
    }
}

// Função para verificar se um usuário é representante de alguma turma
function verificarUsuarioRepresentante($conexao, $id_usuario) {
    try {
        $sql = "SELECT rt.*, t.nome_turma, a.nome as nome_aluno 
                FROM representantes_turma rt 
                JOIN alunos a ON rt.id_aluno = a.id_aluno 
                JOIN turmas t ON rt.id_turma = t.id_turma 
                WHERE rt.id_usuario = :id_usuario 
                AND rt.status = 'ativo'";
        
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return null;
    }
}
?> 