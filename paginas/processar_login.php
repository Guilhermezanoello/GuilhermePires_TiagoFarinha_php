<?php
    include "../basedados/basedados.h";
    session_start();

    $nomeUtilizador = $_POST["utilizador"];
    $pass = md5($_POST["senha"]);

    $query = "SELECT * FROM utilizador WHERE nomeUtilizador = '$nomeUtilizador' AND pass = '$pass'";
    
    $retval = mysqli_query($conn, $query);

	if (!$retval){
        die('Could not get data: ' . mysqli_error($conn));
    }
      
	if (($row = mysqli_fetch_array($retval)) != null){
        $_SESSION['utilizador'] = $nomeUtilizador;
        $_SESSION['tipoUtilizador'] = $row['tipoUtilizador'];
        $_SESSION['idUtilizador'] = $row['idUtilizador'];

        header("Location: redirecionar.php");
    }else{
        echo '<script> alert("Dados de autentificação incorretos!")</script>';
        echo '<meta http-equiv="refresh" content="0; url=login.php">';
    }
?>
