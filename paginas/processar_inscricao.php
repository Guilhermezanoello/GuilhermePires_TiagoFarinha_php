<?php
include "../basedados/basedados.h";

session_start();
if (!isset($_SESSION["tipoUtilizador"]) || $_SESSION["tipoUtilizador"] != 1) {
    echo '<script> alert("UTILIZADOR NÃO AUTORIZADO: CONTACTE O ADMIN OU ENTRE COM OUTRO UTILIZADOR!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=home.php">';
    exit;
}
// Define o fuso horário para Portugal (UTC+0)
date_default_timezone_set('Europe/Lisbon');

// Receber os dados do formulário
$aluno = $_POST['aluno'];
$curso = $_POST['curso'];
$data_inscricao = isset($_POST['data_inscricao']) ? $_POST['data_inscricao'] : date('Y-m-d\TH:i'); // Carrega a data e hora atual se não estiver definida no POST
$v_exam_nacional = $_POST['v_exam_nacional'];
$status_inscricao = $_POST['status_inscricao'];

// Valida os dados
if (empty($aluno) || empty($curso) || empty($data_inscricao) || empty($v_exam_nacional) || empty($status_inscricao)) {
    echo '<script> alert("Por favor, preencha todos os campos!!!")</script>';
    echo "Por favor, preencha todos os campos.";
    echo '<meta http-equiv="refresh" content="0; url=adicionar_inscricao.php">';
    exit;
}

// Conta o número de inscrições aprovadas para o curso selecionado
$sql_count = "SELECT COUNT(*) as num_aprovadas FROM inscricoes WHERE id_curso = $curso AND status_inscricao = 2";
$result_count = $conn->query($sql_count);
$row_count = $result_count->fetch_assoc();
$numAprovadas = $row_count['num_aprovadas'];

// Busca o limite de alunos do curso selecionado
$sql_limite = "SELECT limite_alunos FROM cursos WHERE id_curso = $curso";
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
$queryVerificar = "SELECT * FROM inscricoes WHERE id_aluno = $aluno AND id_curso = $curso AND status_inscricao IN (1, 2, 3)";
$resultVerificar = mysqli_query($conn, $queryVerificar);

if (mysqli_num_rows($resultVerificar) > 0) {
    echo '<script> alert("Você já possui uma inscrição para este curso! Podes editar a inscrição existente ou excluir-la. Só então poderá se inscrever!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=gestao_inscricoes_aluno.php">';
    exit;
}

// Inseri a nova inscrição no banco de dados
$query = "INSERT INTO inscricoes (id_aluno, id_curso, data_inscricao, v_exam_nacional, status_inscricao) 
          VALUES ('$aluno', '$curso', '$data_inscricao', '$v_exam_nacional', '$status_inscricao')";

if (mysqli_query($conn, $query)) {
    echo '<script> alert("Inscrição adicionada com sucesso!")</script>';
    echo '<meta http-equiv="refresh" content="0; url=gestao_inscricoes.php">';
    exit;
} else {
    echo "Erro ao adicionar inscrição: " . mysqli_error($conn);
    echo '<meta http-equiv="refresh" content="0; url=adicionar_inscricao.php">';
    exit;
}

// Fechar a conexão
mysqli_close($conn);
?>