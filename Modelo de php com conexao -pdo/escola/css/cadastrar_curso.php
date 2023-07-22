<?php
session_start();
ob_start();
include_once './conexao.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SISED - Cadastrar Curso</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
    <body>
        <a href="index.php">Listar</a><br>
        <a href="cadastrar.php">Cadastrar</a><br>
        <a href="../index.html">Home</a><br>
    
        <?php
        //Receber os dados do formulário
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        //Verificar se o usuário clicou no botão
        if (!empty($dados['CadUsuario'])) {
            //var_dump($dados);

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
                $query_curso = "INSERT INTO curso (nome_curso, instrutor, turno) VALUES (:nome_curso, :instrutor, :turno) ";
                $cad_curso = $conn->prepare($query_curso);
                $cad_curso->bindParam(':nome_curso', $dados['nome_curso'], PDO::PARAM_STR);
                $cad_curso->bindParam(':instrutor', $dados['instrutor'], PDO::PARAM_STR);
                $cad_curso->bindParam(':turno', $dados['turno'], PDO::PARAM_STR);
                $cad_curso->execute();
                if ($cad_curso->rowCount()) {
                    unset($dados);
                    $_SESSION['msg'] =  "<p style='color: green;'>Curso cadastrado com sucesso!</p>";
                    header("Location: index.php");
                } else {
                    echo "<p style='color: #f00;'>Erro: Curso não cadastrado com sucesso!</p>";
                }
            }
        }
        ?>
     <div class="main">
        <div class="container">
            <div class="signup-content">
                <div class="signup-form">
                    <form method="POST" class="register-form" id="register-form">
                        <h2>Cadastrar Curso</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Curso :</label>
                                <input type="text" name="nome_curso" id="nome_curso" placeholder="Nome do Curso" value="<?php
                                    if (isset($dados['nome_curso'])) {
                                        echo $dados['nome_curso'];
                                    }
                                    ?>">
                            </div>
                            <div class="form-group">
                                <label for="father_name">Instrutor :</label>
                                <input type="text" name="instrutor" id="instrutor" placeholder="Nome do instrutor" value="<?php
                                    if (isset($dados['instrutor'])) {
                                        echo $dados['instrutor'];
                                    }
                                    ?>">
                            </div>
                        </div> 

                        <div class="form-radio">
                            <label for="gender" class="radio-label">Turno :</label>
                            <div class="form-radio-item">
                            <input type="text" name="turno" id="turno" placeholder="Turno do curso" value="<?php
                                if (isset($dados['turno'])) {
                                    echo $dados['turno'];
                                }
                                ?>">
                            </div>
                        </div>
                        
                        <div class="form-submit">
                            <input type="submit" value="Cadastrar" name="CadUsuario">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    </body>
</html>
