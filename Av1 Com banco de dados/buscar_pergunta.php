<?php
// Define o cabeçalho da resposta como JSON
header('Content-Type: application/json');

// 1. Incluir o arquivo de conexão
// Isso nos dá a variável $conn
require_once 'db_conexao.php'; 

$resposta = []; // Array que será convertido em JSON

// 2. Pega o ID enviado pelo JavaScript (via URL, ex: ...?id=5)
$id = $_GET['id'] ?? null; 

// 3. Validação do ID
if ($id === null || !is_numeric($id) || $id < 1) {
    $resposta['erro'] = "ID da pergunta inválido.";
    echo json_encode($resposta);
    $conn->close(); // Fecha a conexão antes de sair
    exit; // Para a execução
}

// 4. Prepara a consulta SQL (Usando Prepared Statement para segurança)
// Selecionamos os campos que o frontend (JavaScript) espera receber
$sql = "SELECT pergunta, resp1, resp2, resp3, respCerta FROM perguntas WHERE id = ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    $resposta['erro'] = "Erro ao preparar a consulta: " . $conn->error;
} else {
    // 5. Vincula o ID à consulta
    // "i" significa que a variável $id é um Inteiro
    $stmt->bind_param("i", $id);

    // 6. Executa a consulta
    if ($stmt->execute()) {
        $resultado = $stmt->get_result(); // Pega o conjunto de resultados
        
        // 7. Verifica se encontrou uma pergunta
        if ($resultado->num_rows === 1) {
            // Pega a linha encontrada e a coloca no nosso array de resposta
            $resposta = $resultado->fetch_assoc();
        } else {
            $resposta['erro'] = "Pergunta com o ID " . htmlspecialchars($id) . " não encontrada.";
        }
    } else {
        $resposta['erro'] = "Erro ao executar a consulta: " . $stmt->error;
    }
    
    // 8. Fecha o statement
    $stmt->close();
}

// 9. Fecha a conexão com o banco
$conn->close();

// 10. Envia a resposta (os dados da pergunta ou o erro) em formato JSON
echo json_encode($resposta);
?>