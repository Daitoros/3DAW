<?php
session_start(); 
header('Content-Type: application/json');
require_once 'db_conexao.php'; 

$resposta = [];

// --- 1. VERIFICAÇÃO DE SEGURANÇA ---
// Permite se for Cliente logado OU se for Staff logado (Gestor/Atendente)
$is_cliente = isset($_SESSION['cliente_id']);
$is_staff = isset($_SESSION['usuario_funcao']) && in_array($_SESSION['usuario_funcao'], ['gestor', 'atendente']);

// Se NÃO for cliente E NÃO for staff, bloqueia
if (!$is_cliente && !$is_staff) {
    echo json_encode(['erro' => 'Acesso negado. Faça login.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // --- 2. RECEBE OS DADOS COMUNS ---
    $servico_desejado = $_POST["servico_desejado"] ?? '';
    $nome_profissional = $_POST["nome_profissional"] ?? '';
    $data_hora_agendamento = $_POST["data_hora_agendamento"] ?? '';
    $valor = $_POST["valor"] ?? '';
    $forma_pagamento = $_POST["forma_pagamento"] ?? 'Balcão'; // Padrão se vier do admin

    // --- 3. IDENTIFICA QUEM É O CLIENTE ---
    $nome_cliente = "";
    $telefone_cliente = "";
    $id_cliente = null; // Fica NULL se for agendado pelo gestor para um visitante

    if ($is_cliente) {
        // CASO A: Cliente logado agendando para si mesmo
        $id_cliente = $_SESSION['cliente_id'];
        
        // Busca dados atualizados no banco para garantir integridade
        $busca = $conn->prepare("SELECT nome, telefone FROM clientes WHERE id = ?");
        $busca->bind_param("i", $id_cliente);
        $busca->execute();
        $res = $busca->get_result();
        $dados = $res->fetch_assoc();
        
        $nome_cliente = $dados['nome'];
        $telefone_cliente = $dados['telefone'];
        $busca->close();

    } else {
        // CASO B: Gestor/Recepção agendando para um cliente avulso
        // Eles PRECISAM enviar o nome e telefone pelo formulário
        $nome_cliente = $_POST["nome_cliente"] ?? '';
        $telefone_cliente = $_POST["telefone_cliente"] ?? '';
        
        if (empty($nome_cliente) || empty($telefone_cliente)) {
            echo json_encode(['erro' => 'Nome e Telefone do cliente são obrigatórios para agendamento no balcão.']);
            exit;
        }
    }

    // --- 4. VALIDAÇÃO E INSERÇÃO ---
    if (empty($servico_desejado) || empty($nome_profissional) || empty($data_hora_agendamento)) {
        $resposta['erro'] = "Preencha todos os dados do agendamento.";
    } else {
        // SQL com as novas colunas
        $sql = "INSERT INTO agendamentos (nome_cliente, telefone_cliente, servico_desejado, nome_profissional, data_hora_agendamento, valor, forma_pagamento, id_cliente) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            $resposta['erro'] = "Erro SQL: " . $conn->error;
        } else {
            // Tipos: s=string, d=decimal/double, i=integer
            $stmt->bind_param("sssssdsi", $nome_cliente, $telefone_cliente, $servico_desejado, $nome_profissional, $data_hora_agendamento, $valor, $forma_pagamento, $id_cliente);
            
            if ($stmt->execute()) {
                $resposta['sucesso'] = "Agendamento realizado com sucesso!";
            } else {
                $resposta['erro'] = "Erro ao gravar: " . $stmt->error;
            }
            $stmt->close();
        }
    }
} else {
    $resposta['erro'] = "Método inválido.";
}

$conn->close();
echo json_encode($resposta);
?>