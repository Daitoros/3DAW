<?php
header('Content-Type: application/json');

$resposta = [];

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $resposta['erro'] = "Método inválido.";
    echo json_encode($resposta);
    exit;
}

// Pega os dados do POST
$numUsuario = $_POST["id"];
$usuario = $_POST["usuario"];
$senha = $_POST["senha"];
$funcao = $_POST["funcao"];

if (empty($numUsuario) || empty($usuario) || empty($senha) || empty($funcao)) {
     $resposta['erro'] = "Todos os campos são obrigatórios.";
    echo json_encode($resposta);
    exit;
}

$novaLinha = $usuario . ";" . $senha . ";" . $funcao . "\n";
$linhas = [];

if (!file_exists("usuarios.txt")) {
    $resposta['erro'] = "Arquivo de usuários não encontrado.";
    echo json_encode($resposta);
    exit;
}

// 1. LER TODAS AS LINHAS
$arquivo = fopen("usuarios.txt", "r");
while (($linha = fgets($arquivo)) !== false) {
    $linhas[] = $linha;
}
fclose($arquivo);

// 2. ALTERAR A LINHA NO ARRAY (Índice 0 é o cabeçalho)
if (isset($linhas[$numUsuario])) {
    $linhas[$numUsuario] = $novaLinha;

    // 3. REESCREVER O ARQUIVO
    $arqDisc = fopen("usuarios.txt", "w");
    foreach ($linhas as $linha_salvar) {
        fwrite($arqDisc, $linha_salvar);
    }
    fclose($arqDisc);
    
    $resposta['sucesso'] = "Usuário alterado com sucesso!";
} else {
    $resposta['erro'] = "Erro: Usuário não encontrado no arquivo.";
}

echo json_encode($resposta);
?>