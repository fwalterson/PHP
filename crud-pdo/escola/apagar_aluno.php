<?php
session_start();
ob_start();
include_once './conexao.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SISED - Apagar Aluno</title>
    </head>
    <body>
        <a href="index.php">Listar</a><br>
        <a href="cadastrar.php">Cadastrar</a><br>
        <a href="../index.html">Home</a><br>
        
        <h1>Excluir Aluno</h1>
        <?php
        //Receber os dados do formulário
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $id_aluno = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    var_dump($id);

if (empty($id_aluno)) {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: funcionario não encontrado!</p>";
    header("Location: index_aluno.php");
    exit();
}

$query_aluno = "SELECT id_aluno FROM aluno WHERE id_aluno = $id_aluno LIMIT 1";
$result_aluno = $conn->prepare($query_aluno);
$result_aluno->execute();

if (($result_aluno) AND ($result_aluno->rowCount() != 0)) {
    $query_del_aluno = "DELETE FROM aluno WHERE id_aluno = $id_aluno";
    $apagar_aluno = $conn->prepare($query_del_aluno);

    if ($apagar_aluno->execute()) {
        $_SESSION['msg'] = "<p style='color: green;'>Aluno apagado com sucesso!</p>";
        header("Location: index_aluno.php");
    } else {
        $_SESSION['msg'] = "<p style='color: #f00;'>Aluno não apagado pode ser apagado!</p>";
        header("Location: index_aluno.php");
    }
} else {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Aluno não encontrado!</p>";
    header("Location: index_aluno.php");
}
?>
 <form><h2>Excluir Aluno</h2>
                <div class="form-group-1">
                    <input type="text" name="id" id="id" placeholder="ID" required />
                
                <div class="form-submit">
                    <input type="submit" class="submit" value="Excluir" />
                    <a class="submit" href="../index.html">Voltar</a>
                </div>
            </form>
        </div>

    </div>
</body>
</html>