<?php
header('Content-Type: application/json');

$perguntas = [];

if (!file_exists("perguntas.txt")) {
    echo json_encode($perguntas); // Retorna array vazio se o arquivo não existe
    exit;
}

$arquivo = fopen("perguntas.txt", "r");
fgets($arquivo); // Descarta o cabeçalho

while (($linha = fgets($arquivo)) !== false) {
    $dados = explode(";", trim($linha));
    
    // Garante que os dados existam antes de atribuir
    $perguntas[] = [
        'pergunta' => $dados[0] ?? '',
        'resp1' => $dados[1] ?? '',
        'resp2' => $dados[2] ?? '',
        'resp3' => $dados[3] ?? '',
        'respCerta' => $dados[4] ?? ''
    ];
}
fclose($arquivo);

echo json_encode($perguntas);
?>