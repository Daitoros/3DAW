<?php
header('Content-Type: application/json');
require_once 'db_conexao.php'; // $conn

$resposta = [];
$id = $_GET['id'] ?? null;

if (empty($id) || !is_numeric($id)) {
    $resposta['erro'] = "ID do agendamento inválido.";
} else {
    $sql = "DELETE FROM agendamentos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        $resposta['erro'] = "Erro ao preparar a consulta.";
    } else {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $resposta['sucesso'] = true;
            } else {
                $resposta['erro'] = "Agendamento não encontrado ou já excluído.";
            }
        } else {
             $resposta['erro'] = "Erro ao excluir agendamento.";
        }
        $stmt->close();
    }
}

$conn->close();
echo json_encode($resposta);
?>