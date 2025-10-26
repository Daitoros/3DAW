<?php
session_start();

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $logado = false;
    $funcao = "";

    if (!file_exists("usuarios.txt")){
        // ERRO 1: O arquivo não existe
        $msg = "<p class='erro'>Erro: Arquivo de usuários não existe. Cadastre um usuário primeiro!</p>";
    } else {
        // O arquivo existe, tenta fazer o login
        $arquivo = fopen("usuarios.txt", "r") or die("Erro ao abrir arquivo de usuários!");
        fgets($arquivo); // Descarta o cabeçalho
        
        while(($linha = fgets($arquivo)) !== false){
            $dados = explode(";", trim($linha)); 
            $user_arq = $dados[0];
            $senha_arq = $dados[1];
            $funcao_arq = $dados[2];

            if ($usuario == $user_arq && $senha == $senha_arq){
                $logado = true;
                $funcao = $funcao_arq;
                break;
            }
        }
        fclose($arquivo);
        
        // *** ESTA É A CORREÇÃO LÓGICA ***
        if ($logado){
            // Login OK
            $_SESSION['funcao'] = $funcao; 
            
            if ($funcao == 'gestor'){
                header("Location: gestor.php");
                exit;
            } else if ($funcao == 'funcionario'){
                header("Location: funcionario.php");
                exit;
            }
        } else {
            // ERRO 2: O arquivo existe, mas o login falhou
            $msg = "<p class='erro'>Usuário ou senha inválidos.</p>";
        }
    }
    // O bloco "else if" que estava aqui foi removido, pois ele causava o bug da mensagem.
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Jogo Corporativo</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Home Jogo Corporativo - Login</h1>
        
        <form action="index.php" method="POST">
            Usuário: <input type="text" name="usuario" required>
            <br><br>
            Senha: <input type="password" name="senha" required>
            <br><br>
            <input type="submit" value="Entrar">
        </form>

        <p><?php echo $msg; ?></p>
        
        <?php
        // *** ESTA É A CORREÇÃO DO LINK ***
        // Se o arquivo não existir, mostra o link para criar o primeiro usuário
        if (!file_exists("usuarios.txt")) {
            echo "<p>Sistema não instalado. <a href='incluir_usuario.php'>Criar primeiro usuário (Gestor)</a></p>";
        }
        ?>
    </body>
</html>