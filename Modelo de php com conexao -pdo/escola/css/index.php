<?php
session_start();
include_once './conexao.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SISED - Listar</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
    <body>
        <a href="index.php">Listar</a><br>
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


        $query_curso = "SELECT id_curso, nome_curso, instrutor, turno FROM curso ORDER BY id_curso DESC LIMIT $inicio, $limite_resultado";
        $result_curso = $conn->prepare($query_curso);
        $result_curso->execute();

        if (($result_curso) AND ($result_curso->rowCount() != 0)) {
            while ($row_curso = $result_curso->fetch(PDO::FETCH_ASSOC)) {
                // var_dump($row_usuario);
                extract($row_curso);
                // echo "ID: " . $row_usuario['id'] . "<br>";
                echo "ID: $id_curso <br>";
                echo "Curso: $nome_curso <br>";
                echo "Turno: $turno <br>";
                echo "Instrutor(a): $instrutor <br><br>";
                
                echo "<a href='editar_curso.php?id=$id_curso'>Editar</a><br>";
                echo "<a href='apagar_curso.php?id=$id_curso'>Apagar</a><br>";
                echo "<hr>";
            }
        }
        ?>
    </body>
</html>
