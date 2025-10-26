<?php
header('Content-Type: application/json');

$resposta = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pega os dados do POST
    $pergunta = $_POST["pergunta"] ?? '';
    $resp1 = $_POST["resp1"] ?? '';
    $resp2 = $_POST["resp2"] ?? '';
    $resp3 = $_POST["resp3"] ?? '';
    $respCerta = $_POST["respCerta"] ?? '';

    // Validação básica
    if (empty($pergunta) || empty($respCerta)) {
        $resposta['erro'] = "Os campos 'Pergunta' e 'Resposta Certa' são obrigatórios.";
        echo json_encode($resposta);
        exit;
    }

    // Se o arquivo não existe, cria com o cabeçalho
    if (!file_exists("perguntas.txt")) {
        $arqDisc = fopen("perguntas.txt", "w");
        if (!$arqDisc) {
            $resposta['erro'] = "Falha ao criar o arquivo.";
            echo json_encode($resposta);
            exit;
        }
        $linha = "pergunta;resp1;resp2;resp3;respCerta\n";
        fwrite($arqDisc, $linha);
        fclose($arqDisc);
    }
    
    // Abre o arquivo para adicionar (append)
    $arqDisc = fopen("perguntas.txt", "a");
    if (!$arqDisc) {
        $resposta['erro'] = "Erro fatal ao abrir o arquivo de perguntas.";
        echo json_encode($resposta);
        exit;
    }

    // Monta a linha
    $linha = $pergunta . ";" . $resp1 . ";" . $resp2 . ";" . $resp3 . ";" . $respCerta . "\n";
    
    // Escreve no arquivo
    if (fwrite($arqDisc, $linha)) {
        $resposta['sucesso'] = "Pergunta criada com sucesso!";
    } else {
        $resposta['erro'] = "Erro ao salvar a pergunta no arquivo.";
    }
    
    fclose($arqDisc);

} else {
    $resposta['erro'] = "Método não permitido.";
}

echo json_encode($resposta);
?>