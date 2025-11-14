<?php
session_start();
header('Content-Type: application/json');
require_once 'db_conexao.php';

$resposta = ['logado' => false];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Busca na tabela de USUARIOS (Equipe interna)
    $sql = "SELECT id, usuario, senha, funcao FROM usuarios WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $dados = $res->fetch_assoc();
        
        // Verifica a senha
        if (password_verify($senha, $dados['senha'])) {
            $_SESSION['usuario_id'] = $dados['id'];
            $_SESSION['usuario_nome'] = $dados['usuario'];
            $_SESSION['usuario_funcao'] = $dados['funcao'];

            $resposta['logado'] = true;
            $resposta['funcao'] = $dados['funcao']; // Retorna a função para o JS redirecionar
            $resposta['nome'] = $dados['usuario'];
        } else {
            $resposta['erro'] = "Senha incorreta.";
        }
    } else {
        $resposta['erro'] = "Usuário não encontrado.";
    }
}
$conn->close();
echo json_encode($resposta);
?>