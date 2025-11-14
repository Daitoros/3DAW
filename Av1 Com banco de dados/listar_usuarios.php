<?php
header('Content-Type: application/json');

// 1. Incluir a conexão
require_once 'db_conexao.php'; // $conn

$usuarios = [];

// 2. --- NOVA LÓGICA (Banco de Dados) ---
// Selecionamos o ID, utilizador, senha (para manter a consistência) e função
// O 'id' é a chave primária do banco
$sql = "SELECT id, usuario, senha, funcao FROM usuarios ORDER BY id ASC";

$resultado = $conn->query($sql);

if ($resultado === false) {
    echo json_encode(['erro' => 'Erro na consulta SQL: ' . $conn->error]);
    $conn->close();
    exit;
}

// 3. Coletar os resultados
if ($resultado->num_rows > 0) {
    while ($linha = $resultado->fetch_assoc()) {
        $usuarios[] = $linha;
    }
}

/*
// --- LÓGICA ANTIGA (Arquivo .txt) ---
// ... fopen/fgets/loop ...
// --- FIM LÓGICA ANTIGA ---
*/

// 4. Fechar a conexão
$conn->close();

// 5. Retornar o JSON
echo json_encode($usuarios);
?>