<?php
header('Content-Type: application/json');
require_once 'db_conexao.php'; // $conn

$resposta = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST["nome"] ?? '';
    $matricula = $_POST["matricula"] ?? '';
    $email = $_POST["email"] ?? '';

    if (empty($nome) || empty($matricula) || empty($email)) {
        $resposta['erro'] = "Nome, matrícula e email são obrigatórios.";
    } else {
        $sql = "INSERT INTO alunos (nome, matricula, email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            $resposta['erro'] = "Erro ao preparar a consulta: " . $conn->error;
        } else {
            $stmt->bind_param("sss", $nome, $matricula, $email);
            
            if ($stmt->execute()) {
                $resposta['sucesso'] = "Aluno incluído com sucesso!";
            } else {
                if ($conn->errno == 1062) { // Erro de duplicata
                    $resposta['erro'] = "Matrícula ou Email já existem.";
                } else {
                    $resposta['erro'] = "Erro ao incluir aluno: " . $stmt->error;
                }
            }
            $stmt->close();
        }
    }
} else {
    $resposta['erro'] = "Método não permitido.";
}

$conn->close();
echo json_encode($resposta);
?>