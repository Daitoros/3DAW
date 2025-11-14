<?php
header('Content-Type: application/json');

// 1. Incluir a conexão
require_once 'db_conexao.php'; // $conn

$resposta = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 2. Pega os dados do POST
    $usuario = $_POST["usuario"] ?? '';
    $senha = $_POST["senha"] ?? '';
    $funcao = $_POST["funcao"] ?? '';

    // 3. Validação
    if (empty($usuario) || empty($senha) || empty($funcao)) {
        $resposta['erro'] = "Todos os campos são obrigatórios.";
        echo json_encode($resposta);
        $conn->close();
        exit;
    }

    // 4. --- NOVA LÓGICA (Banco de Dados com Hashing) ---

    // *** ETAPA DE SEGURANÇA MAIS IMPORTANTE ***
    // Criptografa a senha antes de salvar
    $hash_senha = password_hash($senha, PASSWORD_DEFAULT);

    // SQL para inserir
    $sql = "INSERT INTO usuarios (usuario, senha, funcao) VALUES (?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        $resposta['erro'] = "Erro ao preparar a consulta: " . $conn->error;
    } else {
        // "sss" = 3 strings (usuario, hash_senha, funcao)
        $stmt->bind_param("sss", $usuario, $hash_senha, $funcao);

        if ($stmt->execute()) {
            // Verifica se foi o primeiro cadastro (usando o ID)
            $ultimo_id = $conn->insert_id;
            if ($ultimo_id == 1) {
                $resposta['sucesso_primeiro_cadastro'] = true;
            }
            $resposta['sucesso'] = "Usuário '{$usuario}' criado com sucesso!";
        } else {
            // Trata erro de usuário duplicado (UNIQUE)
            if ($conn->errno == 1062) { // 1062 = Erro de entrada duplicada
                $resposta['erro'] = "Este nome de usuário já existe.";
            } else {
                $resposta['erro'] = "Erro ao salvar o usuário: " . $stmt->error;
            }
        }
        
        $stmt->close();
    }

} else {
    $resposta['erro'] = "Método não permitido.";
}

// 5. Fechar a conexão
$conn->close();

// 6. Retornar o JSON
echo json_encode($resposta);
?>