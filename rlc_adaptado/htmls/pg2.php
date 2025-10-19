<?php
require_once '../php/conexao.php';
session_start();

$nivel_acesso = $_SESSION['nivel_acesso'] ?? null;
$id_usuario = $_SESSION['id_usuario'] ?? null;
$nome_usuario = $_SESSION['nome'] ?? ($_SESSION['nome_usuario'] ?? 'Usuário');

// Verificar se o usuário está logado
if (!$id_usuario) {
    header('Location: ../php/login_rlc.php');
    exit;
}

// Buscar turmas do usuário
$turmas = [];
if ($nivel_acesso === 'representante') {
    // Buscar turma que o representante representa
    $sql = "SELECT t.*, rt.id_representante_turma 
            FROM turmas t 
            JOIN representantes_turma rt ON t.id_turma = rt.id_turma 
            WHERE rt.id_usuario = :id_usuario AND rt.status = 'ativo'";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id_usuario', $id_usuario);
    $stmt->execute();
    $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Para outros níveis de acesso, buscar todas as turmas
    $sql = "SELECT * FROM turmas ORDER BY nome_turma";
    $stmt = $conexao->prepare($sql);
    $stmt->execute();
    $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios - RLC</title>
    <link rel="stylesheet" href="../css/relatorios.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .logout-link {
            background: #d32f2f;
            color: #fff !important;
            border-radius: 8px;
        }
        .logout-link:hover { background: #b71c1c; }
    </style>
</head>
<body class="relatorios-body">
    <!-- Header -->
    <header class="relatorios-header">
        <div class="header-left">
            <div class="logo-container">
                <div class="logo-box">RLC</div>
                <span class="logo-text"></span>
            </div>
            <button id="menuToggle" class="hamburger" aria-label="Abrir menu" aria-controls="sidebar" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
        <div class="header-center">
            <h1>Registro de Líderes de Classe</h1>
        </div>
        <div class="header-right">
            <div class="user-info">
                <span class="user-name"><?= htmlspecialchars($nome_usuario) ?></span>
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
            </div>
        </div>
    </header>

    <div class="main-container">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="../php/logout.php" class="nav-link logout-link">
                        <i class="fas fa-right-from-bracket"></i>
                        <span>Sair</span>
                    </a>
                </li>
                
                </li>
                
                
                <li class="nav-item active">
                    <a href="pg2.php" class="nav-link">
                        <i class="fas fa-chart-bar"></i>
                        <span>Relatórios</span>
                    </a>
                </li>
                
                </li>
                
            </ul>
            
            <div class="teaching-mode">
                <h3>Modo de Ensino</h3>
            </div>
        </nav>
        <div id="sidebarOverlay" class="sidebar-overlay" tabindex="-1" aria-hidden="true"></div>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-header">
                <h2>SELECIONAR TURMA</h2>
                <div class="institution-info">
                    <p>CENTRO EST EDUC PROFIS PEDRO B NETO</p>
                </div>
            </div>

            <!-- Year/Semester Selector -->
            <div class="year-selector">
                <button class="year-btn active">2025</button>
            </div>

            <!-- Class Cards -->
            <div class="class-cards-container">
                <?php if (empty($turmas)): ?>
                    <div class="no-classes">
                        <p>Nenhuma turma encontrada.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($turmas as $turma): ?>
                        <div class="class-card">
                            <div class="card-header">
                                <h3><?= htmlspecialchars($turma['nome_turma']) ?></h3>
                                <div class="class-info">
                                    <span class="series"><?= $turma['ano'] ?>ª Série - Tarde</span>
                                </div>
                            </div>
                            <div class="card-content">
                                <h4>Frequência</h4>
                            </div>
                            <div class="card-actions">
                                <button class="action-btn" onclick="verChamada(<?= $turma['id_turma'] ?>)">Ver chamada</button>
                                <button class="action-btn" onclick="fazerChamada(<?= $turma['id_turma'] ?>)">Fazer chamada</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="footer-info">
                <p>CEEP - PEDRO B NETO</p>
            </div>
        </main>
    </div>

    <script>
        // Toggle year buttons
        document.querySelectorAll('.year-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.year-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Menu lateral responsivo (mobile)
        const sidebar = document.getElementById('sidebar');
        const menuToggle = document.getElementById('menuToggle');
        const overlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('show');
            menuToggle.setAttribute('aria-expanded', 'true');
        }
        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
            menuToggle.setAttribute('aria-expanded', 'false');
        }
        menuToggle.addEventListener('click', () => {
            if (sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
        overlay.addEventListener('click', closeSidebar);

        // Ações de chamada
        function verChamada(idTurma) {
            window.location.href = `chamada_datas.php?turma=${idTurma}`;
        }
        function fazerChamada(idTurma) {
            window.location.href = `chamada.php?turma=${idTurma}&acao=fazer`;
        }
    </script>
</body>
</html>