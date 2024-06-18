<?php
session_start();
if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] != 1) {
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
        echo '<meta http-equiv="refresh" content="0; url=gestao_inscricoes.php">';
        exit;
    }

    // Verifica se o aluno já possui uma inscrição ativa para o curso selecionado
    $queryVerificar = "SELECT * FROM inscricoes WHERE id_aluno = $idAluno AND id_curso = $idCurso AND status_inscricao IN (1, 2, 3)";
    $resultVerificar = mysqli_query($conn, $queryVerificar);
    
    if (mysqli_num_rows($resultVerificar) > 0) {
        echo '<script> alert("O aluno já possui uma inscrição para este curso! Podes editar a inscrição existente ou excluir-la. Só então poderá se inscrever!")</script>';
        echo '<meta http-equiv="refresh" content="0; url=gestao_inscricoes.php">';
        exit;
    }

    // Atualiza os dados da inscrição no banco de dados
    $sql = "UPDATE inscricoes SET id_aluno = '$idAluno', id_curso = '$idCurso', data_inscricao = '$dataInscricao', v_exam_nacional = '$vExamNacional', status_inscricao = '$statusInscricao' WHERE id_inscricao = $idInscricao";

    if (mysqli_query($conn, $sql)) {
        echo '<script>alert("Inscrição atualizada com sucesso!");</script>';
        echo '<meta http-equiv="refresh" content="0; url=gestao_inscricoes.php">';
    } else {
        echo "Erro ao atualizar a inscrição: " . mysqli_error($conn);
    }

    // Fechar a conexão
    mysqli_close($conn);
} else {
    echo '<script>alert("Acesso inválido!");</script>';
    echo '<meta http-equiv="refresh" content="0; url=editar_inscricao.php">';
}
?>
