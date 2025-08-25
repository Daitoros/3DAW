<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <h1>Listar disciplinas</h1>
        <table>
            <tr><th>Nome</th><th>Sigla</th><th>Carga</th></tr>
            <?php
                $arqDisc = fopen("disciplinas.txt", "r") or die("Erro ao abrir arquivo.");
                while(!feof($arqDisc)){
                    $linha = fgets($arqDisc);
                    $colunaDados = explode(";", $linha);

                    echo "<tr><td>" . $colunaDados[0] . "</td>" .
                        "<td>" . $colunaDados[1] . "</td>" .
                        "<td>" . $colunaDados[2] . "</td></tr>";
                }
                fclose($arqDisc);
            ?>
        </table>
    </body>
</html>
    