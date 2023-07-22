<?php
session_start();
ob_start();
include_once './conexao.php';

$id_curso = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id_curso)) {
    $_SESSION['msg'] = "";
    header("Location: index.php");
    exit();
}

$query_curso = "SELECT id_curso, nome_curso, instrutor, turno FROM curso WHERE id_curso = $id_curso LIMIT 1";
$result_curso = $conn->prepare($query_curso);
$result_curso->execute();

if (($result_curso) AND ($result_curso->rowCount() != 0)) {
    $row_curso = $result_curso->fetch(PDO::FETCH_ASSOC);
    //var_dump($row_usuario);
} else {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Curso não encontrado!</p>";
    header("Location: editar_curso.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SISED- Editar</title>
    </head>
    <body>
        <a href="index.php">Listar</a><br>
        <a href="cadastrar.php">Cadastrar</a><br>
        <a href="../index.html">Home</a><br>

        <h1>Editar Curso</h1>

        <?php
        //Receber os dados do formulário
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        //Verificar se o usuário clicou no botão
        if (!empty($dados['EditUsuario'])) {
            $empty_input = false;
            $dados = array_map('trim', $dados);
            if (in_array("", $dados)) {
                $empty_input = true;
                echo "<p style='color: #f00;'>Erro: Necessário preencher todos campos!</p>";
            //} elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            //    $empty_input = true;
            //    echo "<p style='color: #f00;'>Erro: Necessário preencher com e-mail válido!</p>";
            }

            if (!$empty_input) {
                $query_up_curso= "UPDATE curso SET nome_curso=:nome_curso, instrutor=:instrutor, turno=:turno WHERE id_curso=:id_curso";
                $edit_curso = $conn->prepare($query_up_curso);
                $edit_curso->bindParam(':nome_curso', $dados['nome_curso'], PDO::PARAM_STR);
                $edit_curso->bindParam(':instrutor', $dados['instrutor'], PDO::PARAM_STR);
                $edit_curso->bindParam(':turno', $dados['turno'], PDO::PARAM_STR);
                $edit_curso->bindParam(':id_curso', $id_curso, PDO::PARAM_INT);
                if($edit_curso->execute()){
                    $_SESSION['msg'] = "<p style='color: green;'>Curso editado com sucesso!</p>";
                    header("Location: index.php");
                }else{
                    echo "<p style='color: #f00;'>Erro: Curso não editado!</p>";
                }
            }
        }
        ?>

        <form id="edit-usuario" method="POST" action="">
            <label>Curso: </label>
            <input type="text" name="nome_curso" id="nome_curso" placeholder="Nome do curso" value="<?php
            if (isset($dados['nome_curso'])) {
                echo $dados['nome_curso'];
            } elseif (isset($row_curso['nome_curso'])) {
                echo $row_curso['nome_curso'];
            }
            ?>" ><br><br>

            <label>Instrutor: </label>
            <input type="text" name="instrutor" id="instrutor" placeholder="Nome do Instrutor" value="<?php
                   if (isset($dados['instrutor'])) {
                       echo $dados['instrutor'];
                   } elseif (isset($row_curso['instrutor'])) {
                       echo $row_curso['instrutor'];
                   }
                   ?>" ><br><br>

            <label>Turno: </label>
            <input type="text" name="turno" id="turno" placeholder="Turno" value="<?php
                   if (isset($dados['turno'])) {
                       echo $dados['turno'];
                   } elseif (isset($row_curso['turno'])) {
                       echo $row_curso['turno'];
                   }
                   ?>" ><br><br>

            <input type="submit" value="Salvar" name="EditUsuario">
        </form>
    </body>
</html>
