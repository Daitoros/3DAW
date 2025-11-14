<?php
header('Content-Type: application/json');
require_once 'db_conexao.php';

$resposta = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha']; // Pode vir vazio
    $funcao = $_POST['funcao'];

    if (empty($senha)) {
        // Se a senha estiver vazia, atualiza tudo MENOS a senha
        $sql = "UPDATE usuarios SET usuario = ?, funcao = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $usuario, $funcao, $id);
    } else {
        // Se digitou senha nova, atualiza TUDO
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "UPDATE usuarios SET usuario = ?, senha = ?, funcao = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $usuario, $hash, $funcao, $id);
    }

    if ($stmt->execute()) {
        $resposta['sucesso'] = "Usuário atualizado!";
    } else {
        $resposta['erro'] = "Erro ao atualizar: " . $stmt->error;
    }
}
$conn->close();
echo json_encode($resposta);
?>