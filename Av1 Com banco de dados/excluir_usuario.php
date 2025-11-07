<?php
header('Content-Type: application/json');

// 1. Incluir a conexão
require_once 'db_conexao.php'; // $conn

$resposta = [];
// O ID agora é o ID do B.D. (chave primária)
$id = $_GET['id'] ?? null;

if ($id === null || !is_numeric($id) || $id < 1) {
    $resposta['erro'] = "ID de usuário inválido.";
    echo json_encode($resposta);
    $conn->close();
    exit;
}

// 2. --- NOVA LÓGICA (Banco de Dados com Prepared Statements) ---
$sql = "DELETE FROM usuarios WHERE id = ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    $resposta['erro'] = "Erro ao preparar a consulta: " . $conn->error;
} else {
    // "i" = Inteiro
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Verifica se alguma linha foi realmente apagada
        if ($stmt->affected_rows > 0) {
            $resposta['sucesso'] = true;
        } else {
            $resposta['erro'] = "Nenhum usuário encontrado com esse ID.";
        }
    } else {
        $resposta['erro'] = "Erro ao excluir: " . $stmt->error;
    }
    
    $stmt->close();
}

/*
// --- LÓGICA ANTIGA (Arquivo .txt) ---
// ... fopen/ler todas as linhas/unset/fopen/escrever todas as linhas ...
// --- FIM LÓGICA ANTIGA ---
*/

// 3. Fechar a conexão
$conn->close();

// 4. Retornar o JSON
echo json_encode($resposta);
?>