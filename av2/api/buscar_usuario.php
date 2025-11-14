<?php
header('Content-Type: application/json');
require_once 'db_conexao.php';

$resposta = [];
$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(['erro' => 'ID não fornecido na URL']);
    exit;
}

// Busca o usuário pelo ID
$sql = "SELECT id, usuario, funcao FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $resposta = $result->fetch_assoc();
} else {
    $resposta['erro'] = "Usuário não encontrado no banco de dados.";
}

$conn->close();
echo json_encode($resposta);
?>