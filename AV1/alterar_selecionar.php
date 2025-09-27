<?php
$perguntas = [];
if (file_exists("perguntas.txt")) {
    $arquivo = fopen("perguntas.txt", "r") or die("Impossível abrir arquivo!");
    fgets($arquivo); 
    $i = 0;
    while (($linha = fgets($arquivo)) !== false) {
        $i++;
        $dados = explode(";", $linha); 
        $perguntas[] = [
            'numero' => $i,
            'pergunta' => $dados[0]
        ];
    }
    fclose($arquivo);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Selecionar Pergunta para Alterar</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Alterar Pergunta</h1>
        <h2>Selecione o número da pergunta que deseja alterar:</h2>
        
        <?php if (!empty($perguntas)): ?>
            <form action="alterar.php" method="GET">
                <label for="numPergunta">Pergunta:</label>
                <select name="numPergunta" id="numPergunta" required>
                    <?php foreach ($perguntas as $pergunta): ?>
                        <option value="<?php echo $pergunta['numero']; ?>">
                            <?php echo $pergunta['numero'] . " - " . $pergunta['pergunta']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" value="Alterar Selecionada">
            </form>
        <?php else: ?>
            <p>Não há perguntas para alterar.</p>
        <?php endif; ?>
        
        <br>
        <a href='gestor.php'>Voltar para Gerenciamento</a>
    </body>
</html>