<?php
session_start();
ob_start();
include_once './conexao.php';

$id_aluno = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id_aluno)) {
    $_SESSION['msg'] = "";
    header("Location: index_aluno.php");
    exit();
}

$query_aluno = "SELECT id_aluno, nome_aluno, curso_aluno, sexo, nota1, nota2, media FROM aluno WHERE id_aluno = $id_aluno LIMIT 1";
$result_aluno = $conn->prepare($query_aluno);
$result_aluno->execute();

if (($result_aluno) AND ($result_aluno->rowCount() != 0)) {
    $row_curso = $result_aluno->fetch(PDO::FETCH_ASSOC);
    //var_dump($row_usuario);
} else {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Aluno não encontrado!</p>";
    header("Location: editar_curso.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SISED- Editar Aluno</title>
    </head>
    <body>
        <a href="index_aluno.php">Listar</a><br>
        <a href="cadastrar.php">Cadastrar</a><br>
        <a href="../index.html">Home</a><br>

        <h1>Editar Aluno</h1>

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
                $query_up_aluno= "UPDATE aluno SET nome_aluno=:nome_aluno, curso_aluno=:curso_aluno, sexo=:sexo, nota1=:nota1, nota2=:nota2, media=:media WHERE id_aluno=:id_aluno";
                $edit_aluno = $conn->prepare($query_up_aluno);
                $edit_aluno->bindParam(':nome_aluno', $dados['nome_aluno'], PDO::PARAM_STR);
                $edit_aluno->bindParam(':curso_aluno', $dados['curso_aluno'], PDO::PARAM_STR);
                $edit_aluno->bindParam(':sexo', $dados['sexo'], PDO::PARAM_STR);
                $edit_aluno->bindParam(':nota1', $dados['nota1'], PDO::PARAM_INT);
                $edit_aluno->bindParam(':nota2', $dados['nota2'], PDO::PARAM_INT);
                $edit_aluno->bindParam(':media', $dados['media'], PDO::PARAM_INT);
                $edit_aluno->bindParam(':id_aluno', $id_aluno, PDO::PARAM_INT);
                if($edit_aluno->execute()){
                    $_SESSION['msg'] = "<p style='color: green;'>Aluno editado com sucesso!</p>";
                    header("Location: index_aluno.php");
                }else{
                    echo "<p style='color: #f00;'>Erro: Aluno não editado!</p>";
                }
            }
        }
        ?>

        <form id="edit-usuario" method="POST" action="">
            <label>Aluno: </label>
            <input type="text" name="nome_aluno" id="nome_aluno" placeholder="Nome do aluno" value="<?php
            if (isset($dados['nome_aluno'])) {
                echo $dados['nome_aluno'];
            } elseif (isset($row_curso['nome_aluno'])) {
                echo $row_curso['nome_aluno'];
            }
            ?>" ><br><br>

            <label>Curso: </label>
            <input type="text" name="curso_aluno" id="curso_aluno" placeholder="Nome do curso" value="<?php
                   if (isset($dados['curso_aluno'])) {
                       echo $dados['curso_aluno'];
                   } elseif (isset($row_curso['curso_aluno'])) {
                       echo $row_curso['curso_aluno'];
                   }
                   ?>" ><br><br>

            <label>Turno: </label>
            <input type="text" name="sexo" id="sexo" placeholder="sexo" value="<?php
                   if (isset($dados['sexo'])) {
                       echo $dados['sexo'];
                   } elseif (isset($row_curso['sexo'])) {
                       echo $row_curso['sexo'];
                   }
                   ?>" ><br><br>

            <label>Nota Parcial: </label>
            <input type="number" name="nota1" id="nota1" placeholder="AV.1" value="<?php
                   if (isset($dados['nota1'])) {
                       echo $dados['nota1'];
                   } elseif (isset($row_curso['nota1'])) {
                       echo $row_curso['nota1'];
                   }
                   ?>" ><br><br>

            <label>Nota Institucional: </label>
            <input type="number" name="nota2" id="nota2" placeholder="AV.2" value="<?php
                   if (isset($dados['nota2'])) {
                       echo $dados['nota2'];
                   } elseif (isset($row_curso['nota2'])) {
                       echo $row_curso['nota2'];
                   }
                   ?>" ><br><br>

            <label>Nota Final: </label>
            <input type="number" name="media" id="media" placeholder="Media Final" value="<?php
                   if (isset($dados['media'])) {
                       echo $dados['media'];
                   } elseif (isset($row_curso['media'])) {
                       echo $row_curso['media'];
                   }
                   ?>" ><br><br>

            <input type="submit" value="Salvar" name="EditUsuario">
        </form>
    </body>
</html>