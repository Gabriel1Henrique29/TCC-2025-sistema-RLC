<?php // controle-adm.php convertido de controle-adm.html ?>
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
        <input type="text" name="nome_turma" required />

        <label for="curso">Curso:</label>
        <select name="curso" required>
          <option value="">Selecione</option>
          <option value="Desenvolvimento de Sistemas">Desenvolvimento de Sistemas</option>
          <option value="Administração">Administração</option>
          <option value="Estética">Estética</option>
          <option value="Programação de Jogos Digitais">Programação de Jogos Digitais</option>
        </select>

        <label for="turno">Turno:</label>
        <select name="turno" required>
          <option value="Matutino">Matutino</option>
          <option value="Vespertino">Vespertino</option>
        </select>

        <label for="ano">Ano:</label>
        <input type="number" name="ano" required />

        <label for="id_coordenador">ID do Coordenador (opcional):</label>
        <input type="number" name="id_coordenador" />

        <label for="id_pedagogo">ID do Pedagogo (opcional):</label>
        <input type="number" name="id_pedagogo" />

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

        <label for="curso">Curso:</label>
        <select name="curso" required>
          <option value="Desenvolvimento de Sistemas">Desenvolvimento de Sistemas</option>
          <option value="Administração">Administração</option>
          <option value="Estética">Estética</option>
          <option value="Programação de Jogos Digitais">Programação de Jogos Digitais</option>
        </select>

        <label for="id_usuario">ID do Usuário:</label>
        <input type="number" name="id_usuario" required />

        <button type="submit">Inserir Coordenador</button>
      </form>
    </section>

    <hr />

    <section>
      <h2>Inserir Pedagogo</h2>
      <form action="../php/inserir_pedagogo.php" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required />

        <label for="id_usuario">ID do Usuário:</label>
        <input type="number" name="id_usuario" required />

        <button type="submit">Inserir Pedagogo</button>
      </form>
    </div>  
    </section>
  </main>
</body>
</html>
