<?php
session_start();
include_once './conexao.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SISED - Listar Funcionario</title>
    </head>
    <body>
        <a href="index_funcionario.php">Listar</a><br>
        <a href="cadastrar_funcionario.php">Cadastrar</a><br>
        <a href="../index.html">Home</a><br>
        <h1>Listar Funcionario</h1>

        <?php
        if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        
        //Receber o número da página
        $pagina_atual = filter_input(INPUT_GET, "page", FILTER_SANITIZE_NUMBER_INT);
        $pagina = (!empty($pagina_atual)) ? $pagina_atual : 1;
        //var_dump($pagina);

        //Setar a quantidade de registros por página
        $limite_resultado = 40;

        // Calcular o inicio da visualização
        $inicio = ($limite_resultado * $pagina) - $limite_resultado;


        $query_funcionario = "SELECT id_funcionario, nome_funcionario, sexo, fone, cargo, setor FROM funcionario ORDER BY id_funcionario DESC LIMIT $inicio, $limite_resultado";
        $result_funcionario = $conn->prepare($query_funcionario);
        $result_funcionario->execute();

        if (($result_funcionario) AND ($result_funcionario->rowCount() != 0)) {
            while ($row_funcionario = $result_funcionario->fetch(PDO::FETCH_ASSOC)) {
                // var_dump($row_usuario);
                extract($row_funcionario);
                // echo "ID: " . $row_usuario['id'] . "<br>";
                echo "ID: $id_funcionario <br>";
                echo "Aluno: $nome_funcionario <br>";
                echo "Sexo: $sexo <br>";
                echo "Nota Parcial: $fone <br>";
                echo "Nota Institucional: $cargo <br>";
                echo "Media Final: $setor <br><br>";
                
                echo "<a href='editar_funcionario.php?id=$id_funcionario'>Editar</a><br>";
                echo "<a href='apagar_funcionario.php?id=$id_funcionario'>Apagar</a><br>";
                echo "<hr>";
            }
        }
        ?>
    </body>
</html>