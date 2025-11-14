<?php
$servidor = "localhost";
$usuario_db = "root";
$senha_db = ""; 
$nome_db = "sistema_integrado"; // <--- CONFIRA SE ESTÁ ESCRITO ISSO AQUI

$conn = new mysqli($servidor, $usuario_db, $senha_db, $nome_db);

if ($conn->connect_error) {
    header('Content-Type: application/json');
    echo json_encode(['erro' => 'Falha na conexão: ' . $conn->connect_error]);
    exit;
}
$conn->set_charset("utf8");
?>