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
    <title>Editar Curso</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #001f3f;
            /* Azul Marinho */
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #42A5F5;
            /* Azul Secundário */
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
            /* Azul Claro */
        }

        .active {
            background-color: #1976D2;
            /* Azul Escuro */
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

    <h1>Editar Curso</h1>

    <?php
    if (isset($_POST['idCurso'])) {
        $idCurso = $_POST['idCurso'];

        // Verifica se o curso existe no banco de dados
        $sql = "SELECT * FROM cursos WHERE id_curso = $idCurso";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $titulo = $row['titulo'];
            $descricao = $row['descricao'];
            $dataInicio = $row['data_inicio'];
            $dataFim = $row['data_fim'];
            $limiteAlunos = $row['limite_alunos'];
            $idDocente = $row['id_docente'];
            $tipoCurso = $row['tipo_curso'];
            $estadoCurso = $row['estado_curso'];
    ?>

            <form action="atualizar_curso.php" method="POST">
                <input type="hidden" name="idCurso" value="<?php echo $idCurso; ?>">

                <label for="titulo">Título do Curso:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo $titulo; ?>"><br>

                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao"><?php echo $descricao; ?></textarea><br>

                <label for="dataInicio">Data de Início:</label>
                <input type="date" id="dataInicio" name="dataInicio" value="<?php echo $dataInicio; ?>"><br>

                <label for="dataFim">Data de Fim:</label>
                <input type="date" id="dataFim" name="dataFim" value="<?php echo $dataFim; ?>"><br>

                <label for="limiteAlunos">Limite de Alunos:</label>
                <input type="number" id="limiteAlunos" name="limiteAlunos" min="0" max="30" value="<?php echo $limiteAlunos; ?>"><br>

                <label for="idDocente">Docente:</label>
                <select name="idDocente" id="idDocente">
                    <?php
                    $sqlDocentes = "SELECT idUtilizador, nomeUtilizador FROM utilizador WHERE tipoUtilizador = 2";
                    $resultDocentes = $conn->query($sqlDocentes);

                    if ($resultDocentes->num_rows > 0) {
                        while ($rowDocente = $resultDocentes->fetch_assoc()) {
                            $selected = ($rowDocente['idUtilizador'] == $idDocente) ? "selected" : "";
                            echo '<option value="' . $rowDocente['idUtilizador'] . '" ' . $selected . '>' . $rowDocente['nomeUtilizador'] . '</option>';
                        }
                    }
                    ?>
                </select><br>

                <label for="tipoCurso">Tipo de Curso:</label>
                <select name="tipoCurso" id="tipoCurso">
                    <?php
                    $sqlTiposCurso = "SELECT id_tipo_curso, descricao FROM tipo_curso";
                    $resultTiposCurso = $conn->query($sqlTiposCurso);

                    if ($resultTiposCurso->num_rows > 0) {
                        while ($rowTipoCurso = $resultTiposCurso->fetch_assoc()) {
                            $selected = ($rowTipoCurso['id_tipo_curso'] == $tipoCurso) ? "selected" : "";
                            echo '<option value="' . $rowTipoCurso['id_tipo_curso'] . '" ' . $selected . '>' . $rowTipoCurso['descricao'] . '</option>';
                        }
                    }
                    ?>
                </select><br>

                <label for="estadoCurso">Estado do Curso:</label>
                <select name="estadoCurso" id="estadoCurso">
                    <?php
                    $sqlEstadosCurso = "SELECT id_estado_curso, `desc` FROM estadocurso";
                    $resultEstadosCurso = $conn->query($sqlEstadosCurso);

                    if ($resultEstadosCurso->num_rows > 0) {
                        while ($rowEstadoCurso = $resultEstadosCurso->fetch_assoc()) {
                            $selected = ($rowEstadoCurso['id_estado_curso'] == $estadoCurso) ? "selected" : "";
                            echo '<option value="' . $rowEstadoCurso['id_estado_curso'] . '" ' . $selected . '>' . $rowEstadoCurso['desc'] . '</option>';
                        }
                    }
                    ?>
                </select><br>

                <input type="submit" value="Atualizar">
            </form>
    <?php
        } else {
            echo "Curso não encontrado.";
        }
    } else {
        echo "ID do curso não fornecido.";
    }
    ?>

    <div id="footer">
        <p>&copy; Guilherme Pires & Tiago Farinha</p>
    </div>

</body>

</html>
