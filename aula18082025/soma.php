<?php
$v1 = $_GET["a"];
$v2 = $_GET["b"];
$op = $_GET["op"];
$result = 0;

if ($op == "+") {
    $result = $v1 + $v2;
} elseif ($op == "-") {
    $result = $v1 - $v2;
} elseif ($op == '*') {
    $result = $v1 * $v2;
} elseif ($op == '/') {
    // Para evitar erro de divisão por zero
    if ($v2 != 0) {
        $result = $v1 / $v2;
    } else {
        $result = "Erro: Divisão por zero.";
    }
}

// Exibe o resultado na tela
echo "<h1>Resultado: " . $result . "</h1>";
?>