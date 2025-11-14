<?php
session_start();
header('Content-Type: application/json');
require_once 'db_conexao.php';

if (!isset($_SESSION['cliente_id'])) {
    echo json_encode(['erro' => 'Não autenticado']);
    exit;
}

$id = $_SESSION['cliente_id'];
$nome = $_POST['nome'];
$telefone = $_POST['telefone'];
$senha = $_POST['senha']; // Opcional

if (empty($senha)) {
    // Atualiza sem mudar a senha
    $sql = "UPDATE clientes SET nome = ?, telefone = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nome, $telefone, $id);
} else {
    // Atualiza COM senha nova
    $hash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "UPDATE clientes SET nome = ?, telefone = ?, senha = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nome, $telefone, $hash, $id);
}

if ($stmt->execute()) {
    // Atualiza o nome na sessão também
    $_SESSION['cliente_nome'] = $nome;
    echo json_encode(['sucesso' => 'Dados atualizados com sucesso!']);
} else {
    echo json_encode(['erro' => 'Erro ao atualizar.']);
}
?>