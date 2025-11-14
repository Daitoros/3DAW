<?php
header('Content-Type: application/json');
require_once 'db_conexao.php'; // $conn

$resposta = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"] ?? '';
    $nome = $_POST["nome"] ?? '';
    $matricula = $_POST["matricula"] ?? '';
    $email = $_POST["email"] ?? '';

    if (empty($id) || empty($nome) || empty($matricula) || empty($email)) {
        $resposta['erro'] = "Todos os campos são obrigatórios.";
    } else {
        $sql = "UPDATE alunos SET nome = ?, matricula = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
             $resposta['erro'] = "Erro ao preparar a consulta: " . $conn->error;
        } else {
            $stmt->bind_param("sssi", $nome, $matricula, $email, $id);
            
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $resposta['sucesso'] = "Aluno alterado com sucesso!";
                } else {
                    $resposta['info'] = "Nenhum dado foi alterado.";
                }
            } else {
                 if ($conn->errno == 1062) { // Erro de duplicata
                    $resposta['erro'] = "Matrícula ou Email já existem em outro registo.";
                } else {
                    $resposta['erro'] = "Erro ao alterar aluno: " . $stmt->error;
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