<?php // pg2.php convertido de pg2.html
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: ../index.html');
    exit;
}
$nivel = $_SESSION['nivel_acesso'] ?? '';
if ($nivel !== 'pedagogo' && $nivel !== 'coordenador') {
    header('Location: ../index.html');
    exit;
}
?>
<!--pg2.html e para as pedagogas e cordenadores --> 
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RLC</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="home">
        <header id="sair">
            <a href="../php/logout.php">
            <button class="Btn">
                <div class="sign"><img src="../img/sair.png"></div>
                <div class="text">Logout</div>
            </button>
        </a>
        </header>
        <article>
            <div class="responsive-container">
                <div class="responsive-box box1"><a href="./turmas.php"> TURMAS </a></div>
                <div class="responsive-box box2"><a href="./relatorios.php"> RELATORIOS </a></div>
            </div>
        </article>
</body>
</html>