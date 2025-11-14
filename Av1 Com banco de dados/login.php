<?php
header('Content-Type: application/json');

// 1. Incluir a conexão
require_once 'db_conexao.php'; // $conn

$resposta = [
    'logado' => false,
    'mensagem' => 'Método inválido.'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    // 2. Pega os dados do POST
    $usuario = $_POST["usuario"] ?? '';
    $senha_form = $_POST["senha"] ?? ''; // Senha digitada pelo usuário

    $logado = false;
    $funcao = "";
    $mensagem = "Usuário ou senha inválidos."; // Mensagem padrão

    // 3. Validação básica
    if (empty($usuario) || empty($senha_form)) {
        $resposta['mensagem'] = $mensagem;
        echo json_encode($resposta);
        $conn->close();
        exit;
    }

    // 4. --- NOVA LÓGICA (Banco de Dados com Verificação de Hash) ---
    // Precisamos buscar a senha (hash) e a função do usuário
    $sql = "SELECT senha, funcao FROM usuarios WHERE usuario = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $resposta['mensagem'] = "Erro no servidor (prepare).";
    } else {
        // "s" = 1 string (usuario)
        $stmt->bind_param("s", $usuario);
        
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();

            if ($resultado->num_rows === 1) {
                // Usuário encontrado, agora verifica a senha
                $linha = $resultado->fetch_assoc();
                $hash_banco = $linha['senha']; // A senha criptografada do BD
                $funcao_banco = $linha['funcao'];

                // *** ETAPA DE SEGURANÇA MAIS IMPORTANTE ***
                if (password_verify($senha_form, $hash_banco)) {
                    // Senha CORRETA!
                    $logado = true;
                    $funcao = $funcao_banco;
                }
                // Se for incorreta, não faz nada (mantém $logado = false)
            }
            // Se num_rows === 0, usuário não existe (mantém $logado = false)

        } else {
            $resposta['mensagem'] = "Erro no servidor (execute).";
        }
        $stmt->close();
    }
    
    // 5. Monta a resposta final
    if ($logado) {
        $resposta = [
            'logado' => true,
            'funcao' => $funcao
        ];
    } else {
        $resposta = [
            'logado' => false,
            'mensagem' => $mensagem // Sempre retorna a msg genérica por segurança
        ];
    }
}

// 6. Fechar a conexão
$conn->close();

// 7. Retornar o JSON
echo json_encode($resposta);
?>