<?php
session_start();
ob_start();
include_once './conexao.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SISED - Apagar</title>
    </head>
    <body>
        <a href="index.php">Listar</a><br>
        <a href="cadastrar.php">Cadastrar</a><br>
        <a href="../index.html">Home</a><br>
        
        <h1>Excluir Curso</h1>
        <?php
        //Receber os dados do formulário
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

    $id_curso = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    var_dump($id);

if (empty($id_curso)) {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Curso não encontrado!</p>";
    header("Location: index.php");
    exit();
}

$query_curso = "SELECT id_curso FROM curso WHERE id_curso = $id_curso LIMIT 1";
$result_curso = $conn->prepare($query_curso);
$result_curso->execute();

if (($result_curso) AND ($result_curso->rowCount() != 0)) {
    $query_del_curso = "DELETE FROM curso WHERE id_curso = $id_curso";
    $apagar_curso = $conn->prepare($query_del_curso);

    if ($apagar_curso->execute()) {
        $_SESSION['msg'] = "<p style='color: green;'>Curso apagado com sucesso!</p>";
        header("Location: index.php");
    } else {
        $_SESSION['msg'] = "<p style='color: #f00;'>Curso não apagado com sucesso!</p>";
        header("Location: index.php");
    }
} else {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Curso não encontrado!</p>";
    header("Location: index.php");
}
?>
 <form><h2>Excluir Curso</h2>
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