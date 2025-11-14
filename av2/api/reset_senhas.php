<?php
header('Content-Type: application/json');
require_once 'db_conexao.php';

// 1. Gera o hash VERDADEIRO para a senha '123'
$nova_senha_hash = password_hash('123', PASSWORD_DEFAULT);

// 2. Atualiza todos os usuários da equipe (tabela usuarios)
$sql_usuarios = "UPDATE usuarios SET senha = '$nova_senha_hash'";
$conn->query($sql_usuarios);

// 3. Atualiza todos os clientes (tabela clientes) - Opcional, só pra facilitar seus testes
$sql_clientes = "UPDATE clientes SET senha = '$nova_senha_hash'";
$conn->query($sql_clientes);

echo json_encode([
    "sucesso" => true, 
    "mensagem" => "Todas as senhas foram redefinidas para '123' com sucesso!",
    "hash_gerado" => $nova_senha_hash
]);
?>