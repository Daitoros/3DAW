<?php
session_start();
// Destrói todas as variáveis de sessão
session_destroy();

header('Content-Type: application/json');
echo json_encode(['logout' => true]);
?>