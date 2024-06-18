<?php
include "../basedados/basedados.h";

session_start();
if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] != 2) {
    echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=home.php">';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos foram preenchidos
    if (isset($_POST['idCurso']) && isset($_POST['titulo']) && isset($_POST['descricao']) && isset($_POST['dataInicio']) && isset($_POST['dataFim']) && isset($_POST['limiteAlunos']) && isset($_POST['idDocente']) && isset($_POST['tipoCurso']) && isset($_POST['estadoCurso'])) {
        
        $idCurso = $_POST['idCurso'];
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $dataInicio = $_POST['dataInicio'];
        $dataFim = $_POST['dataFim'];
        $limiteAlunos = $_POST['limiteAlunos'];
        $idDocente = $_POST['idDocente'];
        $tipoCurso = $_POST['tipoCurso'];
        $estadoCurso = $_POST['estadoCurso'];

        // Atualiza os dados do curso no banco de dados
        $sql = "UPDATE cursos SET titulo = '$titulo', descricao = '$descricao', data_inicio = '$dataInicio', data_fim = '$dataFim', limite_alunos = $limiteAlunos, id_docente = $idDocente, tipo_curso = $tipoCurso, estado_curso = $estadoCurso WHERE id_curso = $idCurso";
        
        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Curso atualizado com sucesso!");</script>';
            echo '<meta http-equiv="refresh" content="0; url=gestao_cursos_docente.php">';
        } else {
            echo "Erro ao atualizar o curso: " . $conn->error;
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}
?>
