<?php
header('Content-Type: application/json');

// 1. Incluir a conexão
require_once 'db_conexao.php'; // $conn

$perguntas = [];

// 2. --- NOVA LÓGICA (Banco de Dados) ---
// O 'id' é crucial - é a chave primária do banco
$sql = "SELECT id, pergunta, resp1, resp2, resp3, respCerta FROM perguntas ORDER BY id ASC";

$resultado = $conn->query($sql);

if ($resultado === false) {
    echo json_encode(['erro' => 'Erro na consulta SQL: ' . $conn->error]);
    $conn->close();
    exit;
}

// 3. Coletar os resultados
if ($resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        // Adiciona a linha (que já é um array com 'id', 'pergunta', etc.)
        $perguntas[] = $linha; 
    }
}

// --- LÓGICA ANTIGA (Arquivo .txt) ---
// ... fopen/fgets ...
// --- FIM LÓGICA ANTIGA ---

// 4. Fechar a conexão
$conn->close();

// 5. Retornar o JSON
echo json_encode($perguntas);
?>