<?php
header('Content-Type: application/json');
require_once 'db_conexao.php';

$id = $_GET['id'] ?? null;
$resposta = [];

if ($id) {
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $resposta['sucesso'] = true;
    } else {
        $resposta['erro'] = "Erro ao excluir.";
    }
} else {
    $resposta['erro'] = "ID inválido.";
}

$conn->close();
echo json_encode($resposta);
?>