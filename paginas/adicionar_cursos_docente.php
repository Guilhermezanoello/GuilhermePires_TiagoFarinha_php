<!DOCTYPE html>
<html lang="pt-br">
<?php
session_start();
if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] != 2) {
    echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=home.php">';
}

// Inclui o arquivo basedados.h
include "../basedados/basedados.h";

// Consulta para obter o idUtilizador do usuário logado na sessão vai selecionar somente o docente
$idUtilizadorLogado = $_SESSION["idUtilizador"];
$queryUsuarioLogado = "SELECT idUtilizador, nomeUtilizador FROM utilizador WHERE idUtilizador = $idUtilizadorLogado";
$resultUsuarioLogado = mysqli_query($conn, $queryUsuarioLogado);

// Consulta para obter os tipos de curso
$queryTiposCurso = "SELECT id_tipo_curso, descricao FROM tipo_curso";
$resultTiposCurso = mysqli_query($conn, $queryTiposCurso);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Curso</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
        background-color: #001f3f;  /* Azul Marinho */
        margin-bottom: 60px;
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

		form {
			margin-top: 30px;
		}

		label {
			display: block;
			margin-bottom: 10px;
		}

		input[type="submit"] {
			background-color: #42A5F5;
			color: white;
			padding: 10px 20px;
			border: none;
			cursor: pointer;
		}
    </style>
</head>

<body>
    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="contactos.php">Contactos</a></li>
        <li><a href="infomais.php">Info +</a></li>
        <li><a class="active" href="pgLogadoDocente.php">Menu</a></li>
        <?php
        
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

    <h1>Adicionar Curso</h1>

    <form action="processar_curso_docente.php" method="POST">
        <label for="titulo">Título do Curso:</label>
        <input type="text" name="titulo" id="titulo" required>

        <label for="docente">Docente:</label>
        <select name="docente" id="docente">
        <option value="" disabled selected>Selecione um docente</option>
            <?php
            while ($row = mysqli_fetch_assoc($resultUsuarioLogado)) {
                echo '<option value="' . $row['idUtilizador'] . '">' . $row['nomeUtilizador'] . '</option>';
            }
            ?>
        </select>

        <label for="tipo_curso">Tipo de Curso:</label>
        <select name="tipo_curso" id="tipo_curso">
        <option value="" disabled selected>Selecione um tipo de curso</option>
            <?php
            while ($row = mysqli_fetch_assoc($resultTiposCurso)) {
                echo '<option value="' . $row['id_tipo_curso'] . '">' . $row['descricao'] . '</option>';
            }
            ?>
        </select>

        <label for="data_inicio">Data de Início:</label>
        <input type="date" name="data_inicio" id="data_inicio" required>

        <label for="data_fim">Data de Fim:</label>
        <input type="date" name="data_fim" id="data_fim" required>

        <label for="limite_alunos">Limite de Alunos:</label>
        <input type="number" name="limite_alunos" id="limite_alunos" min="0" max="30" required><br><br>

        <input type="submit" value="Adicionar Curso">
    </form>
    <?php
    // Fechar a conexão 
    mysqli_close($conn);
    ?>

    <div id="footer">
        <p>&copy; Guilherme Pires & Tiago Farinha</p>
    </div>
</body>

</html>
