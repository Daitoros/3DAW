<?php
header('Content-Type: application/json');

$id = $_GET['id'] ?? null;
$resposta = [];

if ($id === null || !is_numeric($id) || $id < 1) {
    $resposta['erro'] = "ID de usuário inválido.";
    echo json_encode($resposta);
    exit;
}

if (!file_exists("usuarios.txt")) {
    $resposta['erro'] = "Arquivo de usuários não encontrado.";
    echo json_encode($resposta);
    exit;
}

$arquivo = fopen("usuarios.txt", "r");
$i = 0; // Contador de linha (0 = cabeçalho, 1 = primeiro usuário)
$usuario_encontrado = false;

while (($linha = fgets($arquivo)) !== false) {
    if ($i == $id) {
        $dados = explode(";", trim($linha));
        
        $resposta = [
            'usuario' => $dados[0] ?? '',
            'senha' => $dados[1] ?? '',
            'funcao' => $dados[2] ?? ''
        ];
        $usuario_encontrado = true;
        break;
    }
    $i++;
}
fclose($arquivo);

if (!$usuario_encontrado) {
    $resposta['erro'] = "Usuário com o código " . htmlspecialchars($id) . " não encontrado.";
}

// Retorna o JSON para o JavaScript
echo json_encode($resposta);
?>