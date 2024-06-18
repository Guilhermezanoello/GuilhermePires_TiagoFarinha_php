<?php
include "../basedados/basedados.h";

session_start();
if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] <1 || $_SESSION["tipoUtilizador"] >3) {
    echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=home.php">';
}

$sql = "SELECT * FROM utilizador WHERE idUtilizador = " . $_SESSION["idUtilizador"];
$result = mysqli_query($conn, $sql);
$dadosUsuario = mysqli_fetch_assoc($result);

$nomeUtilizador = $dadosUsuario["nomeUtilizador"];
$mail = $dadosUsuario["mail"];
$imagem = $dadosUsuario["imagem"];
$morada = $dadosUsuario["morada"];
$telemovel = $dadosUsuario["telemovel"];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dados Pessoais</title>
<style>
    body {
        background-color: #001f3f;  /* Azul Marinho */
    }
        label {
            display: block;
            margin-top: 10px;
        }

        ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #42A5F5;  /* Azul Secundário */
    }
    
    li {
        float: left;
    }
    
    li a {
        display: block;
        color: whitesmoke;  /* Brancofumado */
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-weight: bold;  
    }
    
    li a:hover:not(.active) {
        background-color: #BBDEFB;  /* Azul Claro */
    }

    .active {
        background-color: #1976D2;  /* Azul Escuro */
    }

    #conteudo-principal {
        margin-bottom: 80px;
        /* Ajuste o valor conforme necessário */
    }

    .footer-space {
        height: 50px;
    }
    </style>
</head>

<body>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="contactos.php">Contactos</a></li>
        <li><a href="infomais.php">Info +</a></li>
        <?php 
        if ($_SESSION["tipoUtilizador"] == 1) {
            echo '<li ><a href="pgLogadoAdmin.php">Menu</a></li>';
        } elseif ($_SESSION["tipoUtilizador"] == 2) {
            echo '<li ><a href="pgLogadoDocente.php">Menu</a></li>';
        } elseif ($_SESSION["tipoUtilizador"] == 3) {
            echo '<li ><a href="pgLogadoAluno.php">Menu</a></li>';
        }
        echo '<li style="float:right"><a href="logout.php">Logout</a></li>';
        echo '<img style="float:right" src="' . $dadosUsuario["imagem"] . '" width="46" height="46" id="img">';
    
        ?>
    </ul>
    <h1>Dados Pessoais</h1>
    <div id="conteudo-principal">
        <form action="atualizar_dados.php" method="POST">
            <label for="nomeUtilizador">Nome de Usuário:</label>
            <input type="text" id="nomeUtilizador" name="nomeUtilizador" value="<?php echo $nomeUtilizador; ?>" readonly>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha"><br>

            <label for="mail">Email:</label>
            <input type="email" id="mail" name="mail" value="<?php echo $mail; ?>">

            <label for="imagem">Imagem:</label>
            <input type="text" id="imagem" name="imagem" value="<?php echo $imagem; ?>">

            <label for="morada">Morada:</label>
            <input type="text" id="morada" name="morada" value="<?php echo $morada; ?>">

            <label for="telemovel">Telemóvel:</label>
            <input type="text" id="telemovel" name="telemovel" value="<?php echo $telemovel; ?>">

            <input type="submit" value="Atualizar">
        </form>
    </div>
    <div id="footer">
        <p>&copy; Guilherme Pires & Tiago Farinha</p>
    </div>
</body>

</html>