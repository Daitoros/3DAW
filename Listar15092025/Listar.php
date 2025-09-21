<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Listar alunos</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>
                        <h2>Matricula</h2>
                    </th>
                    <th>
                        <h2>Nome</h2>
                    </th>
                    <th>
                        <h2>Email</h2>
                    </th>
                </tr>
            </thead>
            <tbody>
                <h1 style="centered">Lista Aluno</h1>
                <?php
                    $arquivo = fopen("alunos.txt", "r") or die("Impossível criar arquivo!");
                    IF( $arquivo !== false ) {
                        $linha = fgets($arquivo);
                        while(($linha = fgets($arquivo))!==false){
                            // $linha = fgets( $arquivo );
                            $dados = explode(";", $linha);

                            echo "<tr>";
                            echo "<td>" . $dados[0] . "</td>";
                            echo "<td>" . $dados[1] . "</td>";
                            echo "<td>" . $dados[2] ."</td>";
                            // echo "<td><a href="alterar.php">Alterar</a></td>";
                            echo "</tr>";
                        }
                        fclose($arquivo);
                    }
                ?>
            </tbody>
        <table>
        <button><a href='Incluir.php'> Incluir novo aluno</a></button>
    </body>
</html>
