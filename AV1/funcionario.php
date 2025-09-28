<?php
session_start();

if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] != 'funcionario') {
    header("Location: index.php"); // Redireciona para o login
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gerenciar perguntas</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
     <table>
            <thead>
                <tr>
                    <th>
                    </th>
                    <th>
                        <h2>Pergunta</h2>
                    </th>
                    <th>
                        <h2>Resposta 1</h2>
                    </th>
                    <th>
                        <h2>Resposta 2</h2>
                    </th>
                    <th>
                        <h2>Resposta 3</h2>
                    </th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (!file_exists("perguntas.txt")) 
            {
                echo "<tr>";
                echo "<td></td>";
                echo "<td>Não há</td>";
                echo "<td>Não há</td>";
                echo "<td>Não há</td>";
                echo "<td>Não há</td>";         
                echo "</tr>";
            } else{

                $arquivo = fopen("perguntas.txt", "r") or die("Impossível criar arquivo!");
                $linha = fgets($arquivo);
                while(($linha = fgets($arquivo))!==false){
                    $i=0;
                    // $linha = fgets( $arquivo );
                    $dados = explode(";", $linha);

                    echo "<tr>";
                    echo "<td>" . $i+1 . "</td>";

                    echo "<td>" . $dados[0] . "</td>";
                    echo "<td>" . $dados[1] . "</td>";
                    echo "<td>" . $dados[2] ."</td>";
                    echo "<td>" . $dados[3] ."</td>";
                    echo "</tr>";    
                    $i++;
                }
                fclose($arquivo);
            } 
            ?>

            </tbody>
        <table>
            Digite o número da pergunta que deseja responder:
            <form action="responder.php" method="POST">
                Número da pergunta: <input type="number" name="numPergunta" min="1" max="10">
                <input type="submit" value="Responder Pergunta">
            </form>
            <br>    
    </body>
</html>