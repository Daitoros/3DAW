<!DOCTYPE html>
<html>
    <head>
        <h1 style="centered">Lista Aluno</h1>
    </head>
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
</html>


<?php
    $arquivo = fopen("alunos.txt") or die("Impossível criar arquivo!");
    IF( $arquivo !== false ) {
        $linha = fgets( $arquivo );
        while(!feof($arquivo)){
            $linha = fgets( $arquivo );
            $dados = explode(";", $linha);

            echo "<tr>";
            echo "<td>$dados[0]</td>";
            echo "<td>$dados[1]</td>";
            echo "<td>$dados[2]</td>";
            // echo "<td><a href="alterar.php">Alterar</a></td>";
            echo "</tr>";
        }
    }
    echo "<button><a href= "Incluir.php"> Incluir nova disciplina</a></button>";    
?>

