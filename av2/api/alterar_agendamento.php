<?php
header('Content-Type: application/json');
require_once 'db_conexao.php'; 

$resposta = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST["id"] ?? '';
    
    // Campos antigos
    $nome_cliente = $_POST["nome_cliente"] ?? '';
    $telefone_cliente = $_POST["telefone_cliente"] ?? '';
    $servico_desejado = $_POST["servico_desejado"] ?? '';
    $data_hora_agendamento = $_POST["data_hora_agendamento"] ?? '';
    
    // --- NOVOS CAMPOS ---
    $nome_profissional = $_POST["nome_profissional"] ?? '';
    $valor = $_POST["valor"] ?? '';
    $forma_pagamento = $_POST["forma_pagamento"] ?? '';

    // Validação simples
    if (empty($id) || empty($servico_desejado)) {
        $resposta['erro'] = "Dados incompletos.";
    } else {
        // SQL ATUALIZADO COM OS NOVOS CAMPOS
        $sql = "UPDATE agendamentos SET 
                nome_cliente = ?, 
                telefone_cliente = ?, 
                servico_desejado = ?, 
                nome_profissional = ?, 
                data_hora_agendamento = ?, 
                valor = ?, 
                forma_pagamento = ? 
                WHERE id = ?";
                
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
             $resposta['erro'] = "Erro ao preparar: " . $conn->error;
        } else {
            // s=string, d=decimal(double), i=integer
            // Ordem: nome, tel, servico, prof, data, valor, pgto, ID
            $stmt->bind_param("sssssdsi", $nome_cliente, $telefone_cliente, $servico_desejado, $nome_profissional, $data_hora_agendamento, $valor, $forma_pagamento, $id);
            
            if ($stmt->execute()) {
                $resposta['sucesso'] = "Agendamento atualizado!";
            } else {
                $resposta['erro'] = "Erro ao alterar: " . $stmt->error;
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