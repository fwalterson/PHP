<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SISED - Listar Aluno</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
session_start();
include_once './conexao.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SISED - Listar Aluno</title>
    </head>
    <body>
        <a href="index_aluno.php">Listar</a><br>
        <a href="cadastrar_curso.php">Cadastrar</a><br>
        <a href="../index.html">Home</a><br>
        
        <h1>Listar</h1>

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


        $query_aluno = "SELECT id_aluno, nome_aluno, curso_aluno, sexo, nota1, nota2, media FROM aluno ORDER BY id_aluno DESC LIMIT $inicio, $limite_resultado";
        $result_aluno = $conn->prepare($query_aluno);
        $result_aluno->execute();

        if (($result_aluno) AND ($result_aluno->rowCount() != 0)) {
            while ($row_aluno = $result_aluno->fetch(PDO::FETCH_ASSOC)) {
                // var_dump($row_usuario);
                extract($row_aluno);
                // echo "ID: " . $row_usuario['id'] . "<br>";
                echo "ID: $id_aluno <br>";
                echo "Aluno: $nome_aluno <br>";
                echo "Curso: $curso_aluno <br>";
                echo "Sexo: $sexo <br>";
                echo "Nota Parcial: $nota1 <br>";
                echo "Nota Institucional: $nota2 <br>";
                echo "Media Final: $media <br><br>";
                
                echo "<a href='editar_aluno.php?id=$id_aluno'>Editar</a><br>";
                echo "<a href='apagar_aluno.php?id=$id_aluno'>Apagar</a><br>";
                echo "<hr>";
            }
        }
        ?>
    </body>
</html>
