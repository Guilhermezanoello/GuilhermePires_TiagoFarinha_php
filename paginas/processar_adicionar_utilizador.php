<?php
session_start();

if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] != 1) {
    echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=home.php">';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include "../basedados/basedados.h";
    
    // Verifica se todos os campos obrigatórios foram preenchidos
    if (isset($_POST["nomeUtilizador"]) && isset($_POST["email"]) && isset($_POST["imagem"]) && isset($_POST["morada"]) && isset($_POST["password"]) && isset($_POST["telemovel"]) && isset($_POST["tipoUtilizador"])) {
        $nomeUtilizador = $_POST["nomeUtilizador"];
        $email = $_POST["email"];
        $imagem = $_POST["imagem"];
        $morada = $_POST["morada"];
        $password = md5($_POST["password"]);
        $telemovel = $_POST["telemovel"];
        $tipoUtilizador = $_POST["tipoUtilizador"];

        // Insira os dados do novo utilizador no banco de dados
        $sql = "INSERT INTO utilizador (nomeUtilizador, mail, imagem, morada, pass, telemovel, tipoUtilizador) VALUES ('$nomeUtilizador', '$email', '$imagem', '$morada', '$password', '$telemovel', '$tipoUtilizador')";

        if (mysqli_query($conn, $sql)) {
            echo '<script>alert("Utilizador adicionado com sucesso!")</script>';
            echo '<meta http-equiv="refresh" content="0; url=gestao_utilizador.php">';
        } else {
            echo "Erro ao adicionar utilizador: " . mysqli_error($conn);
            echo $tipoUtilizador;
            echo $nomeUtilizador;
            echo $email;
            echo $imagem;
            echo $morada;
            echo $password;
            echo $telemovel;
            echo $tipoUtilizador;

        }
    } else {
        echo '<script>alert("Por favor, preencha todos os campos obrigatórios!")</script>';
        echo '<meta http-equiv="refresh" content="0; url=gestao_utilizador.php">';
    }

    mysqli_close($conn);
}
?>