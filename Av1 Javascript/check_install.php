<?php
header('Content-Type: application/json');

// Verifica se o arquivo de usuários já existe
$instalado = file_exists('usuarios.txt');

echo json_encode(['instalado' => $instalado]);
?>