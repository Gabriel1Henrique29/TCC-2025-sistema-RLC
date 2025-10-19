<?php // controle-adm.php convertido de controle-adm.html ?>
<?php
require_once '../php/conexao.php';
session_start();

// Carregar listas dinâmicas para cadastro rápido
// Usuários por nível de acesso
$coordenadores = $conexao->query("SELECT id_usuario, nome FROM usuarios WHERE nivel_acesso = 'coordenador' ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
$pedagogos = $conexao->query("SELECT id_usuario, nome FROM usuarios WHERE nivel_acesso = 'pedagogo' ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

// Cursos (se existirem)
$cursos = [];
try {
    $cursos = $conexao->query("SELECT id_curso, nome FROM cursos ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $cursos = [];
}

// Turmas existentes para vincular coordenador/pedagogo
$turmas = $conexao->query("SELECT id_turma, nome_turma, ano FROM turmas ORDER BY ano DESC, nome_turma ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Painel Administrativo - RLC</title>
  <link rel="stylesheet" href="../css/style.css" />
</head>
<body>
  <header id="sair">
    <a href="../php/logout.php">
      <button class="Btn">
        <div class="sign"><img src="../img/sair.png" alt="Logout" /></div>
        <div class="text">Logout</div>
      </button>
    </a>
  </header>

  <main class="container">
    <h1>Painel Administrativo</h1>

    <section>
        <div style="margin-top: 100px;">
      <h2>Inserir Nova Turma</h2>
      <form action="../php/inserir_turma.php" method="POST">
        <label for="nome_turma">Nome da Turma:</label>
        <input type="text" name="nome_turma" placeholder="Ex: 3ºJ DESENVOLVIMENTO DE SISTEMAS" required />

        <label for="ano">Ano:</label>
        <input type="number" name="ano" value="<?php echo date('Y'); ?>" required />

        <label for="id_coordenador">Coordenador (opcional):</label>
        <select name="id_coordenador">
          <option value="">Nenhum</option>
          <?php foreach ($coordenadores as $c): ?>
            <option value="<?php echo htmlspecialchars($c['id_usuario']); ?>"><?php echo htmlspecialchars($c['nome']); ?></option>
          <?php endforeach; ?>
        </select>

        <label for="id_pedagogo">Pedagogo (opcional):</label>
        <select name="id_pedagogo">
          <option value="">Nenhum</option>
          <?php foreach ($pedagogos as $p): ?>
            <option value="<?php echo htmlspecialchars($p['id_usuario']); ?>"><?php echo htmlspecialchars($p['nome']); ?></option>
          <?php endforeach; ?>
        </select>

        <button type="submit">Inserir Turma</button>
      </form>
    </section>

    <hr />

    <section>
      <h2>Inserir Usuário</h2>
      <form action="../php/inserir_usuario.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required />

        <label for="email">Email:</label>
        <input type="email" name="email" required />

        <label for="senha">Senha:</label>
        <input type="password" name="senha" required />

        <label for="nivel_acesso">Nível de Acesso:</label>
        <select name="nivel_acesso" required>
          <option value="representante">Representante</option>
          <option value="coordenador">Coordenador</option>
          <option value="pedagogo">Pedagogo</option>
          <option value="adm">Adm</option>
        </select>

        <button type="submit">Inserir Usuário</button>
      </form>
    </section>

    <section>
      <h2>Inserir Coordenador</h2>
      <form action="../php/inserir_coordenador.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required />

        <label for="id_usuario">Usuário:</label>
        <select name="id_usuario" required>
          <option value="">Selecione</option>
          <?php foreach ($coordenadores as $c): ?>
            <option value="<?php echo htmlspecialchars($c['id_usuario']); ?>"><?php echo htmlspecialchars($c['nome']); ?></option>
          <?php endforeach; ?>
        </select>

        <label for="id_curso">Curso:</label>
        <select name="id_curso" required>
          <option value="">Selecione</option>
          <?php foreach ($cursos as $curso): ?>
            <option value="<?php echo htmlspecialchars($curso['id_curso']); ?>"><?php echo htmlspecialchars($curso['nome']); ?></option>
          <?php endforeach; ?>
        </select>

        <label for="id_turma">Turma:</label>
        <select name="id_turma" required>
          <option value="">Selecione</option>
          <?php foreach ($turmas as $t): ?>
            <option value="<?php echo htmlspecialchars($t['id_turma']); ?>"><?php echo htmlspecialchars($t['nome_turma']); ?> (<?php echo htmlspecialchars($t['ano']); ?>)</option>
          <?php endforeach; ?>
        </select>

        <button type="submit">Inserir Coordenador</button>
      </form>
    </section>

    <hr />

    <section>
      <h2>Inserir Pedagogo</h2>
      <form action="../php/inserir_pedagogo.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required />

        <label for="id_usuario">Usuário:</label>
        <select name="id_usuario" required>
          <option value="">Selecione</option>
          <?php foreach ($pedagogos as $p): ?>
            <option value="<?php echo htmlspecialchars($p['id_usuario']); ?>"><?php echo htmlspecialchars($p['nome']); ?></option>
          <?php endforeach; ?>
        </select>

        <label for="id_curso">Curso:</label>
        <select name="id_curso" required>
          <option value="">Selecione</option>
          <?php foreach ($cursos as $curso): ?>
            <option value="<?php echo htmlspecialchars($curso['id_curso']); ?>"><?php echo htmlspecialchars($curso['nome']); ?></option>
          <?php endforeach; ?>
        </select>

        <label for="id_turma">Turma:</label>
        <select name="id_turma" required>
          <option value="">Selecione</option>
          <?php foreach ($turmas as $t): ?>
            <option value="<?php echo htmlspecialchars($t['id_turma']); ?>"><?php echo htmlspecialchars($t['nome_turma']); ?> (<?php echo htmlspecialchars($t['ano']); ?>)</option>
          <?php endforeach; ?>
        </select>

        <button type="submit">Inserir Pedagogo</button>
      </form>
    </div>  
    </section>

    <hr />

    <section>
      <h2>Vincular Usuário à Turma</h2>
      <form id="form-vinculo" action="../php/vincular_usuario_turma.php" method="POST">
        <label for="tipo_vinculo">Tipo de vínculo:</label>
        <select name="tipo_vinculo" id="tipo_vinculo" required>
          <option value="">Selecione</option>
          <option value="representante">Representante</option>
          <option value="coordenador">Coordenador</option>
          <option value="pedagogo">Pedagogo</option>
        </select>

        <label for="id_turma">Turma:</label>
        <select name="id_turma" id="id_turma" required>
          <option value="">Selecione</option>
          <?php foreach ($turmas as $t): ?>
            <option value="<?php echo htmlspecialchars($t['id_turma']); ?>"><?php echo htmlspecialchars($t['nome_turma']); ?> (<?php echo htmlspecialchars($t['ano']); ?>)</option>
          <?php endforeach; ?>
        </select>

        <?php $usuarios = $conexao->query("SELECT id_usuario, nome, nivel_acesso FROM usuarios ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC); ?>
        <label for="id_usuario">Usuário:</label>
        <select name="id_usuario" id="id_usuario" required>
          <option value="">Selecione</option>
          <?php foreach ($usuarios as $u): ?>
            <option value="<?php echo htmlspecialchars($u['id_usuario']); ?>" data-nivel="<?php echo htmlspecialchars($u['nivel_acesso']); ?>"><?php echo htmlspecialchars($u['nome']); ?> (<?php echo htmlspecialchars($u['nivel_acesso']); ?>)</option>
          <?php endforeach; ?>
        </select>

        <div id="grupo-aluno" style="display:none;">
          <label for="id_aluno">Aluno (apenas para representante):</label>
          <select name="id_aluno" id="id_aluno">
            <option value="">Selecione a turma primeiro</option>
          </select>
        </div>

        <button type="submit">Vincular</button>
      </form>

      <script>
        const tipoSelect = document.getElementById('tipo_vinculo');
        const turmaSelect = document.getElementById('id_turma');
        const usuarioSelect = document.getElementById('id_usuario');
        const grupoAluno = document.getElementById('grupo-aluno');
        const alunoSelect = document.getElementById('id_aluno');

        function filtrarUsuariosPorTipo() {
          const tipo = tipoSelect.value;
          Array.from(usuarioSelect.options).forEach(opt => {
            if (!opt.value) return;
            const nivel = opt.getAttribute('data-nivel');
            const mostra = !tipo || nivel === tipo;
            opt.style.display = mostra ? '' : 'none';
          });
          usuarioSelect.value = '';
        }

        function carregarAlunosDaTurma() {
          const idTurma = turmaSelect.value;
          if (!idTurma) return;
          alunoSelect.innerHTML = '<option value="">Carregando...</option>';
          fetch(`../php/listar_alunos_por_turma.php?id_turma=${encodeURIComponent(idTurma)}`)
            .then(r => r.json())
            .then(lista => {
              alunoSelect.innerHTML = '<option value="">Selecione</option>';
              lista.forEach(a => {
                const opt = document.createElement('option');
                opt.value = a.id_aluno;
                opt.textContent = `${a.numero_chamada} - ${a.nome}`;
                alunoSelect.appendChild(opt);
              });
            })
            .catch(() => {
              alunoSelect.innerHTML = '<option value="">Erro ao carregar</option>';
            });
        }

        tipoSelect.addEventListener('change', () => {
          filtrarUsuariosPorTipo();
          const ehRepresentante = tipoSelect.value === 'representante';
          grupoAluno.style.display = ehRepresentante ? '' : 'none';
          if (ehRepresentante && turmaSelect.value) carregarAlunosDaTurma();
        });

        turmaSelect.addEventListener('change', () => {
          if (tipoSelect.value === 'representante' && turmaSelect.value) carregarAlunosDaTurma();
        });

        filtrarUsuariosPorTipo();
      </script>
    </section>

    <hr />

    <section>
      <h2>Inserir Aluno</h2>
      <form action="../php/inserir_aluno.php" method="POST">
        <label for="id_turma">Turma:</label>
        <select name="id_turma" required>
          <option value="">Selecione</option>
          <?php foreach ($turmas as $t): ?>
            <option value="<?php echo htmlspecialchars($t['id_turma']); ?>"><?php echo htmlspecialchars($t['nome_turma']); ?> (<?php echo htmlspecialchars($t['ano']); ?>)</option>
          <?php endforeach; ?>
        </select>

        <label for="nome">Nome do aluno:</label>
        <input type="text" name="nome" required />

        <label for="numero_chamada">Número na chamada:</label>
        <input type="number" name="numero_chamada" min="1" required />

        <button type="submit">Inserir Aluno</button>
      </form>
    </section>
  </main>
</body>
</html>
