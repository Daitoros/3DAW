<?php
header('Content-Type: application/json');
require_once 'db_conexao.php';

$resposta = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $funcao = $_POST['funcao'] ?? '';

    // 1. Validação Básica
    if (empty($usuario) || empty($senha) || empty($funcao)) {
        $resposta['erro'] = "Preencha todos os campos (usuário, senha e função).";
    } else {
        // 2. Verifica se já existe
        $check = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ?");
        $check->bind_param("s", $usuario);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $resposta['erro'] = "Erro: O usuário '$usuario' já existe.";
        } else {
            // 3. Criptografa a senha e insere
            $hash = password_hash($senha, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (usuario, senha, funcao) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            if ($stmt === false) {
                $resposta['erro'] = "Erro SQL (Prepare): " . $conn->error;
            } else {
                $stmt->bind_param("sss", $usuario, $hash, $funcao);

                if ($stmt->execute()) {
                    $resposta['sucesso'] = "Usuário cadastrado com sucesso!";
                } else {
                    $resposta['erro'] = "Erro ao salvar no banco: " . $stmt->error;
                }
                $stmt->close();
            }
        }
        $check->close();
    }
} else {
    $resposta['erro'] = "Método inválido.";
}

$conn->close();
echo json_encode($resposta);
?>