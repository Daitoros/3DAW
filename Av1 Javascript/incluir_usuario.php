<?php
header('Content-Type: application/json');

$resposta = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pega os dados do POST
    $usuario = $_POST["usuario"] ?? '';
    $senha = $_POST["senha"] ?? '';
    $funcao = $_POST["funcao"] ?? '';

    // Validação básica
    if (empty($usuario) || empty($senha) || empty($funcao)) {
        $resposta['erro'] = "Todos os campos são obrigatórios.";
        echo json_encode($resposta);
        exit;
    }

    $arquivo_existe = file_exists("usuarios.txt");

    // Se o arquivo não existe, cria com o cabeçalho
    if (!$arquivo_existe) {
        $arqDisc = fopen("usuarios.txt", "w");
        if (!$arqDisc) {
            $resposta['erro'] = "Falha ao criar o arquivo de usuários.";
            echo json_encode($resposta);
            exit;
        }
        $linha = "usuario;senha;funcao\n";
        fwrite($arqDisc, $linha);
        fclose($arqDisc);
    }
    
    // Abre o arquivo para adicionar (append)
    $arqDisc = fopen("usuarios.txt", "a");
    if (!$arqDisc) {
        $resposta['erro'] = "Erro fatal ao abrir o arquivo de usuários.";
        echo json_encode($resposta);
        exit;
    }

    // Monta a linha
    $linha = $usuario . ";" . $senha . ";" . $funcao . "\n";
    
    // Escreve no arquivo
    if (fwrite($arqDisc, $linha)) {
        // Se este foi o primeiro usuário (arquivo não existia), define como sucesso tipo 1
        if (!$arquivo_existe) {
            $resposta['sucesso_primeiro_cadastro'] = true;
        }
        $resposta['sucesso'] = "Usuário '{$usuario}' criado com sucesso!";
    } else {
        $resposta['erro'] = "Erro ao salvar o usuário no arquivo.";
    }
    
    fclose($arqDisc);

} else {
    $resposta['erro'] = "Método não permitido.";
}

echo json_encode($resposta);
?>