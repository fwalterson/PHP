<?php
session_start();
ob_start();
include_once './conexao.php';

$id_funcionario = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if (empty($id_funcionario)) {
    $_SESSION['msg'] = "";
    header("Location: index_funcionario.php");
    exit();
}

$query_funcionario = "SELECT id_funcionario, nome_funcionario, sexo, fone, cargo, setor FROM funcionario WHERE id_funcionario = $id_funcionario LIMIT 1";
$result_funcionario = $conn->prepare($query_funcionario);
$result_funcionario->execute();

if (($result_funcionario) AND ($result_funcionario->rowCount() != 0)) {
    $row_funcionario = $result_funcionario->fetch(PDO::FETCH_ASSOC);
    //var_dump($row_usuario);
} else {
    $_SESSION['msg'] = "<p style='color: #f00;'>Erro: Funcionario não encontrado!</p>";
    header("Location: editar_funcionario.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SISED- Editar Funcionario</title>
    </head>
    <body>
        <a href="index_funcionario.php">Listar</a><br>
        <a href="cadastrar.php">Cadastrar</a><br>
        <a href="../index.html">Home</a><br>

        <h1>Editar Funcionario</h1>

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
                $query_up_funcionario= "UPDATE funcionario SET nome_funcionario=:nome_funcionario, sexo=:sexo, fone=:fone, cargo=:cargo, setor=:setor WHERE id_funcionario=:id_funcionario";
                $edit_funcionario = $conn->prepare($query_up_funcionario);
                $edit_funcionario->bindParam(':nome_funcionario', $dados['nome_funcionario'], PDO::PARAM_STR);
                $edit_funcionario->bindParam(':sexo', $dados['sexo'], PDO::PARAM_STR);
                $edit_funcionario->bindParam(':fone', $dados['fone'], PDO::PARAM_STR);
                $edit_funcionario->bindParam(':cargo', $dados['cargo'], PDO::PARAM_STR);
                $edit_funcionario->bindParam(':setor', $dados['setor'], PDO::PARAM_STR);
                $edit_funcionario->bindParam(':id_aluno', $id_funcionario, PDO::PARAM_INT);
                if($edit_funcionario->execute()){
                    $_SESSION['msg'] = "<p style='color: green;'>Funcionario editado com sucesso!</p>";
                    header("Location: index_funcionario.php");
                }else{
                    echo "<p style='color: #f00;'>Erro: Funcionario não editado!</p>";
                }
            }
        }
        ?>

        <form id="edit-usuario" method="POST" action="">
            <label>Funcionario: </label>
            <input type="text" name="nome_funcionario" id="nome_funcionario" placeholder="Nome do funcionario" value="<?php
            if (isset($dados['nome_funcionario'])) {
                echo $dados['nome_funcionario'];
            } elseif (isset($row_funcionario['nome_funcionario'])) {
                echo $row_funcionario['nome_funcionario'];
            }
            ?>" ><br><br>

            <label>Sexo: </label>
            <input type="text" name="sexo" id="sexo" placeholder="sexo" value="<?php
                   if (isset($dados['sexo'])) {
                       echo $dados['sexo'];
                   } elseif (isset($row_funcionario['sexo'])) {
                       echo $row_funcionario['sexo'];
                   }
                   ?>" ><br><br>    
                   
            <label>Fone: </label>
            <input type="text" name="fone" id="fone" placeholder="Seu telefone/WhasApp" value="<?php
                   if (isset($dados['fone'])) {
                       echo $dados['fone'];
                   } elseif (isset($row_funcionario['fone'])) {
                       echo $row_funcionario['fone'];
                   }
                   ?>" ><br><br>

            <label>Cargo: </label>
            <input type="text" name="cargo" id="cargo" placeholder="Função" value="<?php
                   if (isset($dados['cargo'])) {
                       echo $dados['cargo'];
                   } elseif (isset($row_funcionario['cargo'])) {
                       echo $row_funcionario['cargo'];
                   }
                   ?>" ><br><br>

            <label>Setor: </label>
            <input type="text" name="setor" id="setor" placeholder="Departamento" value="<?php
                   if (isset($dados['setor'])) {
                       echo $dados['setor'];
                   } elseif (isset($row_funcionario['setor'])) {
                       echo $row_funcionario['setor'];
                   }
                   ?>" ><br><br>

            <input type="submit" value="Salvar" name="EditUsuario">
        </form>
    </body>
</html>