<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados da Disciplina</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }
        .container {
            background-color: #fff;
            padding: 2em;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            color: #333;
        }
        p {
            font-size: 1.1em;
            color: #555;
            line-height: 1.6;
        }
        strong {
            color: #007BFF;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    // Verifica se os dados foram enviados via método POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Obtém os valores dos campos do formulário
        $nome = $_POST['nome'];
        $sigla = $_POST['sigla'];
        $carga_horaria = $_POST['carga_horaria'];
        $msg = "";

        // Exibe os dados recebidos
        echo "<h2>Dados da Disciplina Cadastrada</h2>";
        echo "<p><strong>Nome:</strong> " . htmlspecialchars($nome) . "</p>";
        echo "<p><strong>Sigla:</strong> " . htmlspecialchars($sigla) . "</p>";
        echo "<p><strong>Carga Horária:</strong> " . htmlspecialchars($carga_horaria) . " horas</p>";
        if(!file_exists("disciplinas.txt")){
            $arqDisc = fopen("disciplinas.txt", "w") or die("Erro ao criar arquivo!");
            $linha = "nome;sigla;carga\n";
            fwrite($arqDisc,$linha);
            fclose($arqDisc);
        }
        $arqDisc = fopen("disciplinas.txt", "a") or die("Erro ao abrir o arquivo");
        $linha = $nome . ";" . $sigla . ";" . $carga_horaria . "\n";
        fwrite($arqDisc,$linha);
        fclose($arqDisc);
        $msg = "Deu tudo certo!";
    } else {
        // Redireciona o usuário de volta para o formulário se a requisição não for POST
        header("Location: seu_formulario.html");
        exit();
    }
    ?>
</div>

</body>
</html>