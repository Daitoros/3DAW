<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $numPergunta = $_POST["numPergunta"];
    $arquivo = fopen("perguntas.txt", "r") or die("Impossível criar arquivo!");
    $linha = fgets($arquivo);
    $i=0;
    while(($linha = fgets($arquivo))!==false){
        $i++;
        if($i == $numPergunta){
            $dados = explode(";", $linha);
            $pergunta = $dados[0];
            $resp1 = $dados[1];
            $resp2 = $dados[2];
            $resp3 = $dados[3];
            $respCerta = $dados[4];
        }
    }
    fclose($arquivo);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Responder Pergunta</title>
    </head>
    <body>
        <h1>Responder Pergunta</h1>
        <form action="responder.php" method="POST">
            Pergunta: <?php if($_SERVER['REQUEST_METHOD'] == 'POST') { echo $pergunta; } ?>
            <br><br>
            Resposta1: <?php if($_SERVER['REQUEST_METHOD'] == 'POST') { echo $resp1; } ?>
            <br><br>
            Resposta2: <?php if($_SERVER['REQUEST_METHOD'] == 'POST') { echo $resp2; } ?>
            <br><br>
            Resposta3: <?php if($_SERVER['REQUEST_METHOD'] == 'POST') { echo $resp3; } ?>
            <br><br>
            Sua Resposta: <input type="text" name="suaResp">
            <input type="hidden" name="respCerta" value="<?php if($_SERVER['REQUEST_METHOD'] == 'POST') { echo $respCerta; } ?>">
            <input type="submit" value="Enviar Resposta">
            <a href='funcionario.php'>Voltar</a>
        </form>
        <p><?php 
            if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST["suaResp"])){
                $suaResp = $_POST["suaResp"];
                $respCerta = $_POST["respCerta"];
                if($suaResp == $respCerta){
                    echo "<p class='sucesso'>Resposta Correta!!!</p>";
                } else {
                    echo "<p class='erro'>Resposta Incorreta!!! A resposta certa é: " . $respCerta . "</p>";
                }
            } 
        ?></p>
    </body>
</html> 