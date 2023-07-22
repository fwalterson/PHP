<?php
session_start();
include_once './conexao.php';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SISED - Listar</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .list{
width: 35%;
margin-left:30%;
color:white;
           background:black;
        }
        h1{
            text-align:center;
        }
        a{

            text-decoration:none;
            color:white;
            display:inline;
        }
    </style>
</head>
    <body style="background-color:blue;">
<div class="list">
    <fieldset>
        <h1>Listar Funcionario</h1>
        <a href="listar_funcionario.php">Listar</a><br>
        <a href="cadastrar_funcionario.php">Cadastrar</a><br>
        <a href="../index.html">Home</a><br>
        <hr>
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


        $query_funcionario = "SELECT id_funcionario, nome_funcionario, sexo, fone, cargo, setor FROM funcionario ORDER BY id_funcionario 
        DESC LIMIT $inicio, $limite_resultado";
        $result_funcionario = $conn->prepare($query_funcionario);
        $result_funcionario->execute();

        if (($result_funcionario) AND ($result_funcionario->rowCount() != 0)) {
            while ($row_funcionario = $result_funcionario->fetch(PDO::FETCH_ASSOC)) {
                // var_dump($row_usuario);
                extract($row_funcionario);
                // echo "ID: " . $row_usuario['id'] . "<br>";
                echo "ID: $id_funcionario <br>";
                echo "Curso: $nome_funcionario <br>";
                echo "Sexo: $sexo <br>";
                echo "Telefone: $fone <br>";
                echo "Cargo: $cargo <br>";
                echo "Setor: $setor <br>";
                echo "<hr>";
                echo "<a href='editar_funcionario.php?id=$id_funcionario'>Editar</a><br>";
                echo "<a href='apagar_funcionario.php?id=$id_funcionario'>Apagar</a><br>";
              
            }
        }
        ?>
       
        </div>
        </fieldset>
    </body>
</html>
