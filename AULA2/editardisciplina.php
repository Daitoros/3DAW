<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Disciplina</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
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
            text-align: center;
            color: #333;
            margin-bottom: 1.5em;
        }
        .form-group {
            margin-bottom: 1em;
        }
        label {
            display: block;
            margin-bottom: 0.5em;
            color: #555;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 0.8em;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 1em;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    // PARTE 1: PROCESSAMENTO DOS DADOS (se o formulário foi enviado)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $siglaOriginal = $_POST['sigla_original'];
        $novoNome = $_POST['nome'];
        $novaSigla = $_POST['sigla'];
        $novaCargaHoraria = $_POST['carga_horaria'];

        $linhas = file("disciplinas.txt");
        $arquivoAtualizado = fopen("disciplinas.txt", "w") or die("Erro ao reescrever o arquivo.");

        $cabecalho = array_shift($linhas); // Remove o cabeçalho
        fwrite($arquivoAtualizado, $cabecalho);

        foreach ($linhas as $linha) {
            $dados = explode(";", $linha);
            if (trim($dados[1]) == trim($siglaOriginal)) {
                // Substitui a linha antiga pela nova
                $novaLinha = $novoNome . ";" . $novaSigla . ";" . $novaCargaHoraria . "\n";
                fwrite($arquivoAtualizado, $novaLinha);
            } else {
                // Mantém as outras linhas
                fwrite($arquivoAtualizado, $linha);
            }
        }
        fclose($arquivoAtualizado);
        
        // Redireciona para a página de listagem
        header("Location: listardisciplinas.php");
        exit();

    // PARTE 2: EXIBIÇÃO DO FORMULÁRIO (se o usuário chegou pela URL)
    } elseif (isset($_GET['sigla'])) {
        $siglaParaEditar = $_GET['sigla'];
        $disciplinaEncontrada = false;
        
        $arqDisc = fopen("disciplinas.txt", "r") or die("Erro ao abrir arquivo.");
        fgets($arqDisc); // Pula o cabeçalho
        
        while(!feof($arqDisc)){
            $linha = fgets($arqDisc);
            if(trim($linha) != ""){
                $colunaDados = explode(";", $linha);
                if(trim($colunaDados[1]) == trim($siglaParaEditar)){
                    $nomeDaDisciplina = $colunaDados[0];
                    $siglaDaDisciplina = $colunaDados[1];
                    $cargaHorariaDaDisciplina = $colunaDados[2];
                    $disciplinaEncontrada = true;
                    break;
                }
            }
        }
        fclose($arqDisc);

        if ($disciplinaEncontrada) {
            // Exibe o formulário pré-preenchido
    ?>
    <h2>Editar Disciplina</h2>
    <form action="editardisciplina.php" method="post">
        <input type="hidden" name="sigla_original" value="<?php echo htmlspecialchars(trim($siglaDaDisciplina)); ?>">
        
        <div class="form-group">
            <label for="nome">Nome da Disciplina:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nomeDaDisciplina); ?>" required>
        </div>
        <div class="form-group">
            <label for="sigla">Sigla:</label>
            <input type="text" id="sigla" name="sigla" value="<?php echo htmlspecialchars(trim($siglaDaDisciplina)); ?>" required maxlength="10">
        </div>
        <div class="form-group">
            <label for="carga_horaria">Carga Horária (horas):</label>
            <input type="number" id="carga_horaria" name="carga_horaria" value="<?php echo htmlspecialchars(trim($cargaHorariaDaDisciplina)); ?>" required min="1">
        </div>
        <button type="submit">Atualizar</button>
    </form>
    <?php
        } else {
            echo "<p>Disciplina não encontrada.</p>";
            echo "<a href='listardisciplinas.php'>Voltar para a lista</a>";
        }
    } else {
        // Redireciona se a página for acessada sem os parâmetros corretos
        header("Location: listardisciplinas.php");
        exit();
    }
    ?>
</div>

</body>
</html>