<?php
// Inclua o arquivo basedados.h
include "../basedados/basedados.h";


session_start();
if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] != 1) {
    echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=home.php">';
}



// Verifique se o ID do utilizador foi passado por parâmetro
if (isset($_POST["idUtilizador"])) {
    $idUtilizador = $_POST["idUtilizador"];

    // Atualiza o campo 'tipoUtilizador' para 'utilizador apagado'
    $sql = "UPDATE utilizador SET tipoUtilizador = 5 WHERE idUtilizador = $idUtilizador";
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Utilizador marcado como apagado com sucesso!")</script>';
        echo '<meta http-equiv="refresh" content="0; url=gestao_utilizador.php">';
    } else {
        echo "Erro ao marcar o utilizador como apagado: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "ID do utilizador não fornecido.";
}
