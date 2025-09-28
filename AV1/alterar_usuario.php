<?php
session_start();

if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] != 'gestor') {
    header("Location: index.php");
    exit;
}

$msg = "";
$numUsuario = $_REQUEST['numUsuario'] ?? null; 
$dados_usuario = [];


if ($_SERVER['REQUEST_METHOD'] == 'POST' && $numUsuario !== null) {
    $novo_usuario = $_POST["usuario"];
    $nova_senha = $_POST["senha"];
    $nova_funcao = $_POST["funcao"];

    $novaLinha = $novo_usuario . ";" . $nova_senha . ";" . $nova_funcao . "\n";
    $linhas = [];

    $arquivo = fopen("usuarios.txt", "r") or die("Erro ao abrir arquivo para leitura!");
    while (($linha = fgets($arquivo)) !== false) {
        $linhas[] = $linha;
    }
    fclose($arquivo);

    if (isset($linhas[$numUsuario])) {
        $linhas[$numUsuario] = $novaLinha;

        $arqDisc = fopen("usuarios.txt", "w") or die("Erro ao reescrever arquivo!");
        foreach ($linhas as $linha_salvar) {
            fwrite($arqDisc, $linha_salvar);
        }
        fclose($arqDisc);
        
        $msg = "<p class='sucesso'>Usuário '{$novo_usuario}' alterado com sucesso! (Usuário #{$numUsuario})</p>";
    } else {
        $msg = "<p class='erro'>Erro: Usuário não encontrado.</p>";
    }
}

if ($numUsuario !== null) {
    if (file_exists("usuarios.txt")) {
        $arquivo = fopen("usuarios.txt", "r") or die("Impossível abrir arquivo!");
        
        $i = 0;
        while (($linha = fgets($arquivo)) !== false) {
            if ($i == $numUsuario) {
                $dados = explode(";", trim($linha));
                $dados_usuario = [
                    'usuario' => $dados[0],
                    'senha' => $dados[1],
                    'funcao' => $dados[2]
                ];
                break; 
            }
            $i++;
        }
        fclose($arquivo);

        if (empty($dados_usuario) && $numUsuario > 0) {
            $msg = "<p class='erro'>Erro: Usuário com número {$numUsuario} não existe.</p>";
        }
    } else {
        $msg = "<p class='erro'>Erro: Arquivo de usuários não encontrado.</p>";
    }
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        header('Location: listar_usuarios.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Alterar Usuário</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Alterar Usuário #<?php echo htmlspecialchars($numUsuario); ?></h1>
        
        <?php if (!empty($dados_usuario)): ?>
            <form action="alterar_usuario.php" method="POST">
                <input type="hidden" name="numUsuario" value="<?php echo htmlspecialchars($numUsuario); ?>">

                Usuário: <input type="text" name="usuario" value="<?php echo htmlspecialchars($dados_usuario['usuario']); ?>">
                <br><br>
                Senha: <input type="password" name="senha" value="<?php echo htmlspecialchars($dados_usuario['senha']); ?>">
                <br><br>
                Função: 
                <select name="funcao" required>
                    <option value="funcionario" <?php if ($dados_usuario['funcao'] == 'funcionario') echo 'selected'; ?>>Funcionário</option>
                    <option value="gestor" <?php if ($dados_usuario['funcao'] == 'gestor') echo 'selected'; ?>>Gestor</option>
                </select>
                <br><br>
                <input type="submit" value="Salvar Alterações">
            </form>
        <?php endif; ?>

        <p><?php echo $msg; ?></p>
        <a href='listar_usuarios.php'>Voltar para Lista de Usuários</a>
    </body>
</html>