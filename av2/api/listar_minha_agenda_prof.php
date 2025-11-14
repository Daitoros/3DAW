<?php
session_start();
header('Content-Type: application/json');
require_once 'db_conexao.php';

if (!isset($_SESSION['usuario_nome']) || $_SESSION['usuario_funcao'] != 'profissional') {
    echo json_encode([]);
    exit;
}

// O "truque": O nome do usuário (login) deve ser igual ao nome salvo no agendamento
$nome_profissional = $_SESSION['usuario_nome']; // Ex: "Ana Silva"

// Busca agendamentos onde o nome_profissional bate com o usuário logado
// Vamos usar LIKE para ser flexível (Ex: 'Ana Silva' acha 'Ana Silva (Especialista)')
$termo_busca = "%" . $nome_profissional . "%";

$sql = "SELECT * FROM agendamentos WHERE nome_profissional LIKE ? ORDER BY data_hora_agendamento ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $termo_busca);
$stmt->execute();
$res = $stmt->get_result();

$agenda = [];
while ($linha = $res->fetch_assoc()) {
    $linha['data_formatada'] = date('d/m/Y H:i', strtotime($linha['data_hora_agendamento']));
    $agenda[] = $linha;
}

echo json_encode($agenda);
?>