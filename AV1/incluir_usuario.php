<?php
session_start();
// Proteção: Apenas gestores podem incluir usuários

$msg = "";

// Verifica se é o primeiro usuário (se o arquivo não existe)
$primeiro_cadastro = !file_exists("usuarios.txt");

// Se NÃO for o primeiro cadastro E (não está logado OU não é gestor), bloqueia.
if (!$primeiro_cadastro && (!isset($_SESSION['funcao']) || $_SESSION['funcao'] != 'gestor')) {
    header("Location: index.php");
    exit;
}

// ... (o restante do arquivo incluir_usuario.php continua igual)

if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $funcao = $_POST["funcao"]; // 'gestor' ou 'funcionario'

    if (!file_exists("usuarios.txt")) 
    {
        $arqDisc = fopen("usuarios.txt","w") or die("erro ao criar arquivo");
        $linha = "usuario;senha;funcao\n";
        fwrite($arqDisc,$linha);
        fclose($arqDisc);
    }

    $arqDisc = fopen("usuarios.txt","a") or die("erro ao abrir arquivo");
    $linha = $usuario . ";" . $senha . ";" . $funcao . "\n";
    fwrite($arqDisc,$linha);
    fclose($arqDisc);
    $msg = "<p class='sucesso'>Usuário '{$usuario}' criado com sucesso!</p>";    
}   
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Incluir Usuário</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Criar Novo Usuário</h1>
        <form action="incluir_usuario.php" method="POST">
            Usuário: <input type="text" name="usuario" required>
            <br><br>
            Senha: <input type="password" name="senha" required>
            <br><br>
            Função: 
            <select name="funcao" required>
                <option value="funcionario">Funcionário</option>
                <option value="gestor">Gestor</option>
            </select>
            <br><br>
            <input type="submit" value="Criar Novo Usuário">
        </form>
        <p><?php 
            if($_SERVER['REQUEST_METHOD']=='POST'){
                echo $msg;
            } 
        ?></p>
        <br>
        <a href='gestor.php'>Voltar</a>
    </body>
</html>