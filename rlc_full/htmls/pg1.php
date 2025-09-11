<?php // pg1.php convertido de pg1.html
session_start();
if (!isset($_SESSION['id_usuario']) || ($_SESSION['nivel_acesso'] ?? null) !== 'representante') {
    header('Location: ../index.html');
    exit;
}
?>
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
                <div class="sign"><img src="../img/sair.png" alt="Logout"></div>
                <div class="text">Logout</div>
            </button>
        </a>
        </header>
        <article>
            <div class="responsive-container">
                <div class="responsive-box box1"><a href="./chamada.php"> CHAMADA </a></div>
                <div class="responsive-box box2"><a href="./obs.php"> OBSERVAÇÕES </a></div>
            </div>
        </article>
</body>
</html>
