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
                
                fgets($arqDisc);
                
                while(!feof($arqDisc)){
                    $linha = fgets($arqDisc);
                    
                    if (trim($linha) != "") {
                        $colunaDados = explode(";", $linha);

                        echo "<tr><td>" . $colunaDados[0] . "</td>" .
                             "<td>" . $colunaDados[1] . "</td>" .
                             "<td>" . $colunaDados[2] . "</td>" .
                             "<td><a href='editardisciplina.php?sigla=" . $colunaDados[1] . "'>Editar</a></td>" .
                             "<td><a href='excluirdisciplina.php?sigla=" . $colunaDados[1] . "'>Excluir</a></td>" .
                             "</tr>";
                    }
                }
                
                fclose($arqDisc);
            ?>
        </table>
    </body>
</html>