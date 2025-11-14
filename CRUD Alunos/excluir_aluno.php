<?php
header('Content-Type: application/json');
require_once 'db_conexao.php'; // $conn

$resposta = [];
$id = $_GET['id'] ?? null;

if (empty($id) || !is_numeric($id)) {
    $resposta['erro'] = "ID do aluno inválido.";
} else {
    $sql = "DELETE FROM alunos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        $resposta['erro'] = "Erro ao preparar a consulta.";
    } else {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $resposta['sucesso'] = true;
            } else {
                $resposta['erro'] = "Aluno não encontrado ou já excluído.";
            }
        } else {
             $resposta['erro'] = "Erro ao excluir aluno.";
        }
        $stmt->close();
    }
}

$conn->close();
echo json_encode($resposta);
?>