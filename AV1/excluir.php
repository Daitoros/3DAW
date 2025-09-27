<?php
$msg = "";
$numPergunta = $_REQUEST['numPergunta'] ?? null; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $numPergunta !== null) {
    $linhas = [];

    if (file_exists("perguntas.txt")) {
        $arquivo = fopen("perguntas.txt", "r") or die("Erro ao abrir arquivo para exclusão!");
        while (($linha = fgets($arquivo)) !== false) {
            $linhas[] = $linha;
        }
        fclose($arquivo);
    } else {
        $msg = "<p class='erro'>Erro: Arquivo de perguntas não encontrado.</p>";
    }


    if (isset($linhas[$numPergunta])) {
        $pergunta_excluida = explode(";", $linhas[$numPergunta])[0];
        unset($linhas[$numPergunta]); 
        
        $arqDisc = fopen("perguntas.txt", "w") or die("Erro ao reescrever arquivo!");
        foreach ($linhas as $linha_salvar) {
            fwrite($arqDisc, $linha_salvar);
        }
        fclose($arqDisc);
        
        $msg = "<p class='sucesso'>Pergunta '{$pergunta_excluida}' (Pergunta #{$numPergunta}) excluída com sucesso!</p>";
        $numPergunta = null; 
    } else {
        $msg = "<p class='erro'>Erro: Pergunta não encontrada para exclusão.</p>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Excluir Pergunta</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Excluir Pergunta</h1>
        <p><?php echo $msg; ?></p>

        <?php if ($numPergunta === null): ?>
            <form action="excluir.php" method="GET">
                Número da pergunta para excluir: 
                <input type="number" name="numPergunta" min="1">
                <input type="submit" value="Selecionar para Excluir">
            </form>
        <?php else: 

            $pergunta_exibir = "";
            $i = 0;
            $arquivo = fopen("perguntas.txt", "r") or die("Erro ao abrir arquivo!");
            while (($linha = fgets($arquivo)) !== false) {
                if ($i == $numPergunta) {
                    $dados = explode(";", $linha);
                    $pergunta_exibir = $dados[0];
                    break;
                }
                $i++;
            }
            fclose($arquivo);
        ?>

            <?php if (!empty($pergunta_exibir)): ?>
                <p>Tem certeza que deseja excluir a pergunta #<?php echo htmlspecialchars($numPergunta); ?>:</p>
                <p><strong><?php echo htmlspecialchars($pergunta_exibir); ?></strong></p>

                <form action="excluir.php" method="POST">
                    <input type="hidden" name="numPergunta" value="<?php echo htmlspecialchars($numPergunta); ?>">
                    <input type="submit" value="SIM, Excluir Pergunta">
                </form>
            <?php else: ?>
                <p class='erro'>Pergunta não encontrada.</p>
            <?php endif; ?>

        <?php endif; ?>

        <br>
        <a href='gestor.php'>Voltar para Gerenciamento</a>
    </body>
</html>