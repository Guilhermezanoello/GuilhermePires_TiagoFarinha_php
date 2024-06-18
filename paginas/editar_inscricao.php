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
    <title>Editar Inscrição</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #001f3f;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #42A5F5;
        }

        li {
            float: left;
        }

        li a {
            display: block;
            color: whitesmoke;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-weight: bold;
        }

        li a:hover:not(.active) {
            background-color: #BBDEFB;
        }

        .active {
            background-color: #1976D2;
        }
    </style>
</head>

<body>
    <?php include "../basedados/basedados.h"; ?>

    <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="contactos.php">Contactos</a></li>
        <li><a href="infomais.php">Info +</a></li>
        <li><a class="active" href="pgLogadoAdmin.php">Menu</a></li>
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

    <h1>Editar Inscrição</h1>

    <?php
    if (isset($_POST['idInscricao'])) {
        $idInscricao = $_POST['idInscricao'];

        // Verifica se a inscrição existe no banco de dados
        $sql = "SELECT * FROM inscricoes WHERE id_inscricao = $idInscricao";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $idAluno = $row['id_aluno'];
            $idCurso = $row['id_curso'];
            $dataInscricao = $row['data_inscricao'];
            $vExamNacional = $row['v_exam_nacional'];
            $statusInscricao = $row['status_inscricao'];
    ?>

            <form action="atualizar_inscricao.php" method="POST">
                <input type="hidden" name="idInscricao" value="<?php echo $idInscricao; ?>">

                <label for="aluno">Aluno:</label>
                <select name="aluno" id="aluno">
                    <?php
                    $sqlAlunos = "SELECT idUtilizador, nomeUtilizador FROM utilizador WHERE tipoUtilizador = 3";
                    $resultAlunos = $conn->query($sqlAlunos);

                    if ($resultAlunos->num_rows > 0) {
                        while ($rowAluno = $resultAlunos->fetch_assoc()) {
                            $selected = ($rowAluno['idUtilizador'] == $idAluno) ? "selected" : "";
                            echo '<option value="' . $rowAluno['idUtilizador'] . '" ' . $selected . '>' . $rowAluno['nomeUtilizador'] . '</option>';
                        }
                    }
                    ?>
                </select><br>

                <label for="curso">Curso:</label>
                <select name="curso" id="curso">
                    <?php
                    $sqlCursos = "SELECT id_curso, titulo FROM cursos";
                    $resultCursos = $conn->query($sqlCursos);

                    if ($resultCursos->num_rows > 0) {
                        while ($rowCurso = $resultCursos->fetch_assoc()) {
                            $selected = ($rowCurso['id_curso'] == $idCurso) ? "selected" : "";
                            echo '<option value="' . $rowCurso['id_curso'] . '" ' . $selected . '>' . $rowCurso['titulo'] . '</option>';
                        }
                    }
                    ?>
                </select><br>

                <label for="data_inscricao">Data de Inscrição:</label>
                <input type="datetime-local" id="data_inscricao" name="data_inscricao" value="<?php echo $dataInscricao; ?>"><br>

                <label for="vExamNacional">Valor do Exame Nacional:</label>
                <input type="number" id="vExamNacional" name="vExamNacional" min="0" max="20" value="<?php echo $vExamNacional; ?>"><br>

                <label for="status_inscricao">Status da Inscrição:</label>
                <select name="status_inscricao" id="status_inscricao">
                    <?php
                    $sqlStatusInscricao = "SELECT id_status_inscricao, `desc` FROM status_inscricao";
                    $resultStatusInscricao = $conn->query($sqlStatusInscricao);

                    if ($resultStatusInscricao->num_rows > 0) {
                        while ($rowStatusInscricao = $resultStatusInscricao->fetch_assoc()) {
                            $selected = ($rowStatusInscricao['id_status_inscricao'] == $statusInscricao) ? "selected" : "";
                            echo '<option value="' . $rowStatusInscricao['id_status_inscricao'] . '" ' . $selected . '>' . $rowStatusInscricao['desc'] . '</option>';
                        }
                    }
                    ?>
                </select><br>

                <input type="submit" value="Atualizar">
            </form>
    <?php
        } else {
            echo "Inscrição não encontrada.";
        }
    } else {
        echo "ID da inscrição não fornecido.";
    }
    ?>

    <div id="footer">
        <p>&copy; Guilherme Pires & Tiago Farinha</p>
    </div>

</body>

</html>
