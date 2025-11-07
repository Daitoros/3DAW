<?php
header('Content-Type: application/json');

require_once 'db_conexao.php'; // $conn

$resposta = [];
$id = $_GET['id'] ?? null; 

if ($id === null || !is_numeric($id) || $id < 1) {
    $resposta['erro'] = "ID de utilizador inválido.";
    echo json_encode($resposta);
    $conn->close();
    exit;
}

// *** ALTERAÇÃO DE SEGURANÇA ***
// NUNCA envie a senha (nem o hash) de volta para um formulário de edição.
$sql = "SELECT usuario, funcao FROM usuarios WHERE id = ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    $resposta['erro'] = "Erro ao preparar a consulta: " . $conn->error;
} else {
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $resultado = $stmt->get_result();
        
        if ($resultado->num_rows === 1) {
            $resposta = $resultado->fetch_assoc();
        } else {
            $resposta['erro'] = "Utilizador com o ID " . htmlspecialchars($id) . " não encontrado.";
        }
    } else {
        $resposta['erro'] = "Erro ao executar a consulta: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();

echo json_encode($resposta);
?>