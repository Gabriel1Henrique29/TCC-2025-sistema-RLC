<?php // chamada.php convertido de chamada.html ?>
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
        <a href="pg1.php" class="save-button" style="text-decoration: none; width: 100px; background-color: #ccc; color: #333;">Voltar</a>
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
        let existingChamadaData = null; // Variável para armazenar os dados da chamada existente
        let alunosData = null; // Variável para armazenar a lista de alunos

        // Função para carregar os dados da turma e alunos
        function loadChamadaData() {
            fetch('../php/processar_chamada.php')
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
                        showExistingChamadaModal(); // Exibe o modal
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
                // Pega o status do mapa ou usa 'C' como padrão se não existir registro
                const currentStatus = registrosMap[aluno.id_aluno] || 'C'; 
                const statusClass = currentStatus === 'C' ? 'presente' : (currentStatus === 'F' ? 'falta' : 'atraso');

                tr.innerHTML = `
                    <td>${aluno.numero_chamada}</td>
                    <td>${aluno.nome}</td>
                    <td>
                        <button class="status-btn ${statusClass}" onclick="changeStatus(this, ${aluno.id_aluno})" data-status="${currentStatus}">${currentStatus}</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Função para mudar o status do aluno
        function changeStatus(button, alunoId) {
            const statusMap = {
                'C': { next: 'F', class: 'falta' },
                'F': { next: 'A', class: 'atraso' },
                'A': { next: 'C', class: 'presente' }
            };

            const currentStatus = button.textContent;
            const nextStatus = statusMap[currentStatus];

            // Remove todas as classes de status
            button.classList.remove('presente', 'falta', 'atraso');
            // Adiciona a nova classe
            button.classList.add(nextStatus.class);
            // Atualiza o texto
            button.textContent = nextStatus.next;

            // Armazena o status no dataset do botão
            button.dataset.status = nextStatus.next;
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
                        status: button.dataset.status,
                        observacao: '' // Pode ser implementado um campo de observação se necessário
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
                body: JSON.stringify({ chamada: chamada })
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

        // Função para redirecionar para o menu (pg1.php)
        function redirectToMenu() {
            window.location.href = 'pg1.php';
        }

        // Carrega os dados quando a página é carregada
        document.addEventListener('DOMContentLoaded', loadChamadaData);
    </script>
</body>
</html>
