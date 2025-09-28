<?php
session_start();

if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] != 'gestor') {
    header("Location: index.php");
    exit;
}

$msg = "";
$numUsuario = $_REQUEST['numUsuario'] ?? null; 


if ($_SERVER['REQUEST_METHOD'] == 'POST' && $numUsuario !== null) {
    $linhas = [];
    $usuario_excluido = "";

    if (file_exists("usuarios.txt")) {
        $arquivo = fopen("usuarios.txt", "r") or die("Erro ao abrir arquivo para exclusão!");
        while (($linha = fgets($arquivo)) !== false) {
            $linhas[] = $linha;
        }
        fclose($arquivo);
    } 


    if (isset($linhas[$numUsuario])) {
        $dados = explode(";", $linhas[$numUsuario]);
        $usuario_excluido = trim($dados[0]);
        unset($linhas[$numUsuario]);
        

        $arqDisc = fopen("usuarios.txt", "w") or die("Erro ao reescrever arquivo!");
        foreach ($linhas as $linha_salvar) {
            fwrite($arqDisc, $linha_salvar);
        }
        fclose($arqDisc);
        
        $msg = "<p class='sucesso'>Usuário '{$usuario_excluido}' excluído com sucesso!</p>";
        $numUsuario = null; // Limpa para não exibir o formulário de confirmação
    } else {
        $msg = "<p class='erro'>Erro: Usuário não encontrado para exclusão.</p>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Excluir Usuário</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Excluir Usuário</h1>
        <p><?php echo $msg; ?></p>

        <?php 
        $usuario_exibir = "";

        if ($numUsuario !== null): 
            if (file_exists("usuarios.txt")) {
                $i = 0;
                $arquivo = fopen("usuarios.txt", "r") or die("Erro ao abrir arquivo!");
                while (($linha = fgets($arquivo)) !== false) {
                    if ($i == $numUsuario) {
                        $dados = explode(";", trim($linha));
                        $usuario_exibir = $dados[0];
                        break;
                    }
                    $i++;
                }
                fclose($arquivo);
            }
        ?>

            <?php if (!empty($usuario_exibir)): ?>
                <p>Tem certeza que deseja excluir o usuário #<?php echo htmlspecialchars($numUsuario); ?>:</p>
                <p><strong><?php echo htmlspecialchars($usuario_exibir); ?></strong></p>

                <form action="excluir_usuario.php" method="POST">
                    <input type="hidden" name="numUsuario" value="<?php echo htmlspecialchars($numUsuario); ?>">
                    <input type="submit" value="SIM, Excluir Usuário">
                </form>
            <?php else: ?>
                <?php if (empty($msg)) echo "<p class='erro'>Usuário não encontrado.</p>"; ?>
            <?php endif; ?>

        <?php endif; ?>

        <br>
        <a href='listar_usuarios.php'>Voltar para Lista de Usuários</a>
    </body>
</html>
