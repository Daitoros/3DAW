<?php
header('Content-Type: application/json');

$resposta = [];
// O ID do usuário é o número da linha no arquivo (ex: 1 é o primeiro usuário)
$numUsuario = $_GET['id'] ?? null; 

if ($numUsuario === null || !is_numeric($numUsuario) || $numUsuario < 1) {
    $resposta['erro'] = "ID de usuário inválido.";
    echo json_encode($resposta);
    exit;
}

$linhas = [];

if (!file_exists("usuarios.txt")) {
    $resposta['erro'] = "Arquivo de usuários não encontrado.";
    echo json_encode($resposta);
    exit;
}

$arquivo = fopen("usuarios.txt", "r");
while (($linha = fgets($arquivo)) !== false) {
    $linhas[] = $linha;
}
fclose($arquivo);

// O $numUsuario (ex: 1) corresponde ao índice [1] no array $linhas
// (pois o índice [0] é o cabeçalho)
if (isset($linhas[$numUsuario])) {
    unset($linhas[$numUsuario]); // Remove a linha
    
    // Reescreve o arquivo
    $arqDisc = fopen("usuarios.txt", "w");
    foreach ($linhas as $linha_salvar) {
        fwrite($arqDisc, $linha_salvar);
    }
    fclose($arqDisc);
    
    $resposta['sucesso'] = true;
} else {
    $resposta['erro'] = "Usuário não encontrado no arquivo.";
}

echo json_encode($resposta);
?>