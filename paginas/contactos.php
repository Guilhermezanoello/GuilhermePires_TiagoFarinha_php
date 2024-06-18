<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos</title>
<style>
    body {
        background-color: #001f3f;  /* Azul Marinho */
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
</style>
</head>

<body>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a class="active" href="contactos.php">Contactos</a></li>
        <li><a href="infomais.php">Info +</a></li>
        <?php
        session_start();

        if (!isset($_SESSION["tipoUtilizador"])) {
            echo '<li style="float:right"><a href="login.php">Login</a></li>';
            echo '<li style="float:right"><a href="registo.php">Regista-te</a></li>';
        } else {
            include "../basedados/basedados.h";

            $sql = "SELECT * FROM utilizador WHERE idUtilizador = " . $_SESSION["idUtilizador"];
            $result = mysqli_query($conn, $sql);
            $dados = mysqli_fetch_assoc($result);
            echo '<li style="float:right"><a href="logout.php">Logout</a></li>';
            if ($_SESSION["tipoUtilizador"] == 1) {
                echo '<li ><a href="pgLogadoAdmin.php">Menu</a></li>';
                echo '<img style="float:right" src="' . $dados["imagem"] . '" width="46" height="46" id="img">';
            } elseif ($_SESSION["tipoUtilizador"] == 2) {
                echo '<li ><a href="pgLogadoDocente.php">Menu</a></li>';
                echo '<img style="float:right" src="' . $dados["imagem"] . '" width="46" height="46" id="img">';
            } elseif ($_SESSION["tipoUtilizador"] == 3) {
                echo '<li ><a href="pgLogadoAluno.php">Menu</a></li>';
                echo '<img style="float:right" src="' . $dados["imagem"] . '" width="46" height="46" id="img">';
            }            
        }
        ?>
    </ul>
    <div id="section">
        <div class="article">
            <h1>FormaEst - Sede</h1>
            <p>Rua Professor Educação, 100 - 1 Frente<br>
                9000-100 Engenheiro Grande.<br></p>
        </div>
        <div class="article">
            <h1>Horário</h1>
            <p>Segunda a Sexta: 09:00-13:00 e 14:00-19:00<br>
                Sábado, Domingo e Feriados: Fechado<br>
            </p>
        </div>
        <div class="article">
            <h1>Email</h1>
            <p>info@formaest.pt</p>
        </div>
    </div>
    <div id="footer">
        <p>&copy; Guilherme Pires & Tiago Farinha</p>
    </div>
</body>

</html>