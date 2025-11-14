<?php
// Inicia a sessão para guardar o ID do cliente
session_start(); 
header('Content-Type: application/json');
require_once 'db_conexao.php'; // $conn

$resposta = [
    'logado' => false,
    'mensagem' => 'Método inválido.'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST["email"] ?? '';
    $senha_form = $_POST["senha"] ?? '';
    
    $mensagem = "Email ou senha inválidos.";

    if (empty($email) || empty($senha_form)) {
        $resposta['mensagem'] = $mensagem;
    } else {
        $sql = "SELECT id, nome, senha FROM clientes WHERE email = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            $resposta['mensagem'] = "Erro no servidor (prepare).";
        } else {
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                $resultado = $stmt->get_result();
                if ($resultado->num_rows === 1) {
                    $linha = $resultado->fetch_assoc();
                    $hash_banco = $linha['senha'];

                    // Verifica a senha criptografada
                    if (password_verify($senha_form, $hash_banco)) {
                        $resposta = [
                            'logado' => true,
                            'nome_cliente' => $linha['nome']
                        ];
                        // Salva o ID e Nome do cliente na sessão
                        $_SESSION['cliente_id'] = $linha['id'];
                        $_SESSION['cliente_nome'] = $linha['nome'];
                    } else {
                        $resposta['mensagem'] = $mensagem;
                    }
                } else {
                    $resposta['mensagem'] = $mensagem;
                }
            } else {
                 $resposta['mensagem'] = "Erro no servidor (execute).";
            }
            $stmt->close();
        }
    }
}

$conn->close();
echo json_encode($resposta);
?>