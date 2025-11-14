<?php
header('Content-Type: application/json');

// 1. Incluir a conexão
require_once 'db_conexao.php'; // $conn

// 2. --- NOVA LÓGICA (Banco de Dados) ---
// Vamos contar quantos usuários existem na tabela
$sql = "SELECT COUNT(*) as total_usuarios FROM usuarios";

$instalado = false; // Começa como falso

$resultado = $conn->query($sql);

if ($resultado) {
    $linha = $resultado->fetch_assoc();
    // Se o total for maior que 0, o sistema está "instalado"
    if ($linha['total_usuarios'] > 0) {
        $instalado = true;
    }
}
// Se a consulta falhar, ele permanecerá falso,
// o que é seguro, mas pode indicar um erro de tabela.

/*
// --- LÓGICA ANTIGA (Arquivo .txt) ---
// $instalado = file_exists('usuarios.txt');
// --- FIM LÓGICA ANTIGA ---
*/

// 3. Fechar a conexão
$conn->close();

// 4. Retornar o JSON
echo json_encode(['instalado' => $instalado]);
?>