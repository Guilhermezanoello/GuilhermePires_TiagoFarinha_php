<?php
include "../basedados/basedados.h";

session_start();
if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] <1 || $_SESSION["tipoUtilizador"] >3) {
    echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=home.php">';
    exit;
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeUtilizador = $_POST["nomeUtilizador"];
    $pass = $_POST["senha"];
    $mail = $_POST["mail"];
    $imagem = $_POST["imagem"];
    $morada = $_POST["morada"];
    $telemovel = $_POST["telemovel"];

    if($pass != ""){
        $pass = md5($pass);
        // Atualiza os dados do utilizador no banco de dados
        $sql = "UPDATE utilizador SET nomeUtilizador = '$nomeUtilizador', pass = '$pass', mail = '$mail', imagem = '$imagem', morada = '$morada', telemovel = '$telemovel' WHERE idUtilizador = " . $_SESSION["idUtilizador"];
    } else {
        $sql = "UPDATE utilizador SET nomeUtilizador = '$nomeUtilizador', mail = '$mail', imagem = '$imagem', morada = '$morada', telemovel = '$telemovel' WHERE idUtilizador = " . $_SESSION["idUtilizador"];
    }

    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo '<script> alert("Dados atualizados com sucesso!")</script>';
        echo '<meta http-equiv="refresh" content="0; url=redirecionar.php">';
    } else {
        echo '<script> alert("Erro ao atualizar os dados!")</script>';
        echo '<meta http-equiv="refresh" content="0; url=dados_pessoais.php">';
    }
} else {
    header("Location: dados_pessoais.php");
    exit;
}
?>