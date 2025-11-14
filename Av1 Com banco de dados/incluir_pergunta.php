<?php
header('Content-Type: application/json');

// 1. Incluir o arquivo de conexão
require_once 'db_conexao.php'; // A variável $conn vem daqui

$resposta = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 2. Pegar os dados (sem alteração)
    $pergunta = $_POST["pergunta"] ?? '';
    $resp1 = $_POST["resp1"] ?? '';
    $resp2 = $_POST["resp2"] ?? '';
    $resp3 = $_POST["resp3"] ?? '';
    $respCerta = $_POST["respCerta"] ?? '';

    // Validação básica (sem alteração)
    if (empty($pergunta) || empty($respCerta)) {
        $resposta['erro'] = "Os campos 'Pergunta' e 'Resposta Certa' são obrigatórios.";
        echo json_encode($resposta);
        $conn->close(); // Fecha a conexão
        exit;
    }

    /*
    // --- LÓGICA ANTIGA (manipulação de arquivo) ---
    // if (!file_exists("perguntas.txt")) { ... }
    // $arqDisc = fopen("perguntas.txt", "a");
    // $linha = $pergunta . ";" . $resp1 . ";" . ...
    // fwrite($arqDisc, $linha);
    // fclose($arqDisc);
    // --- FIM DA LÓGICA ANTIGA ---
    */

    // 3. --- NOVA LÓGICA (Banco de Dados com Prepared Statements) ---
    
    // O SQL de Inserção. Os '?' são marcadores de posição.
    $sql = "INSERT INTO perguntas (pergunta, resp1, resp2, resp3, respCerta) VALUES (?, ?, ?, ?, ?)";

    // Prepara a consulta (previne SQL Injection)
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $resposta['erro'] = "Erro ao preparar a consulta: " . $conn->error;
    } else {
        // "sssss" significa que estamos passando 5 variáveis do tipo String
        $stmt->bind_param("sssss", $pergunta, $resp1, $resp2, $resp3, $respCerta);

        // Executa a consulta
        if ($stmt->execute()) {
            $resposta['sucesso'] = "Pergunta criada com sucesso!";
        } else {
            $resposta['erro'] = "Erro ao salvar a pergunta: " . $stmt->error;
        }
        
        // Fecha o statement
        $stmt->close();
    }

} else {
    $resposta['erro'] = "Método não permitido.";
}

// 4. Fecha a conexão com o banco
$conn->close();

// 5. Retorna o JSON (sem alteração)
echo json_encode($resposta);
?>