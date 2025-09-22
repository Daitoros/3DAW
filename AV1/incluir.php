<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{
    $pergunta = $_POST["pergunta"];
    $resp1 = $_POST["resp1"];
    $resp2 = $_POST["resp2"];
    $resp3 = $_POST["resp3"];
    $respCerta = $_POST["respCerta"];

    echo "<p class='info'> Pergunta: " . $pergunta . " Resposta 1: " . $resp1 . " Resposta 2: " . $resp2 .  " Resposta 3: " . $resp3 . " Resposta Correta:" . $respCerta . "</p>";
    if (!file_exists("perguntas.txt")) 
    {
        $arqDisc = fopen("perguntas.txt","w") or die("erro ao criar arquivo");
        $linha = "pergunta;resp1;resp2;resp3;respCerta\n";
        fwrite($arqDisc,$linha);
        fclose($arqDisc);
    }
    $arqDisc = fopen("perguntas.txt","a") or die("erro ao abrir arquivo");
    $linha = $pergunta . ";" . $resp1 . ";" . $resp2 . ";" . $resp3 . ";" . $respCerta . "\n";
    fwrite($arqDisc,$linha);
    fclose($arqDisc);
    $msg = "<p class='sucesso'>Deu tudo certo!!!</p>";    
}   
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Incluir Pergunta</title>
    </head>
    <body>
        <h1>Criar Nova Pergunta</h1>
        <form action="incluir.php" method="POST">
            Pergunta: <input type="text" name="pergunta">
            <br><br>
            Atenção, caso resposta de texto, não preencher
            <br><br>
            Resposta1: <input type="text" name="resp1">
            <br><br>
            Resposta2: <input type="text" name="resp2">
            <br><br>
            Resposta3: <input type="text" name="resp3">
            <br><br>
            Resposta Certa: <input type="text" name="respCerta">
            <input type="submit" value="Criar Nova Pergunta">
            <a href='gestor.php'>Voltar</a>
        </form>
        <p><?php 
            if($_SERVER['REQUEST_METHOD']=='POST'){
                echo $msg;
            } 
        ?></p>
    </body>
</html>