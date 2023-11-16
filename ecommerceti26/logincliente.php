<?php
    session_start();//*INICIA A SESSÃO

    include("conectadb.php");

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $nome = $_POST['nomecliente'];
        $senha = $_POST['senha'];

        //*BUSCA O TEMPERO
        $sql = "SELECT cli_tempero FROM clientes WHERE cli_nome = '$nome'";
        $retorno = mysqli_query($link, $sql);
        while ($tbl = mysqli_fetch_array($retorno)){
            $tempero = $tbl[0];
        }
        
        $senha = md5($senha . $tempero);

        $sql = "SELECT COUNT(cli_id) FROM clientes WHERE cli_nome = '$nome' AND cli_senha = '$senha'";
        $retorno = mysqli_query($link, $sql);
        while ($tbl = mysqli_fetch_array($retorno)) {
            $cont = $tbl[0];
        }
        if($cont == 1){
            $sql = "SELECT * FROM clientes WHERE cli_nome = '$nome' AND cli_senha = '$senha' AND cli_ativo = 's'";
            $retorno = mysqli_query($link, $sql);
            while ($tbl = mysqli_fetch_array($retorno)) {
                $_SESSION['idusuario'] = $tbl[0];
                $_SESSION['nomeusuario'] = $tbl[1];
            }
            //*echo $_SESSION['nomeusuario'];
            echo "<script>window.location.href='loja.php';</script>";
        } else {
            echo "<script>window.alert('USUÁRIO OU SENHA INCORRETOS');</script>";
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/style.css">
        <title>LOGIN DE USUÁRIO</title>
    </head>
    <body>
        <div class="login-form-container">
            <form class="login-form" action="logincliente.php" method="POST">
                <h1>Login Cliente</h1>
                <p>Por favor insira seu login e sua senha</p>
                <input class="login-input" id="login-name" type="text" name="nomecliente" placeholder="Nome">
                <br>
                <input class="login-input" id="login-password" type="password"  name="senha" placeholder="Senha">
                <br>
                <input class="login-input" id="login-btn" type="submit" name="login" value="Login">
                <br>
                <button onclick="window.location.href='./cadastracliente.php'">Cadastrar</button>
                <button onclick="window.location.href='./recuperasenha.php'">Recuperar Senha</button>
            </form>
        </div>
    </body>
</html>