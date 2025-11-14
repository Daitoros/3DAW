<?php
header('Content-Type: application/json');
require_once 'db_conexao.php'; // $conn

$resposta = [];
$id = $_GET['id'] ?? null;

if (empty($id) || !is_numeric($id)) {
    $resposta['erro'] = "ID do agendamento inválido.";
} else {
    $sql = "SELECT * FROM agendamentos WHERE id = ?";
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
                $resposta['erro'] = "Agendamento não encontrado.";
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