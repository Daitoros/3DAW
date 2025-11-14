<?php
session_start();
header('Content-Type: application/json');
require_once 'db_conexao.php'; 

if (!isset($_SESSION['cliente_id'])) {
    echo json_encode(['erro' => 'Cliente não autenticado.']);
    exit;
}

$id_cliente_logado = $_SESSION['cliente_id'];
$agendamentos = [];

// SQL ATUALIZADO: Seleciona todos os novos campos
$sql = "SELECT id, servico_desejado, nome_profissional, data_hora_agendamento, valor, forma_pagamento 
        FROM agendamentos 
        WHERE id_cliente = ? 
        ORDER BY data_hora_agendamento DESC";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['erro' => 'Erro SQL: ' . $conn->error]);
} else {
    $stmt->bind_param("i", $id_cliente_logado);
    
    if ($stmt->execute()) {
        $resultado = $stmt->get_result();
        while ($linha = $resultado->fetch_assoc()) {
            // Formata a data (DD/MM/AAAA HH:MM)
            if (!empty($linha['data_hora_agendamento'])) {
                $linha['data_hora_formatada'] = date('d/m/Y H:i', strtotime($linha['data_hora_agendamento']));
            } else {
                $linha['data_hora_formatada'] = '--/--';
            }

            // Formata o valor para exibir bonito (R$ 80,00) se precisar usar direto
            // Mas vamos mandar o número puro e formatar no JS, ou vice-versa.
            // Vamos mandar como está para ser simples.
            $linha['valor'] = $linha['valor'] ?? 0;
            
            $agendamentos[] = $linha;
        }
    }
    $stmt->close();
}

$conn->close();
echo json_encode($agendamentos);
?>