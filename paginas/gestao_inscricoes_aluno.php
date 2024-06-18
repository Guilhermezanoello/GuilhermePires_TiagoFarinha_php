<!DOCTYPE html>
<html lang="pt-br">

<?php
session_start();
if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] != 3) {
    echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=home.php">';
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Inscrições</title>
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
        <li><a class="active" href="pgLogadoAluno.php">Menu</a></li>
        <?php
        include "../basedados/basedados.h";

        $sql2 = "SELECT * FROM utilizador WHERE idUtilizador = " . $_SESSION["idUtilizador"];
        $result2 = mysqli_query($conn, $sql2);
        $dados = mysqli_fetch_assoc($result2);

        if (!isset($_SESSION["tipoUtilizador"])) {
            echo '<li style="float:right"><a href="login.php">Login</a></li>';
            echo '<li style="float:right"><a href="registo.php">Regista-te</a></li>';
        } else {
            echo '<li style="float:right"><a href="logout.php">Logout</a></li>';
            echo '<img style="float:right" src="' . $dados["imagem"] . '" width="46" height="46" id="img">';
        }
        ?>
    </ul>

    <h1>Gestão de Inscrições</h1>

    <?php

    // Função para exibir todas as inscrições do usuário logado
    function exibirInscricoes($connection, $idUtilizador)
    {
        // SQL para selecionar as inscrições do usuário logado
        $sql = "SELECT i.id_inscricao, u.nomeUtilizador AS aluno, c.titulo AS curso, i.data_inscricao,
                       si.desc AS status_inscricao_descricao
                FROM inscricoes i
                INNER JOIN utilizador u ON i.id_aluno = u.idUtilizador
                INNER JOIN cursos c ON i.id_curso = c.id_curso
                INNER JOIN status_inscricao si ON i.status_inscricao = si.id_status_inscricao
                WHERE u.idUtilizador = ?
                ORDER BY i.id_inscricao";
        
        // Prepara a declaração SQL
        $stmt = mysqli_prepare($connection, $sql);

        // Vincula o parâmetro idUtilizador ao marcador de posição
        mysqli_stmt_bind_param($stmt, "i", $idUtilizador);

        // Executa a declaração preparada
        mysqli_stmt_execute($stmt);

        // Obtem o resultado da declaração preparada
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            echo '<table>';
            echo '<tr><th>ID</th><th>Aluno</th><th>Curso</th><th>Data de Inscrição</th>
                      <th>Status da Inscrição</th><th>Ações</th></tr>';
                      while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['id_inscricao'] . '</td>';
                        echo '<td>' . $row['aluno'] . '</td>';
                        echo '<td>' . $row['curso'] . '</td>';
                        echo '<td>' . $row['data_inscricao'] . '</td>';
                        echo '<td>' . $row['status_inscricao_descricao'] . '</td>';
                        echo '<td>';
                        echo '<form id="editar_inscricao" action="editar_inscricao_aluno.php" method="POST" style="display:inline;">';
                        echo '<input type="hidden" name="idInscricao" value="' . $row['id_inscricao'] . '">';
                        echo '<input type="submit" value="Editar">';
                        echo '</form>';
                        echo ' | ';
                        echo '<form id="excluir_inscricao" action="excluir_inscricao_aluno.php" method="POST" style="display:inline;">';
                        echo '<input type="hidden" name="idInscricao" value="' . $row['id_inscricao'] . '">';
                        echo '<input type="submit" value="Excluir">';
                        echo '</form>';
                        echo '</td>';
                        echo '</tr>';
            }
            echo '</table>';
        } else {
            echo 'Nenhuma inscrição encontrada.';
        }
    }

    // Verifica se o usuário está logado e obter o idUtilizador da sessão
    if (isset($_SESSION["tipoUtilizador"]) && $_SESSION["tipoUtilizador"] == 3 && isset($_SESSION["idUtilizador"])) {
        $idUtilizador = $_SESSION["idUtilizador"];
        exibirInscricoes($conn, $idUtilizador);
    } else {
        echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
        echo '<meta http-equiv="refresh" content="0; url=home.php">';
    }

    ?>
    <button onclick="location.href='adicionar_inscricao_aluno.php'">Adicionar Inscrição</button>
    <div id="footer">
        <p>&copy; Guilherme Pires & Tiago Farinha</p>
    </div>
</body>

</html>
