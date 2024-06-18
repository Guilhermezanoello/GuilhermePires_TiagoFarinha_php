<?php
include "../basedados/basedados.h";

session_start();
if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] != 1) {
    echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=home.php">';
}

// Verifique se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idUtilizador = $_POST["idUtilizador"];
    $nome = $_POST["nome"];
    $pass = $_POST["senha"];
    $email = $_POST["email"];
    $imagem = $_POST["imagem"];
    $morada = $_POST["morada"];
    $telefone = $_POST["telefone"];
    $tipo = $_POST["tipo"];

    if($pass != ""){
        $pass = md5($pass);
        // Atualiza os dados do utilizador no banco de dados
        $sql = "UPDATE utilizador SET nomeUtilizador='$nome', pass = '$pass', mail='$email', imagem='$imagem', morada='$morada', telemovel='$telefone', tipoUtilizador='$tipo' WHERE idUtilizador='$idUtilizador'";
    } else {
        // Atualiza os dados do utilizador no banco de dados
        $sql = "UPDATE utilizador SET nomeUtilizador='$nome', mail='$email', imagem='$imagem', morada='$morada', telemovel='$telefone', tipoUtilizador='$tipo' WHERE idUtilizador='$idUtilizador'";
    }

    
    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Utilizador atualizado com sucesso!")</script>';
        // Verifica se o idUtilizador na sessão é igual ao idUtilizador atualizado
        if (isset($_SESSION['idUtilizador']) && $_SESSION['idUtilizador'] == $idUtilizador && isset($_SESSION['tipoUtilizador']) && $_SESSION['tipoUtilizador'] != $tipo) {
            
            // Atualiza o idUtilizador na sessão
            $_SESSION['idUtilizador'] = $idUtilizador;            
            // Atualiza o tipoUtilizador na sessão
            $_SESSION['tipoUtilizador'] = $tipo;            
            // Invalida a sessão
            session_destroy();

            echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
            echo '<meta http-equiv="refresh" content="0; url=home.php">';
            exit();
        }
        echo '<meta http-equiv="refresh" content="0; url=gestao_utilizador.php">';
    } else {
        echo "Erro ao atualizar o utilizador: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Formulário não enviado.";
}
?>
