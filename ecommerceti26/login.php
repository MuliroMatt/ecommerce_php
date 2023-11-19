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
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <title>LOGIN DE USUÁRIO</title>
    </head>
    <body>
        <div class="login-container">
            <div class="wrapper">
                <form action="login.php" method="post">
                    <h1>Login</h1>
                    <p>Por favor insira seu login e sua senha</p>
                    <div class="input-box" id="input-box-name">
                        <input id="login-name" type="text" name="nomeusuario" placeholder="Nome" required>
                        <i class='bx bxs-user'></i>
                    </div>
                    <div class="input-box" id="input-box-password">
                        <input id="login-password" type="password" name="senha" minlength="6" maxlength="18" placeholder="Senha" required>
                        <span id="MostraSenha" onclick="MostraSenha()"><i class='bx bxs-lock-alt'></i></span>
                    </div>
                    <button type="submit" class="btn">Login</button>
                </form>
            </div>
        </div>
    </body>
</html>

<script>
    function MostraSenha() {
        var passwordInput = document.getElementById("login-password");
        var passwordIcon = document.getElementById("MostraSenha");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordIcon.innerHTML = "<i class='bx bxs-lock-open-alt'></i>";
        } else {
            passwordInput.type = "password";
            passwordIcon.innerHTML = "<i class='bx bxs-lock-alt'></i>";
        }
    }
</script>