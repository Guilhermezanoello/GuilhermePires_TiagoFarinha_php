<?php
include "../basedados/basedados.h";

session_start();
if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] != 2) {
    echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=home.php">';
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idInscricao'])) {
    $idInscricao = $_POST['idInscricao'];
    $idCurso = $_POST['idCurso']; // Para verificar o limite de alunos

    // Conta o número de inscrições aprovadas para o curso selecionado
    $sql_count = "SELECT COUNT(*) as num_aprovadas FROM inscricoes WHERE id_curso = $idCurso AND status_inscricao = 2";
    $result_count = $conn->query($sql_count);
    $row_count = $result_count->fetch_assoc();
    $numAprovadas = $row_count['num_aprovadas'];

    // Busca o limite de alunos do curso selecionado
    $sql_limite = "SELECT limite_alunos FROM cursos WHERE id_curso = $idCurso";
    $result_limite = $conn->query($sql_limite);
    $row_limite = $result_limite->fetch_assoc();
    $limiteAlunos = $row_limite['limite_alunos'];

    // Verifica se o número de inscrições aprovadas é menor ou igual ao limite de alunos
    if ($numAprovadas >= $limiteAlunos) {
        echo '<script>alert("O limite de alunos para este curso foi excedido. Não é possível aprovar mais inscrições.");</script>';
        echo '<meta http-equiv="refresh" content="0; url=gestao_inscricoes_docente.php">';
        exit;
    }

    // Altera o status da inscrição para "Aprovada" (ID 2)
    $sql = "UPDATE inscricoes SET status_inscricao = 2 WHERE id_inscricao = $idInscricao";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Inscrição marcada como aprovada com sucesso!");</script>';
        echo '<meta http-equiv="refresh" content="0; url=gestao_inscricoes_docente.php">';
    } else {
        echo "Erro ao marcar a inscrição como aprovada: " . $conn->error;
    }
} else {
    echo "Parâmetro inválido.";
}
?>
