<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["numPergunta"])){
    $numPergunta = $_POST["numPergunta"];
    $arquivo = fopen("perguntas.txt", "r") or die("Impossível criar arquivo!");
    $linha = fgets($arquivo); 
    $i=0;
    $pergunta_encontrada = false;
    
    while(($linha = fgets($arquivo))!==false){
        $i++;
        if($i == $numPergunta){
            $dados = explode(";", $linha);
            $pergunta = trim($dados[0]);
            $resp1 = trim($dados[1]);
            $resp2 = trim($dados[2]);
            $resp3 = trim($dados[3]);
            $respCerta = trim($dados[4]);
            $pergunta_encontrada = true;
            break;
        }
    }
    fclose($arquivo);
    
} else if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["suaResp"])){
    $suaResp = $_POST["suaResp"];
    $respCerta = $_POST["respCerta"];
    $numPergunta = $_POST["numPergunta_hidden"]; 
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Responder Pergunta</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Responder Pergunta</h1>
        
        <form action="responder.php" method="POST">
            
            <?php if($pergunta_encontrada): ?>
            
                <h2>Pergunta #<?php echo htmlspecialchars($numPergunta); ?>: <?php echo htmlspecialchars($pergunta); ?></h2>
                <br>
                
                <?php 
                if (!empty($resp1) || !empty($resp2) || !empty($resp3)): 
                ?>
                    <input type="radio" name="suaResp" value="<?php echo htmlspecialchars($resp1); ?>" required> 
                    <label>Resposta 1: <?php echo htmlspecialchars($resp1); ?></label><br><br>

                    <input type="radio" name="suaResp" value="<?php echo htmlspecialchars($resp2); ?>" required>
                    <label>Resposta 2: <?php echo htmlspecialchars($resp2); ?></label><br><br>

                    <input type="radio" name="suaResp" value="<?php echo htmlspecialchars($resp3); ?>" required>
                    <label>Resposta 3: <?php echo htmlspecialchars($resp3); ?></label><br><br>
                
                <?php else: ?>
                    Sua Resposta: <input type="text" name="suaResp" required>
                    <br><br>
                <?php endif; ?>

                <input type="hidden" name="respCerta" value="<?php echo htmlspecialchars($respCerta); ?>">
                <input type="hidden" name="numPergunta_hidden" value="<?php echo htmlspecialchars($numPergunta); ?>">

                <input type="submit" value="Enviar Resposta">

            <?php else: ?>
                <p class='erro'>Pergunta não encontrada ou erro na requisição.</p>
            <?php endif; ?>
            
            <a href='funcionario.php'>Voltar</a>
        </form>
        
        <p>
        <?php 
            if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST["suaResp"])){
                if(trim($suaResp) == trim($respCerta)){
                    echo "<p class='sucesso'>Resposta Correta!!!</p>";
                } else {
                    echo "<p class='erro'>Resposta Incorreta!!! A resposta certa é: " . htmlspecialchars($respCerta) . "</p>";
                }
            } 
        ?>
        </p>
    </body>
</html>