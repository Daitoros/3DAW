<?php
// Detalhes da conexão
$servidor = "localhost"; // Geralmente 'localhost'
$usuario_db = "root";      // Seu usuário do MySQL
$senha_db = "";          // Sua senha do MySQL
$nome_db = "av1_javascript"; // O nome do seu banco de dados

// Criar a conexão
$conn = new mysqli($servidor, $usuario_db, $senha_db, $nome_db);

// Checar a conexão
if ($conn->connect_error) {
    // Se a conexão falhar, retorna um JSON de erro e para tudo
    header('Content-Type: application/json');
    echo json_encode(['erro' => 'Falha na conexão com o banco de dados: ' . $conn->connect_error]);
    exit;
}

// Garante que os dados sejam lidos e escritos em UTF-8
$conn->set_charset("utf8");

// A variável $conn estará disponível para qualquer arquivo que incluir este.
?>