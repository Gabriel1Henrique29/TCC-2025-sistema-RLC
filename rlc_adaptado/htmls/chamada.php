<?php // chamada.php convertido de chamada.html ?>
<?php
session_start();
$nivel_acesso = $_SESSION['nivel_acesso'] ?? null;
$voltar_url = ($nivel_acesso === 'representante') ? 'pg1.php' : 'pg2.php';
$id_turma_param = isset($_GET['turma']) ? (int)$_GET['turma'] : (isset($_GET['id_turma']) ? (int)$_GET['id_turma'] : 0);
$acao_param = $_GET['acao'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chamada de Alunos</title>
    <link rel="stylesheet" href="../css/chamada.css">
    <style>
        /* Estilos para o modal de sucesso */
        .modal {
            display: none; /* Escondido por padrão */
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgba(0,0,0,0.4); 
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 300px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .modal-content h3 {
            margin-top: 0;
            color: #4CAF50;
        }

        .modal-content button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            font-size: 16px;
        }

        .modal-content button:hover {
            background-color: #45a049;
        }

        /* Mantendo os estilos de mensagem de erro para referência */
        .error-message {
            color: #f44336;
            text-align: center;
            margin: 10px 0;
            font-weight: bold;
        }
         .success-message {
            color: #4CAF50;
            text-align: center;
            margin: 10px 0;
            font-weight: bold;
        }

    </style>
</head>

<body class="chamada">
    <!-- Cabeçalho -->
    <header>
        <div class="container-logo">
            <div class="logoimagem"><img src="../img/RLClogo.jpg" alt="Logo"></div>
        </div>
    </header>

    <!-- Botão Voltar -->
    <div style="text-align: center; margin-top: 20px;">
        <a href="<?= htmlspecialchars($voltar_url) ?>" class="save-button" style="text-decoration: none; width: 100px; background-color: #ccc; color: #333;">Voltar</a>
    </div>

    <!-- Chamada de alunos -->
    <h1 class="title">Chamada de Alunos - <span id="turma-nome"></span></h1>
    <p id="data-atual" class="data-atual"></p>

    <div id="error-message" class="error-message" style="display: none;"></div>
    <div id="success-message" class="success-message" style="display: none;"></div>

    <div class="attendance-button">
        <table class="tabela-chamada">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th>Nome</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="alunos-lista">
                <!-- Alunos serão inseridos aqui via JavaScript -->
            </tbody>
        </table>
    </div>

    <button id="save-button" class="save-button" onclick="saveAttendance()">Salvar Chamada</button>

    <!-- Estrutura do Modal de Sucesso -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <h3 id="modalMessage"></h3>
            <button onclick="redirectToMenu()">OK</button>
        </div>
    </div>

    <!-- Estrutura do Modal de Chamada Existente -->
    <div id="existingChamadaModal" class="modal">
        <div class="modal-content">
            <h3>Chamada já realizada hoje!</h3>
            <p>Deseja alterar a chamada existente?</p>
            <button onclick="loadExistingChamada()">Alterar Chamada</button>
            <button onclick="cancelAlteracao()" style="background-color: #f44336;">Cancelar</button>
        </div>
    </div>

    <script>
        // Contexto da página
        const nivelAcesso = '<?= htmlspecialchars($nivel_acesso ?? '') ?>';
        const idTurma = <?= (int)$id_turma_param ?>;
        const acao = '<?= htmlspecialchars($acao_param) ?>';
        const canEdit = (nivelAcesso === 'representante' || nivelAcesso === 'pedagogo') && (acao !== 'ver');
        const readOnly = !canEdit;

        let existingChamadaData = null; // Variável para armazenar os dados da chamada existente
        let alunosData = null; // Variável para armazenar a lista de alunos

        // Mapeamentos entre enum do backend e apresentação na UI
        const enumOrder = ['presente', 'falta', 'atrasado'];
        const enumToLetter = { presente: 'C', falta: 'F', atrasado: 'A' };
        const enumToClass = { presente: 'presente', falta: 'falta', atrasado: 'atraso' };

        // Função para carregar os dados da turma e alunos
        function loadChamadaData() {
            const qs = idTurma ? `?id_turma=${encodeURIComponent(idTurma)}` : '';
            fetch('../php/processar_chamada.php' + qs)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        showError(data.error);
                        return;
                    }

                    alunosData = data.alunos; // Armazena a lista de alunos

                    document.getElementById('turma-nome').textContent = data.turma.nome_turma;
                    document.getElementById('data-atual').textContent = new Date().toLocaleDateString('pt-BR');

                    if (data.chamada_existente) {
                        existingChamadaData = data.registros; // Armazena os registros existentes
                        // Se não for representante ou estiver em modo ver, pula o modal e mostra direto em leitura
                        if (readOnly) {
                            populateAlunosTable(alunosData, existingChamadaData);
                        } else {
                            showExistingChamadaModal(); // Exibe o modal apenas para representante
                        }
                    } else {
                        populateAlunosTable(alunosData); // Popula a tabela normalmente usando a variável global
                    }
                })
                .catch(error => {
                    showError('Erro ao carregar dados: ' + error.message);
                });
        }

        // Função para popular a tabela de alunos
        function populateAlunosTable(alunos, registrosExistentes = []) {
            const tbody = document.getElementById('alunos-lista');
            tbody.innerHTML = '';

            // Cria um mapa de id_aluno para status a partir dos registros existentes
            const registrosMap = registrosExistentes.reduce((map, registro) => {
                map[registro.id_aluno] = registro.status;
                return map;
            }, {});

            alunos.forEach(aluno => {
                const tr = document.createElement('tr');
                // Enum do backend (presente|falta|atrasado). Default: 'presente'
                const currentEnum = registrosMap[aluno.id_aluno] || 'presente';
                const displayLetter = enumToLetter[currentEnum] || 'C';
                const statusClass = enumToClass[currentEnum] || 'presente';
                const onClickAttr = readOnly ? '' : `onclick="changeStatus(this, ${aluno.id_aluno})"`;
                const disabledAttr = readOnly ? 'disabled' : '';

                tr.innerHTML = `
                    <td>${aluno.numero_chamada}</td>
                    <td>${aluno.nome}</td>
                    <td>
                        <button class="status-btn ${statusClass}" ${onClickAttr} ${disabledAttr} data-status="${currentEnum}" data-aluno-id="${aluno.id_aluno}">${displayLetter}</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Função para mudar o status do aluno
        function changeStatus(button, alunoId) {
            const currentEnum = button.dataset.status || 'presente';
            const idx = enumOrder.indexOf(currentEnum);
            const nextEnum = enumOrder[(idx + 1) % enumOrder.length];

            // Atualiza classes e texto
            button.classList.remove('presente', 'falta', 'atraso');
            button.classList.add(enumToClass[nextEnum]);
            button.textContent = enumToLetter[nextEnum];

            // Atualiza dataset
            button.dataset.status = nextEnum;
            button.dataset.alunoId = alunoId;
        }

        // Função para salvar a chamada
        function saveAttendance() {
            const chamada = [];
            const rows = document.querySelectorAll('#alunos-lista tr');

            rows.forEach(row => {
                const button = row.querySelector('.status-btn');
                if (button) {
                    chamada.push({
                        id: button.dataset.alunoId,
                        status: button.dataset.status, // enum do backend
                        observacao: ''
                    });
                }
            });

            if (chamada.length === 0) {
                showError('Nenhum aluno foi marcado na chamada');
                return;
            }

            // Precisamos adicionar a lógica aqui para saber se é INSERIR ou ALTERAR
            // Por enquanto, mantém a lógica de POST que o PHP vai lidar com a inserção (ou erro de duplicidade)

            fetch('../php/processar_chamada.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ chamada: chamada, id_turma: idTurma || null })
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    showError(data.error);
                } else {
                    showSuccess('Chamada realizada!'); // Chamada para mostrar o modal de sucesso
                }
            })
            .catch(error => {
                showError('Erro ao salvar chamada: ' + error.message);
            });
        }

        // Funções auxiliares para mostrar mensagens e modais
        function showError(message) {
            const errorDiv = document.getElementById('error-message');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
            document.getElementById('success-message').style.display = 'none';
            document.getElementById('successModal').style.display = 'none';
            document.getElementById('existingChamadaModal').style.display = 'none'; // Esconder modal existente
        }

        function showSuccess(message) {
            const modal = document.getElementById('successModal');
            const modalMessage = document.getElementById('modalMessage');

            modalMessage.textContent = message;
            modal.style.display = 'flex';

            document.getElementById('error-message').style.display = 'none';
            document.getElementById('success-message').style.display = 'none';
            document.getElementById('existingChamadaModal').style.display = 'none'; // Esconder modal existente
        }

        function showExistingChamadaModal() {
            if (readOnly) return; // segurança extra: não mostrar modal para não-representante
            const modal = document.getElementById('existingChamadaModal');
            modal.style.display = 'flex';
        }

        function loadExistingChamada() {
            document.getElementById('existingChamadaModal').style.display = 'none'; // Esconder modal
            // Popula a tabela com os dados existentes usando as variáveis globais
            // Certifica-se que alunosData e existingChamadaData estão disponíveis
            if (alunosData && existingChamadaData) {
                populateAlunosTable(alunosData, existingChamadaData); 
            } else {
                // O que fazer se os dados não estiverem disponíveis? Talvez recarregar?
                // Por enquanto, exibe um erro (isso não deve acontecer se o PHP retornou dados existentes)
                showError('Erro ao carregar dados da chamada existente.');
            }
        }

        function cancelAlteracao() {
            document.getElementById('existingChamadaModal').style.display = 'none'; // Esconder modal
            // O que fazer ao cancelar? Redirecionar para o menu ou ficar na página?
            // Vou deixar na página por enquanto, mas pode redirecionar se preferir:
            // redirectToMenu(); 
        }

        // Função para redirecionar para o menu (dinâmico por nível de acesso)
        function redirectToMenu() {
            window.location.href = '<?= htmlspecialchars($voltar_url) ?>';
        }

        // Carrega os dados quando a página é carregada e ajusta UI de acordo com perfil/ação
        document.addEventListener('DOMContentLoaded', function() {
            if (readOnly) {
                const saveBtn = document.getElementById('save-button');
                if (saveBtn) saveBtn.style.display = 'none';
            }
            loadChamadaData();
        });
    </script>
</body>
</html>
