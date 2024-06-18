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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Utilizadores</title>
    <link rel="stylesheet" href="style.css">

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

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 30px;
        background-color:  #42A5F5;  /* Cor de fundo da tabela */
        color: black;  /* Cor do texto da tabela */
    }

    th,
    td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    th {
        background-color: #42A5F5;  /* Azul Secundário */
        color: whitesmoke;  /* Brancofumado */
        text-align: center;
    }

    tr:nth-child(even) {
        background-color: #BBDEFB;  /* Azul Claro */
    }

    tr:hover {
        background-color: #1976D2;
    }
</style>

</head>

<body>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="contactos.php">Contactos</a></li>
        <li><a href="infomais.php">Info +</a></li>
        <li><a class="active" href="pgLogadoAdmin.php">Menu</a></li>
        <?php

        if (!isset($_SESSION["tipoUtilizador"])) {
            echo '<li style="float:right"><a href="login.php">Login</a></li>';
            echo '<li style="float:right"><a href="registo.php">Regista-te</a></li>';
        } else {
            echo '<li style="float:right"><a href="logout.php">Logout</a></li>';
            echo '<img style="float:right" src="./admin.png" width="46" height="46" id="img">';            
        }
        ?>
    </ul>
    <h1>Gestão de Utilizadores</h1>

    <?php
    include "../basedados/basedados.h";

    if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] != 1) {
        echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
        echo '<meta http-equiv="refresh" content="0; url=home.php">';
    }


    $sql = "SELECT * FROM utilizador";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Imagem</th>
            <th>Morada</th>
            <th>Telefone</th>
            <th>Tipo de Utilizador</th>
            <th>Ações</th>
        </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            $sql = "SELECT * FROM tipoutilizador WHERE id_Tipo = " . $row["tipoUtilizador"];
            $result2 = mysqli_query($conn, $sql);
            $descricao = mysqli_fetch_assoc($result2);

            echo "<tr>";
            echo "<td>" . $row["idUtilizador"] . "</td>";
            echo "<td>" . $row["nomeUtilizador"] . "</td>";
            echo "<td>" . $row["mail"] . "</td>";
            echo "<td>" . $row["imagem"] . "</td>";
            echo "<td>" . $row["morada"] . "</td>";
            echo "<td>" . $row["telemovel"] . "</td>";
            echo "<td>" . $descricao["descricao"] . "</td>";
            echo '<td>';
            echo '<form id="editar_inscricao" action="editar_utilizador.php" method="POST" style="display:inline;">';
            echo '<input type="hidden" name="idUtilizador" value="' . $row['idUtilizador'] . '">';
            echo '<input type="submit" value="Editar">';
            echo '</form>';
            echo ' | ';
            echo '<form id="excluir_inscricao" action="apagar_utilizador.php" method="POST" style="display:inline;">';
            echo '<input type="hidden" name="idUtilizador" value="' . $row['idUtilizador'] . '">';
            echo '<input type="submit" value="Apagar">';
            echo '</form>';
            echo '</td>';
        }

        echo "</table>";
    } else {
        echo "Nenhum registro encontrado.";
    }

    mysqli_close($conn);
    ?>

    <button onclick="location.href='adicionar_utilizador.php'">Adicionar Novo Utilizador</button>

    <div id="footer">
        <p>&copy; Guilherme Pires & Tiago Farinha</p>
    </div>
</body>

</html>