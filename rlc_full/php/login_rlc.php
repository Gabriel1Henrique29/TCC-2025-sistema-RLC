<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Receber dados do formulário
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        // Buscar usuário pelo email
        $sql = "SELECT id_usuario, nome, senha, nivel_acesso FROM usuarios WHERE email = :email";
        $stmt = $conexao->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se usuário encontrado
        if ($user) {
            // Verificar senha
            if (password_verify($senha, $user['senha'])) {
                $_SESSION['id_usuario'] = $user['id_usuario'];
                $_SESSION['nivel_acesso'] = $user['nivel_acesso'];
                $_SESSION['nome'] = $user['nome'];

                // Registrar log de acesso
                $log_sql = "INSERT INTO logs_acesso (id_usuario, data_acesso, acao_realizada) VALUES (:id_usuario, NOW(), 'Login realizado')";
                $log_stmt = $conexao->prepare($log_sql);
                $log_stmt->bindParam(':id_usuario', $user['id_usuario']);
                $log_stmt->execute();

                // Redirecionar conforme nível de acesso
                switch ($user['nivel_acesso']) {
                    case 'adm':
                        header("Location: ../htmls/controle-adm.php");
                        break;
                    case 'pedagogo':
                    case 'coordenador':
                        header("Location: ../htmls/pg2.php");
                        break;
                    case 'representante':
                        header("Location: ../htmls/pg1.php");
                        break;
                    default:
                        header("Location: ../htmls/pg1.php");
                }
                exit();
            } else {
                echo "<script>alert('Senha incorreta!'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Usuário não encontrado!'); window.history.back();</script>";
        }
    } catch(PDOException $e) {
        echo "<script>alert('Erro no sistema: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
?>
