<?php
session_start();
header('Content-Type: application/json');
require_once 'db_conexao.php';

if (!isset($_SESSION['cliente_id'])) {
    echo json_encode(['erro' => 'Não autenticado']);
    exit;
}

$id = $_SESSION['cliente_id'];
$sql = "SELECT nome, email, telefone FROM clientes WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

echo json_encode($res->fetch_assoc());
?>