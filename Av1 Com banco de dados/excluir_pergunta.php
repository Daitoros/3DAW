<?php
header('Content-Type: application/json');

$resposta = [];
$numPergunta = $_GET['id'] ?? null;

if ($numPergunta === null || !is_numeric($numPergunta)) {
    $resposta['erro'] = "ID inválido.";
    echo json_encode($resposta);
    exit;
}

$linhas = [];

if (!file_exists("perguntas.txt")) {
    $resposta['erro'] = "Arquivo não encontrado.";
    echo json_encode($resposta);
    exit;
}

$arquivo = fopen("perguntas.txt", "r");
while (($linha = fgets($arquivo)) !== false) {
    $linhas[] = $linha;
}
fclose($arquivo);

if (isset($linhas[$numPergunta])) {
    unset($linhas[$numPergunta]); // Remove a linha
    
    // Reescreve o arquivo
    $arqDisc = fopen("perguntas.txt", "w");
    foreach ($linhas as $linha_salvar) {
        fwrite($arqDisc, $linha_salvar);
    }
    fclose($arqDisc);
    
    $resposta['sucesso'] = true;
} else {
    $resposta['erro'] = "Pergunta não encontrada.";
}

echo json_encode($resposta);
?>