<?php
    // $msg = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
    $matricula = $_POST["matricula"];
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    echo "Matricula: " . $matricula . " Nome: " . $nome . " Email: " . $email;
   if (!file_exists("alunos.txt")) {
       $arqDisc = fopen("alunos.txt","w") or die("erro ao criar arquivo");
       $linha = "matricula;nome;email\n";
       fwrite($arqDisc,$linha);
       fclose($arqDisc);
   }
   $arqDisc = fopen("alunos.txt","a") or die("erro ao abrir arquivo");
    $linha = $matricula . ";" . $nome . ";" . $email . "\n";
    fwrite($arqDisc,$linha);
    fclose($arqDisc);
    $msg = "Deu tudo certo!!!";
}
?>
<!DOCTYPE html>
<html>
<head>
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
</form>
<p><?php echo $msg ?></p>
<br>
</body>
</html>