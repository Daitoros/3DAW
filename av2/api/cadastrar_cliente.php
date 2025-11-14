<?php
header('Content-Type: application/json');
require_once 'db_conexao.php'; // $conn

$resposta = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST["nome"] ?? '';
    $email = $_POST["email"] ?? '';
    $telefone = $_POST["telefone"] ?? '';
    $senha = $_POST["senha"] ?? '';

    if (empty($nome) || empty($email) || empty($telefone) || empty($senha)) {
        $resposta['erro'] = "Todos os campos são obrigatórios.";
    } else {
        // 1. Verifica se o email já existe
        $check = $conn->prepare("SELECT id FROM clientes WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $resposta['erro'] = "Este e-mail já está cadastrado.";
        } else {
            // 2. Criptografa a senha
            $hash_senha = password_hash($senha, PASSWORD_DEFAULT);

            // 3. Insere o cliente
            $sql = "INSERT INTO clientes (nome, email, telefone, senha) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            if ($stmt === false) {
                $resposta['erro'] = "Erro no banco de dados.";
            } else {
                $stmt->bind_param("ssss", $nome, $email, $telefone, $hash_senha);
                
                if ($stmt->execute()) {
                    $resposta['sucesso'] = "Cadastro realizado com sucesso! Faça login.";
                } else {
                    $resposta['erro'] = "Erro ao cadastrar: " . $stmt->error;
                }
                $stmt->close();
            }
        }
        $check->close();
    }
}

$conn->close();
echo json_encode($resposta);
?>