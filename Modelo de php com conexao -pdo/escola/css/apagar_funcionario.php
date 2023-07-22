<?php
session_start();
ob_start();
include_once './conexao.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SISED - Apagar Funcionario</title>
    </head>
    <body>
        <a href="index.php">Listar</a><br>
        <a href="cadastrar.php">Cadastrar</a><br>
        <a href="../index.html">Home</a><br>
        
        <h1>Excluir Funcionario</h1>
        <?php
        //Receber os dados do formulário
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $id_funcionario = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    var_dump($id);

if (empty($id_funcionario)) {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Funcionario não encontrado!</p>";
    header("Location: index.php");
    exit();
}

$query_funcionario = "SELECT id_funcionario FROM funcionario WHERE id_funcionario = $id_funcionario LIMIT 1";
$result_funcionario = $conn->prepare($query_funcionario);
$result_funcionario->execute();

if (($result_funcionario) AND ($result_funcionario->rowCount() != 0)) {
    $query_del_funcionario = "DELETE FROM funcionario WHERE id_funcionario = $id_funcionario";
    $apagar_funcionario = $conn->prepare($query_del_funcionario);

    if ($apagar_funcionario->execute()) {
        $_SESSION['msg'] = "<p style='color: green;'>Funcionario apagado com sucesso!</p>";
        header("Location: index_funcionario.php");
    } else {
        $_SESSION['msg'] = "<p style='color: #f00;'>Funcionario não apagado pode ser apagado!</p>";
        header("Location: index_aluno.php");
    }
} else {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Funcionario não encontrado!</p>";
    header("Location: index_aluno.php");
}
?>
 <form><h2>Excluir Funcionario</h2>
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