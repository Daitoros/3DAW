<?php
header('Content-Type: application/json');
require_once 'db_conexao.php'; 

$agendamentos = [];

// Seleciona todos os agendamentos
// Ordena por data: Do mais recente para o mais antigo (DESC)
$sql = "SELECT * FROM agendamentos ORDER BY data_hora_agendamento DESC";

$resultado = $conn->query($sql);

if ($resultado) {
    while ($linha = $resultado->fetch_assoc()) {
        
        // 1. Formatação de Segurança para a Data (YYYY-MM-DD -> DD/MM/YYYY)
        if (!empty($linha['data_hora_agendamento'])) {
            $timestamp = strtotime($linha['data_hora_agendamento']);
            $linha['data_hora_formatada'] = date('d/m/Y H:i', $timestamp);
        } else {
            $linha['data_hora_formatada'] = '--/--/---- --:--';
        }
        
        // 2. Garante que campos opcionais não quebrem o JSON se estiverem NULL
        $linha['valor'] = $linha['valor'] ?? '0.00';
        $linha['nome_profissional'] = $linha['nome_profissional'] ?? 'Não informado';
        
        $agendamentos[] = $linha;
    }
} else {
    // Retorna erro SQL se houver
    echo json_encode(['erro' => 'Erro SQL: ' . $conn->error]);
    $conn->close();
    exit;
}

$conn->close();

// Retorna a lista limpa em JSON
echo json_encode($agendamentos);
?>