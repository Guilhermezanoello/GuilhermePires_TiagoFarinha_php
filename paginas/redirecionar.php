<?php
    session_start();

    if($_SESSION["tipoUtilizador"] == 1){
        header("Location: pgLogadoAdmin.php");
        exit;
    } else if ($_SESSION["tipoUtilizador"] == 2){
        header("Location: pgLogadoDocente.php");
        exit;
    } else if ($_SESSION["tipoUtilizador"] == 3){
        header("Location: pgLogadoAluno.php");
        exit;
    }else if ($_SESSION["tipoUtilizador"] == 4){
        echo '<script> alert("UTILIZADOR NÂO VALIDO: CONTACTE O ADMIN!")</script>';
        echo '<meta http-equiv="refresh" content="0; url=Logout.php">';
    }else {
        echo '<script> alert("UTILIZADOR INVALIDO: CONTACTE O ADMIN!")</script>';
        echo '<meta http-equiv="refresh" content="0; url=Logout.php">';
    }
?>