<?php
include "../basedados/basedados.h";

session_start();
if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] != 3) {
    echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=home.php">';
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['idInscricao'])) {
    $idInscricao = $_POST['idInscricao'];

    // Altera o status da inscrição para "Apagada" (ID 4)
    $sql = "UPDATE inscricoes SET status_inscricao = 4 WHERE id_inscricao = $idInscricao";

    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Inscrição marcada como apagada com sucesso!");</script>';
        echo '<meta http-equiv="refresh" content="0; url=gestao_inscricoes_aluno.php">';
    } else {
        echo "Erro ao marcar a inscrição como apagada: " . $conn->error;
    }
} else {
    echo "Parâmetro inválido.";
}
?>
