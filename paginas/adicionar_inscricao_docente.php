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

// Consulta para obter os alunos
$queryAlunos = "SELECT idUtilizador, nomeUtilizador FROM utilizador WHERE tipoUtilizador = 3";
$resultAlunos = mysqli_query($conn, $queryAlunos);

// Consulta para obter os cursos vinculados ao idUtilizador = idDocente
$idUtilizadorLogado = $_SESSION["idUtilizador"];
$queryCursos = "SELECT id_curso, titulo, id_docente FROM cursos WHERE id_docente = $idUtilizadorLogado";
$resultCursos = mysqli_query($conn, $queryCursos);

// Consulta para obter os estados de inscrição
$queryStatusInscricao = "SELECT id_status_inscricao, `desc` FROM status_inscricao";
$resultStatusInscricao = mysqli_query($conn, $queryStatusInscricao);

// Define o fuso horário para Portugal (UTC+0)
date_default_timezone_set('Europe/Lisbon');

// Obtém a data e hora atual no fuso horário definido
$currentDateTime = date('Y-m-d\TH:i');
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Inscrição</title>
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

    <h1>Adicionar Inscrição</h1>

    <form action="processar_inscricao_docente.php" method="POST">
        <label for="aluno">Aluno:</label>
        <select name="aluno" id="aluno">
        <option value="" disabled selected>Selecione um aluno</option>
            <?php
            while ($row = mysqli_fetch_assoc($resultAlunos)) {
                echo '<option value="' . $row['idUtilizador'] . '">' . $row['nomeUtilizador'] . '</option>';
            }
            ?>
        </select>

        <label for="curso">Curso:</label>
        <select name="curso" id="curso">
        <option value="" disabled selected>Selecione um curso</option>
            <?php
            while ($row = mysqli_fetch_assoc($resultCursos)) {
                echo '<option value="' . $row['id_curso'] . '">' . $row['titulo'] . '</option>';
            }
            ?>
        </select>

        <label for="data_inscricao">Data de Inscrição:</label>
        <input type="datetime-local" name="data_inscricao" id="data_inscricao" value="<?php echo $currentDateTime; ?>" required>

        <label for="v_exam_nacional">Valor do Exame Nacional:</label>
        <input type="number" name="v_exam_nacional" id="v_exam_nacional" min="0" max="20" required>

        <label for="status_inscricao">Status da Inscrição:</label>
        <select name="status_inscricao" id="status_inscricao">
        <option value="" disabled selected>Selecione um status de inscrição</option>
            <?php
            while ($row = mysqli_fetch_assoc($resultStatusInscricao)) {
                echo '<option value="' . $row['id_status_inscricao'] . '">' . $row['desc'] . '</option>';
            }
            ?>
        </select>

        <input type="submit" value="Adicionar Inscrição">
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
