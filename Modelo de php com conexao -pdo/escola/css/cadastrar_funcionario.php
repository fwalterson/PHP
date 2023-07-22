<?php
session_start();
ob_start();
include_once './conexao.php';
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SISED Cadastrar Funcionario</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        label{
            color:white;

        }
        h1{
            color:white;
        }
    </style>
</head>
    <body >
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
                $query_funcionario = "INSERT INTO funcionario (nome_funcionario, sexo, fone, cargo, setor) 
                VALUES (:nome_funcionario, :sexo, :fone, :cargo, :setor) ";
                $cad_funcionario = $conn->prepare($query_funcionario);
                $cad_funcionario->bindParam(':nome_funcionario', $dados['nome_funcionario'], PDO::PARAM_STR);
                $cad_funcionario->bindParam(':sexo', $dados['sexo'], PDO::PARAM_STR);
                $cad_funcionario->bindParam(':fone', $dados['fone'], PDO::PARAM_STR);
                $cad_funcionario->bindParam(':cargo', $dados['cargo'], PDO::PARAM_STR);
                $cad_funcionario->bindParam(':setor', $dados['setor'], PDO::PARAM_STR);
                $cad_funcionario->execute();
                
                if ($cad_funcionario->rowCount()) {
                    unset($dados);
                    $_SESSION['msg'] =  "<p style='color: green;'>Funcionario cadastrado com sucesso!</p>";
                    header("Location: index_funcionario.php");
                } else {
                    echo "<p style='color: #f00;'>Erro: Funcionario não cadastrado!</p>";
                }
            }
        }
        ?>
    
                    <form method="POST" class="register-form" id="register-form">
                        <h1>Cadastrar Funcionario</h1>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Nome :</label>
                                <input type="text" name="nome_funcionario" id="nome_funcionario" placeholder="Nome do funcionario" value="<?php
                                    if (isset($dados['nome_funcionario'])) {
                                        echo $dados['nome_funcionario'];
                                    }
                                    ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="father_name">Telefone :</label>
                                <input type="number" name="fone" id="fone" placeholder="Digite seu telefone" value="<?php
                                    if (isset($dados['fone'])) {
                                        echo $dados['fone'];
                                    }
                                    ?>">
                            </div>
                        </div> 
                        <div class="form-row">
                        <div class="form-group">
                         
                            
                        <label for="address">Sexo:</label>
                            <input type="text" name="sexo" id="sexo" placeholder="Digite seu sexo" value="<?php
                                    if (isset($dados['sexo'])) {
                                        echo $dados['sexo'];
                                    }
                                    ?>">
                            </div>
                          
                        </div>
                        <div class="form-row">
                        <div class="form-group">
                            <label for="address">Cargo:</label>
                            <input type="text" name="cargo" id="cargo" placeholder="Digite seu cargo" value="<?php
                                    if (isset($dados['cargo'])) {
                                        echo $dados['cargo'];
                                    }
                                    ?>">
                        </div>
                        <div class="form-row">
                        <div class="form-group">
                            <label for="address">Setor:</label>
                            <input type="text" name="setor" id="setor" placeholder="Digite o seto" value="<?php
                                    if (isset($dados['setor'])) {
                                        echo $dados['setor'];
                                    }
                                    ?>">
                        </div>
                       
                        <div class="form-submit">
                            <input type="submit" value="Cadastrar" name="CadUsuario">
                            <a href="../index.html">op>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
   </body>
</html>