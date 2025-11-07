<?php
header('Content-Type: application/json');

// 1. Incluir a conexão
require_once 'db_conexao.php'; // $conn

$resposta = [];

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $resposta['erro'] = "Método inválido.";
    echo json_encode($resposta);
    $conn->close();
    exit;
}

// 2. Pega os dados do POST
$id = $_POST["id"];
$usuario = $_POST["usuario"];
$senha = $_POST["senha"]; // Pode estar em branco
$funcao = $_POST["funcao"];

if (empty($id) || empty($usuario) || empty($funcao)) {
     $resposta['erro'] = "ID, Utilizador e Função são obrigatórios.";
    echo json_encode($resposta);
    $conn->close();
    exit;
}

// 3. --- LÓGICA DE ATUALIZAÇÃO COM SENHA OPCIONAL ---

$sql = "";
$tipos = ""; // s, i, etc.
$parametros = []; // array para as variáveis

if (!empty($senha)) {
    // --- O Utilizador QUER MUDAR A SENHA ---
    $hash_senha = password_hash($senha, PASSWORD_DEFAULT);
    
    $sql = "UPDATE usuarios SET usuario = ?, senha = ?, funcao = ? WHERE id = ?";
    $tipos = "sssi"; // string, string, string, integer
    
    // Liga os parâmetros (referências)
    $parametros[] = &$usuario;
    $parametros[] = &$hash_senha;
    $parametros[] = &$funcao;
    $parametros[] = &$id;

} else {
    // --- O Utilizador NÃO quer mudar a senha ---
    // Atualiza tudo, MENOS a senha
    $sql = "UPDATE usuarios SET usuario = ?, funcao = ? WHERE id = ?";
    $tipos = "ssi"; // string, string, integer
    
    // Liga os parâmetros (referências)
    $parametros[] = &$usuario;
    $parametros[] = &$funcao;
    $parametros[] = &$id;
}

// 4. Prepara e Executa a consulta
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    $resposta['erro'] = "Erro ao preparar a consulta: " . $conn->error;
} else {
    // Chama o bind_param dinamicamente
    call_user_func_array(array($stmt, 'bind_param'), array_merge(array($tipos), $parametros));

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $resposta['sucesso'] = "Utilizador alterado com sucesso!";
        } else {
            // Se o utilizador clicar em Salvar sem mudar nada
            $resposta['info'] = "Nenhum dado foi alterado."; 
        }
    } else {
        // Trata erro de utilizador duplicado (UNIQUE)
        if ($conn->errno == 1062) { 
            $resposta['erro'] = "Este nome de utilizador já existe.";
        } else {
            $resposta['erro'] = "Erro ao salvar as alterações: " . $stmt->error;
        }
    }
    
    $stmt->close();
}

// 5. Fechar a conexão
$conn->close();

// 6. Retornar o JSON
echo json_encode($resposta);
?>