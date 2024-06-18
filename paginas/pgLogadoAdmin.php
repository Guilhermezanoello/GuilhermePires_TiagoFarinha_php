<!DOCTYPE html>
<html lang="pt-br">
<?php
session_start();
if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] != 1) {
    echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=home.php">';
}
?>

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>

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
        <li><a href="contactos.php">Contactos</a></li>
        <li><a href="infomais.php">Info +</a></li>
        <li ><a class="active" href="pgLogadoAdmin.php">Menu</a></li>
        <li style="float:right"><a href="logout.php">Logout</a></li>
        <img style="float:right" src="./admin.png" width="46" height="46" id="img">
    </ul>
    <div id="section">
        <div class="article">
            <h1></h1>
            <button onclick="location.href='dados_pessoais.php'">Dados Pessoais</button>
            <p></p>
        </div>
        <div class="article">
            <h1></h1>
            <button onclick="location.href='gestao_utilizador.php'">Gestão de Utilizador</button>
            <p></p>
        </div>
        <div class="article">
            <h1></h1>
            <p></p>
        </div>
        <div class="article">
            <h1></h1>
            <button onclick="location.href='gestao_cursos.php'">Gestão de Cursos</button>
            <p></p>
        </div>
        <div class="article">
            <h1></h1>
            <button onclick="location.href='gestao_inscricoes.php'">Gestão de Inscrições</button>
            <p></p>
        </div>
    </div>
    <div id="footer">
        <p>&copy; Guilherme Pires & Tiago Farinha</p>
    </div>
</body>