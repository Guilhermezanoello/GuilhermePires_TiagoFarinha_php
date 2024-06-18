<?php
include "../basedados/basedados.h";

session_start();
if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] != 2) {
    echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=home.php">';
    exit;
}

$titulo = $_POST['titulo'];
$docente = $_POST['docente'];
$tipo_curso = $_POST['tipo_curso'];
$data_inicio = $_POST['data_inicio'];
$data_fim = $_POST['data_fim'];
$limite_alunos = $_POST['limite_alunos'];

// Valida os dados
if (empty($titulo) || empty($docente) || empty($tipo_curso) || empty($data_inicio) || empty($data_fim) || empty($limite_alunos)) {
    echo '<script> alert("Por favor, preencha todos os campos!!!")</script>';
    echo "Por favor, preencha todos os campos.";
    echo '<meta http-equiv="refresh" content="0; url=adicionar_curso_docente.php">';
    exit;
}

// Inseri o novo curso no banco de dados
$query = "INSERT INTO cursos (titulo, descricao, data_inicio, data_fim, limite_alunos, id_docente, tipo_curso, estado_curso) 
          VALUES ('$titulo', '$titulo', '$data_inicio', '$data_fim', '$limite_alunos', '$docente', '$tipo_curso', 1)";

if (mysqli_query($conn, $query)) {
    echo '<script> alert("Curso adicionado com sucesso!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=gestao_cursos_docente.php">';
    exit;
} else {
    echo "Erro ao adicionar curso: " . mysqli_error($conn);
    echo '<meta http-equiv="refresh" content="0; url=adicionar_cursos_docente.php">';
    exit;
}

// Fechar a conexão
mysqli_close($conn);
?>
