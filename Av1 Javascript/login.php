<?php
// Define o cabeçalho como JSON
header('Content-Type: application/json');

$resposta = [
    'logado' => false,
    'mensagem' => 'Método inválido.'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $usuario = $_POST["usuario"] ?? '';
    $senha = $_POST["senha"] ?? '';
    
    $logado = false;
    $funcao = "";
    $mensagem = "Usuário ou senha inválidos."; // Mensagem padrão

    if (!file_exists("usuarios.txt")){
        $mensagem = "Erro: Arquivo de usuários não existe.";
    } else {
        $arquivo = fopen("usuarios.txt", "r") or die("Erro ao abrir arquivo de usuários!");
        fgets($arquivo); // Descarta o cabeçalho
        
        while(($linha = fgets($arquivo)) !== false){
            $dados = explode(";", trim($linha)); 
            
            // Evita erro se a linha estiver mal formatada
            if (count($dados) < 3) continue;

            $user_arq = $dados[0];
            $senha_arq = $dados[1];
            $funcao_arq = $dados[2];

            if ($usuario == $user_arq && $senha == $senha_arq){
                $logado = true;
                $funcao = $funcao_arq;
                break;
            }
        }
        fclose($arquivo);
    }
    
    if ($logado) {
        $resposta = [
            'logado' => true,
            'funcao' => $funcao
        ];
    } else {
        $resposta = [
            'logado' => false,
            'mensagem' => $mensagem
        ];
    }
}

// Retorna o JSON para o JavaScript
echo json_encode($resposta);
?>