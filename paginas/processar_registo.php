<?php
    include "../basedados/basedados.h";
    session_start();
    
    $nomeUtilizador = $_POST["nomeUtilizador"];
    $mail = $_POST["email"];
    $imagem = 'default.png';
    $morada = $_POST["morada"];
    $pass = md5($_POST["senha"]);
    $telemovel = $_POST["telemovel"];
    $tipoUtilizador = 4; // Valor de utilizador não validado

    $query = "INSERT INTO utilizador (nomeUtilizador, mail, imagem, morada, pass, telemovel, tipoUtilizador) VALUES ('$nomeUtilizador', '$mail', '$imagem', '$morada', '$pass', '$telemovel', '$tipoUtilizador')";

    if (mysqli_query($conn, $query)) {
        header("Location: home.php");
        exit();
    } else {
        echo "Erro ao inserir o registro: " . mysqli_error($conn);
    }
?>
