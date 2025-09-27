<?php
$msg = "";
$numPergunta = $_REQUEST['numPergunta'] ?? null; 
$dados_pergunta = [];
$linhas = []; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $numPergunta !== null) {
    $pergunta = $_POST["pergunta"];
    $resp1 = $_POST["resp1"];
    $resp2 = $_POST["resp2"];
    $resp3 = $_POST["resp3"];
    $respCerta = $_POST["respCerta"];

    $novaLinha = $pergunta . ";" . $resp1 . ";" . $resp2 . ";" . $resp3 . ";" . $respCerta . "\n";
    
    $arquivo = fopen("perguntas.txt", "r") or die("Erro ao abrir arquivo para escrita!");
    while (($linha = fgets($arquivo)) !== false) {
        $linhas[] = $linha;
    }
    fclose($arquivo);


    if (isset($linhas[$numPergunta])) {
        $linhas[$numPergunta] = $novaLinha;

        $arqDisc = fopen("perguntas.txt", "w") or die("Erro ao reescrever arquivo!");
        foreach ($linhas as $linha_salvar) {
            fwrite($arqDisc, $linha_salvar);
        }
        fclose($arqDisc);
        
        $msg = "<p class='sucesso'>Pergunta alterada com sucesso! (Pergunta #{$numPergunta})</p>";
    } else {
        $msg = "<p class='erro'>Erro: Pergunta não encontrada.</p>";
    }
}


if ($numPergunta !== null && empty($dados_pergunta)) {
    if (file_exists("perguntas.txt")) {
        $arquivo = fopen("perguntas.txt", "r") or die("Impossível abrir arquivo!");
        
        $i = 0;
        while (($linha = fgets($arquivo)) !== false) {
            if ($i == $numPergunta) { 
                $dados = explode(";", $linha);
                $dados_pergunta = [
                    'pergunta' => $dados[0],
                    'resp1' => $dados[1],
                    'resp2' => $dados[2],
                    'resp3' => $dados[3],
                    'respCerta' => trim($dados[4])
                ];
                break;
            }
            $i++;
        }
        fclose($arquivo);

        if (empty($dados_pergunta) && $numPergunta > 0) {
            $msg = "<p class='erro'>Erro: Pergunta com número {$numPergunta} não existe.</p>";
        }
    } else {
        $msg = "<p class='erro'>Erro: Arquivo de perguntas não encontrado.</p>";
    }
} else if ($numPergunta === null && $_SERVER['REQUEST_METHOD'] == 'GET') {

    header('Location: alterar_selecionar.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Alterar Pergunta</title>
    </head>
    <body>
        <h1>Alterar Pergunta #<?php echo htmlspecialchars($numPergunta); ?></h1>
        
        <?php if (!empty($dados_pergunta)): ?>
            <form action="alterar.php" method="POST">
                <input type="hidden" name="numPergunta" value="<?php echo htmlspecialchars($numPergunta); ?>">

                Pergunta: <input type="text" name="pergunta" value="<?php echo htmlspecialchars($dados_pergunta['pergunta']); ?>">
                <br><br>
                Resposta1: <input type="text" name="resp1" value="<?php echo htmlspecialchars($dados_pergunta['resp1']); ?>">
                <br><br>
                Resposta2: <input type="text" name="resp2" value="<?php echo htmlspecialchars($dados_pergunta['resp2']); ?>">
                <br><br>
                Resposta3: <input type="text" name="resp3" value="<?php echo htmlspecialchars($dados_pergunta['resp3']); ?>">
                <br><br>
                Resposta Certa: <input type="text" name="respCerta" value="<?php echo htmlspecialchars($dados_pergunta['respCerta']); ?>">
                <br><br>
                <input type="submit" value="Salvar Alterações">
            </form>
        <?php endif; ?>

        <p><?php echo $msg; ?></p>
        <a href='gestor.php'>Voltar para Gerenciamento</a>
    </body>
</html>