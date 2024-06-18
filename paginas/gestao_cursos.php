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
    <title>Gestão de Cursos</title>
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
        background-color:  #42A5F5;
        color: black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #42A5F5;  /* Azul Secundário */
            color: whitesmoke;
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
    <h1>Gestão de Cursos</h1>

    <?php

// Função para exibir todos os cursos
function exibirCursos($connection)
{
    $sql = "SELECT c.id_curso, c.titulo, u.nomeUtilizador AS docente, tc.descricao AS tipo_curso, 
                   ec.desc AS estado_curso_descricao, c.data_inicio, c.data_fim, c.limite_alunos
            FROM cursos c
            INNER JOIN utilizador u ON c.id_docente = u.idUtilizador
            INNER JOIN tipo_curso tc ON c.tipo_curso = tc.id_tipo_curso
            INNER JOIN estadocurso ec ON c.estado_curso = ec.id_estado_curso";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<table>';
        echo '<tr><th>ID</th><th>Título</th><th>Docente</th><th>Tipo de Curso</th>
                  <th>Data de Início</th><th>Data de Fim</th><th>Limite de Alunos</th>
                  <th>Estado do Curso</th><th>Ações</th></tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['id_curso'] . '</td>';
            echo '<td>' . $row['titulo'] . '</td>';
            echo '<td>' . $row['docente'] . '</td>';
            echo '<td>' . $row['tipo_curso'] . '</td>';
            echo '<td>' . $row['data_inicio'] . '</td>';
            echo '<td>' . $row['data_fim'] . '</td>';
            echo '<td>' . $row['limite_alunos'] . '</td>';
            echo '<td>' . $row['estado_curso_descricao'] . '</td>';
            echo '<td>';
            echo '<form id="editar_inscricao" action="editar_curso.php" method="POST" style="display:inline;">';
            echo '<input type="hidden" name="idCurso" value="' . $row['id_curso'] . '">';
            echo '<input type="submit" value="Editar">';
            echo '</form>';
            echo ' | ';
            echo '<form id="excluir_inscricao" action="excluir_curso.php" method="POST" style="display:inline;">';
            echo '<input type="hidden" name="idCurso" value="' . $row['id_curso'] . '">';
            echo '<input type="submit" value="Excluir">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'Nenhum curso encontrado.';
    }
}

// Exibir os cursos
exibirCursos($conn);
?>


    <button onclick="location.href='adicionar_cursos.php'">Adicionar Cursos</button>
    <div id="footer">
        <p>&copy; Guilherme Pires & Tiago Farinha</p>
    </div>
</body>

</html>
