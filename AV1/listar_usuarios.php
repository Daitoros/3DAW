<?php
session_start();
if (!isset($_SESSION['funcao']) || $_SESSION['funcao'] != 'gestor') {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Listar Usuários</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Gerenciamento de Usuários</h1>
        
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th><h2>Usuário</h2></th>
                    <th><h2>Senha</h2></th>
                    <th><h2>Função</h2></th>
                    <th><h2>Ações</h2></th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (!file_exists("usuarios.txt")) 
            {
                echo "<tr><td colspan='5'>Não há usuários cadastrados.</td></tr>";
            } else{

                $arquivo = fopen("usuarios.txt", "r") or die("Impossível abrir arquivo de usuários!");
                $linha = fgets($arquivo); 
                $i=0; 
                while(($linha = fgets($arquivo))!==false){
                    $dados = explode(";", trim($linha)); 

                    if (count($dados) < 3) continue; 

                    echo "<tr>";
                    echo "<td>" . ($i+1) . "</td>"; // Número de ordem
                    echo "<td>" . htmlspecialchars($dados[0]) . "</td>"; 
                    echo "<td>" . htmlspecialchars($dados[1]) . "</td>"; 
                    echo "<td>" . htmlspecialchars($dados[2]) . "</td>"; 
                    

                    echo "<td>
                        <a href='alterar_usuario.php?numUsuario=" . ($i+1) . "'>Alterar</a> | 
                        <a href='excluir_usuario.php?numUsuario=" . ($i+1) . "'>Excluir</a>
                    </td>";
                    echo "</tr>";    
                    $i++; 
                }
                fclose($arquivo);
                
                if ($i == 0) {
                     echo "<tr><td colspan='5'>Nenhum usuário encontrado (além do cabeçalho).</td></tr>";
                }
            } 
            ?>
            </tbody>
        <table>
        
        <br>
        <button><a href='incluir_usuario.php'> Incluir Novo Usuário</a></button>
        <a href='gestor.php'>Voltar para Gerenciamento de Perguntas</a>
    </body>
</html>