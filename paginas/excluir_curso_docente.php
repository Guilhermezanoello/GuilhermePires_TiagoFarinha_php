<?php
include "../basedados/basedados.h";

session_start();
if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] != 2) {
    echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=home.php">';
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idCurso'])) {
    $idCurso = $_POST['idCurso'];

    // Altera o estado do curso para Inativo
    $sql = "UPDATE cursos SET estado_curso = 2 WHERE id_curso = $idCurso";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Curso marcado como Inativo com sucesso!");</script>';
        echo '<meta http-equiv="refresh" content="0; url=gestao_cursos_docente.php">';
    } else {
        echo "Erro ao marcar o curso como Inativo: " . $conn->error;
    }
} else {
    echo "Parâmetro inválido.";
}
?>
