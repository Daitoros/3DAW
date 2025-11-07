<?php
header('Content-Type: application/json');
require_once 'db_conexao.php'; // $conn

$alunos = [];
$sql = "SELECT id, nome, matricula, email FROM alunos ORDER BY nome ASC";

$resultado = $conn->query($sql);

if ($resultado) {
    while ($linha = $resultado->fetch_assoc()) {
        $alunos[] = $linha;
    }
}

$conn->close();
echo json_encode($alunos);
?>