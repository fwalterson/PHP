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
    <title>SISED - Cadastrar Aluno</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
</head>
    <body>
        <a href="listar_aluno.php">Listar</a><br>
        <a href="cadastrar_aluno.php">Cadastrar</a><br>
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
                $query_aluno = "INSERT INTO aluno (nome_aluno, curso_aluno, sexo, nota1, nota2, media) VALUES (:nome_aluno, :curso_aluno, :sexo, :nota1, :nota2, :media) ";
                $cad_aluno = $conn->prepare($query_aluno);
                $cad_aluno->bindParam(':nome_aluno', $dados['nome_aluno'], PDO::PARAM_STR);
                $cad_aluno->bindParam(':curso_aluno', $dados['curso_aluno'], PDO::PARAM_STR);
                $cad_aluno->bindParam(':sexo', $dados['sexo'], PDO::PARAM_STR);
                $cad_aluno->bindParam(':nota1', $dados['nota1'], PDO::PARAM_STR);
                $cad_aluno->bindParam(':nota2', $dados['nota2'], PDO::PARAM_STR);
                $cad_aluno->bindParam(':media', $dados['media'], PDO::PARAM_STR);
                $cad_aluno->execute();
                
                if ($cad_aluno->rowCount()) {
                    unset($dados);
                    $_SESSION['msg'] =  "<p style='color: green;'>Aluno cadastrado com sucesso!</p>";
                    header("Location: index_aluno.php");
                } else {
                    echo "<p style='color: #f00;'>Erro: Aluno não cadastrado!</p>";
                }
            }
        }
        ?>
        <div class="main">
        <div class="container">
            <div class="signup-content">
                <div class="signup-form">
                    <form method="POST" class="register-form" id="register-form">
                        <h2>Cadastrar Aluno</h2>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Nome :</label>
                                <input type="text" name="nome_aluno" id="nome_aluno" placeholder="Nome do aluno" value="<?php
                                if (isset($dados['nome_aluno'])) {
                                 echo $dados['nome_aluno'];
                                 }
                                ?>">
                            </div>
                            <div class="form-group">
                                <label for="father_name">Curso :</label>
                                <input type="text" name="curso_aluno" id="curso_aluno" placeholder="Nome do curso" value="<?php
                                if (isset($dados['curso_aluno'])) {
                                    echo $dados['curso_aluno'];
                                }
                                ?>">
                            </div>
                        </div> 

                        <div class="form-radio">
                            <label for="gender" class="radio-label">Sexo :</label>
                            <div class="form-radio-item">
                                <input type="text" name="sexo" id="sexo" placeholder="Sexo" value="<?php
                                    if (isset($dados['sexo'])) {
                                        echo $dados['sexo'];
                                    }
                                    ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Nota 1:</label>
                            <input type="number" name="nota1" id="nota1" placeholder="Nota parcial" value="<?php
                            if (isset($dados['nota1'])) {
                                echo $dados['nota1'];
                            }
                            ?>">
                        </div>

                        <div class="form-group">
                            <label for="address">Nota 2:</label>
                            <input type="number" name="nota2" id="nota2" placeholder="Nota institucional" value="<?php
                            if (isset($dados['nota2'])) {
                                echo $dados['nota2'];
                            }
                            ?>">
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
