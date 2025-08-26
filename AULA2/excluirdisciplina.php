<?php
if (isset($_GET['sigla'])) {
    $siglaParaExcluir = $_GET['sigla'];
    
    $linhas = file("disciplinas.txt");
    $arquivoAtualizado = fopen("disciplinas.txt", "w") or die("Erro ao reescrever o arquivo.");

    foreach ($linhas as $linha) {
        $dados = explode(";", $linha);
        // Se a sigla for diferente da sigla a ser excluída, mantém a linha
        if (trim($dados[1]) != trim($siglaParaExcluir)) {
            fwrite($arquivoAtualizado, $linha);
        }
    }
    fclose($arquivoAtualizado);

    // Redireciona de volta para a lista
    header("Location: listardisciplinas.php");
    exit();
} else {
    // Redireciona se a sigla não for fornecida
    header("Location: listardisciplinas.php");
    exit();
}
?>