<?php
session_start();
if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] != 3) {
    echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=home.php">';
}

include "../basedados/basedados.h";

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idInscricao = $_POST['idInscricao'];
    $idAluno = $_POST['aluno'];
    $idCurso = $_POST['curso'];
    $dataInscricao = $_POST['data_inscricao'];
    $vExamNacional = $_POST['vExamNacional'];
    $statusInscricao = $_POST['status_inscricao'];

    // Atualiza os dados da inscrição no banco de dados
    $sql = "UPDATE inscricoes SET v_exam_nacional = '$vExamNacional' WHERE id_inscricao = $idInscricao";

    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Inscrição atualizada com sucesso!");</script>';
        echo '<meta http-equiv="refresh" content="0; url=gestao_inscricoes_aluno.php">';
    } else {
        echo "Erro ao atualizar a inscrição: " . mysqli_error($conn);
    }

    // Fechar a conexão
    mysqli_close($conn);
} else {
    echo '<script>alert("Acesso inválido!");</script>';
    echo '<meta http-equiv="refresh" content="0; url=editar_inscricao_aluno.php">';
}
?>
