<?php
session_start();
if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] != 1) {
    echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=home.php">';
}
// Inclua o arquivo basedados.h
include "../basedados/basedados.h";

// Verifique se o ID do utilizador foi passado por parâmetro
if (isset($_POST["idUtilizador"])) {
    $idUtilizador = $_POST["idUtilizador"];

    // Consulta para obter os dados do utilizador pelo ID
    $sql = "SELECT * FROM utilizador WHERE idUtilizador = $idUtilizador";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        $sql = "SELECT * FROM tipoutilizador ";
        $result2 = mysqli_query($conn, $sql);

        // Formulário com os dados
        echo '
            <!DOCTYPE html>
            <html lang="pt-br">
            
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Editar Utilizador</title>
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
                    font-weight: bold;  /* Deixa o texto em negrito */
                }
                
                li a:hover:not(.active) {
                    background-color: #BBDEFB;  /* Azul Claro */
                }
            
                .active {
                    background-color: #1976D2;  /* Azul Escuro */
                }

                #conteudo-principal {
                    margin-bottom: 80px;
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
                <li ><a class="active" href="pgLogadoAdmin.php">Menu</a></li>
                <li style="float:right"><a href="logout.php">Logout</a></li>
                <img style="float:right" src="./admin.png" width="46" height="46" id="img">
            </ul>
                <h1>Editar Utilizador</h1>
                <div id="conteudo-principal">
                <form action="atualizar_utilizador.php" method="POST">
                    <input type="hidden" name="idUtilizador" value="' . $row["idUtilizador"] . '">
            
                    <label for="nome">Nome:</label>
                    <input type="text" name="nome" id="nome" value="' . $row["nomeUtilizador"] . '"readonly>
                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha"><br>
            
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="' . $row["mail"] . '">
            
                    <label for="imagem">Imagem:</label>
                    <input type="text" name="imagem" id="imagem" value="' . $row["imagem"] . '">
            
                    <label for="morada">Morada:</label>
                    <input type="text" name="morada" id="morada" value="' . $row["morada"] . '">
            
                    <label for="telefone">Telefone:</label>
                    <input type="text" name="telefone" id="telefone" value="' . $row["telemovel"] . '">
            
                    <label for="tipo">Tipo de Utilizador:</label><br>
                    <select name="tipo" id="tipo">';
        foreach ($result2 as $tipo) {
            if ($tipo['id_Tipo'] == $row["tipoUtilizador"]) {
                echo '<option value="' . $tipo["id_Tipo"] . '" selected>' . $tipo["descricao"] . '</option>';
            } else {
                echo '<option value="' . $tipo["id_Tipo"] . '">' . $tipo["descricao"] . '</option>';
            }
        }
        echo '</select> <br>            
                    <input type="submit" value="Atualizar">
                </form>
                </div>
                <div id="footer" class="footer-space">
                    <p>&copy; Guilherme Pires & Tiago Farinha</p>
                </div>
            </body>
            
            </html>
            ';
    } else {
        echo "Utilizador não encontrado.";
    }

    mysqli_close($conn);
} else {
    echo "ID do utilizador não fornecido.";
}
