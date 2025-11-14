<?php
// api/check_session.php
session_start();
header('Content-Type: application/json');

$response = [
    'logado' => false,
    'nome' => ''
];

if (isset($_SESSION['cliente_id'])) {
    $response['logado'] = true;
    $response['nome'] = $_SESSION['cliente_nome'];
    // Opcional: retornar o telefone também se quiser preencher automático
}

echo json_encode($response);
?>