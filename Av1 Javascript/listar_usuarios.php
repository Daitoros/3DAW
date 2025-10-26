<?php
header('Content-Type: application/json');

$usuarios = [];

if (!file_exists("usuarios.txt")) {
    echo json_encode($usuarios); // Retorna array vazio se o arquivo não existe
    exit;
}

$arquivo = fopen("usuarios.txt", "r");
if (!$arquivo) {
    echo json_encode($usuarios); // Retorna array vazio em caso de falha
    exit;
}

fgets($arquivo); // Descarta o cabeçalho

while (($linha = fgets($arquivo)) !== false) {
    $dados = explode(";", trim($linha));
    
    // Garante que a linha está formatada corretamente
    if (count($dados) >= 3) {
        $usuarios[] = [
            'usuario' => $dados[0],
            'senha' => $dados[1], // Nota: Em um app real, não envie a senha!
            'funcao' => $dados[2]
        ];
    }
}
fclose($arquivo);

echo json_encode($usuarios);
?>