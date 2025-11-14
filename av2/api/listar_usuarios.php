<?php
header('Content-Type: application/json');
require_once 'db_conexao.php'; // Confere se este arquivo está na mesma pasta

$usuarios = [];
$sql = "SELECT id, usuario, funcao FROM usuarios ORDER BY id ASC"; // Removi 'senha' por segurança e simplicidade

$resultado = $conn->query($sql);

if ($resultado) {
    while ($linha = $resultado->fetch_assoc()) {
        $usuarios[] = $linha;
    }
}

$conn->close();
echo json_encode($usuarios);
?>