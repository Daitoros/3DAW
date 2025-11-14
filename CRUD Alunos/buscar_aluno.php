<?php
header('Content-Type: application/json');
require_once 'db_conexao.php'; // $conn

$resposta = [];
$id = $_GET['id'] ?? null;

if (empty($id) || !is_numeric($id)) {
    $resposta['erro'] = "ID do aluno inválido.";
} else {
    $sql = "SELECT nome, matricula, email FROM alunos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        $resposta['erro'] = "Erro ao preparar a consulta.";
    } else {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $resultado = $stmt->get_result();
            if ($resultado->num_rows === 1) {
                $resposta = $resultado->fetch_assoc();
            } else {
                $resposta['erro'] = "Aluno não encontrado.";
            }
        } else {
             $resposta['erro'] = "Erro ao executar a busca.";
        }
        $stmt->close();
    }
}

$conn->close();
echo json_encode($resposta);
?>