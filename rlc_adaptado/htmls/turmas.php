<?php // turmas.php convertido de turmas.html ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turmas - RLC</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Minhas Turmas</h1>
        
        <div class="turmas-container">
            <?php
            require_once '../php/conexao.php';
            session_start();
            
            // Verifica se o usuário está logado e é uma pedagoga
            if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo_usuario'] != 'pedagoga') {
                header('Location: login.php');
                exit();
            }
            
            $pedagoga_id = $_SESSION['usuario_id'];
            
            // Busca as turmas relacionadas à pedagoga
            $sql = "SELECT t.*, c.nome as curso_nome 
                    FROM turmas t 
                    INNER JOIN cursos c ON t.curso_id = c.id 
                    WHERE t.pedagoga_id = :pedagoga_id";
            
            try {
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':pedagoga_id', $pedagoga_id);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    while ($turma = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<div class="turma-card">';
                        echo '<h3>Turma: ' . htmlspecialchars($turma['nome']) . '</h3>';
                        echo '<p>Curso: ' . htmlspecialchars($turma['curso_nome']) . '</p>';
                        echo '<p>Período: ' . htmlspecialchars($turma['periodo']) . '</p>';
                        echo '<p>Turno: ' . htmlspecialchars($turma['turno']) . '</p>';
                        echo '<a href="detalhes_turma.php?id=' . $turma['id'] . '" class="btn">Ver Detalhes</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="no-turmas">Você não possui turmas atribuídas no momento.</p>';
                }
            } catch(PDOException $e) {
                echo '<p class="error">Erro ao buscar turmas: ' . $e->getMessage() . '</p>';
            }
            ?>
        </div>
    </div>
</body>
</html>