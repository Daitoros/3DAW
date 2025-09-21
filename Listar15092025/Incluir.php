<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')  
{
    $matricula = $_POST["matricula"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    echo "<p class='info'> Matricula: " . $matricula . " Nome: " . $nome . " Email: " . $email . "</p>";

    $padraoEmail = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    $padraoNome = '/^[a-zA-ZÀ-ú\s\'-]+$/';
    $padraoMatricula = '/^\d+$/';


    if(!preg_match($padraoEmail, $email)) 
    {
        $msg = "<p class='erro'> O endereço de email '$email' não é válido!</p>";
    } else 
    {
        if(!preg_match($padraoNome, $nome))
        {
            $msg = "<p class='erro'> O Nome introduzido, '$nome', não é válido!</p>";
        }else
        {
            if(!preg_match($padraoMatricula, $matricula)) 
            {
                $msg = "<p class='erro'>A Matrícula '$matricula' não é válida!</p>";
            }else
            {
                if (!file_exists("alunos.txt")) 
                {
                    $arqDisc = fopen("alunos.txt","w") or die("erro ao criar arquivo");
                    $linha = "matricula;nome;email\n";
                    fwrite($arqDisc,$linha);
                    fclose($arqDisc);
                }
                $arqDisc = fopen("alunos.txt","a") or die("erro ao abrir arquivo");
                $linha = "\n" . $matricula . ";" . $nome . ";" . $email . "\n";
                fwrite($arqDisc,$linha);
                fclose($arqDisc);
                $msg = "<p class='sucesso'>Deu tudo certo!!!</p>";
            }
        }
    }
}   
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Incluir aluno</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Criar Nova Disciplina</h1>
        <form action="Incluir.php" method="POST">
            Matrícula: <input type="text" name="matricula">
            <br><br>
            Nome: <input type="text" name="nome">
            <br><br>
            Email: <input type="text" name="email">
            <br><br>
            <input type="submit" value="Criar Novo Aluno">
            <button><a href='Listar.php'>Voltar</a></button>
        </form>
        <p><?php 
            if($_SERVER['REQUEST_METHOD']=='POST'){
                echo $msg;
            } 
        ?></p>
        <br>

    </body>
</html>