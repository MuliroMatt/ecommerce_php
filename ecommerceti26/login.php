<?php
    session_start();//*INICIA A SESSÃO

    include("conectadb.php");

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $nome = $_POST['nomeusuario'];
        $senha = $_POST['senha'];

        //*BUSCA O TEMPERO
        $sql = "SELECT usu_tempero FROM usuarios WHERE usu_nome = '$nome'";
        $retorno = mysqli_query($link, $sql);
        while ($tbl = mysqli_fetch_array($retorno)){
            $tempero = $tbl[0];
        }
        
        $senha = md5($senha . $tempero);

        $sql = "SELECT COUNT(usu_id) FROM usuarios WHERE usu_nome = '$nome' AND usu_senha = '$senha'";
        $retorno = mysqli_query($link, $sql);
        while ($tbl = mysqli_fetch_array($retorno)) {
            $cont = $tbl[0];
        }
        if($cont == 1){
            $sql = "SELECT * FROM usuarios WHERE usu_nome = '$nome' AND usu_senha = '$senha' AND usu_ativo = 's'";
            $retorno = mysqli_query($link, $sql);
            while ($tbl = mysqli_fetch_array($retorno)) {
                $_SESSION['idusuario'] = $tbl[0];
                $_SESSION['nomeusuario'] = $tbl[1];
            }
            //*echo $_SESSION['nomeusuario'];
            echo "<script>window.location.href='listausuario.php';</script>";
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
            <form class="login-form" action="login.php" method="POST">
                <h1>Login</h1>
                <p>Por favor insira seu login e sua senha</p>
                <input id="login-name" class="login-input" type="text" name="nomeusuario" placeholder="Nome">
                <br>
                <input id="login-password" class="login-input" type="password"  name="senha" placeholder="Senha">
                <br>
                <input id="login-btn" class="login-input" type="submit" name="login" value="Login">
            </form>
        </div>
        
    </body>
</html>
