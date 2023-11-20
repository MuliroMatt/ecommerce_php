<?php
    

    include("cabecalho2.php");

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
        <link rel="stylesheet" href="./css/style2.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <title>LOGIN DE CLIENTE</title>
    </head>
    <body>
        <div class="logincliente-container">
            <div class="wrapper">
                <form action="logincliente.php" method="POST">
                    <h1>Login Cliente</h1>
                    <p>Por favor insira seu login e sua senha</p>
                    <div class="input-box" id="input-box-name">
                        <input id="login-name" type="text" name="nomecliente" placeholder="Nome">
                        <i class='bx bxs-user'></i>
                    </div>
                    <div class="input-box" id="input-box-password">
                        <input id="login-password" type="password" name="senha" minlength="6" maxlength="18" placeholder="Senha">
                        <span id="MostraSenha" onclick="MostraSenha()"><i class='bx bxs-lock-alt'></i></span>
                    </div>
                    <div class="forgot">
                        <a href="recuperasenha.php">Esqueceu sua senha?</a>
                    </div>
                    <button type="submit" class="btn">Login</button>
                </form>
                <div class="register-link">
                    <p>Não tem uma conta? <a href="cadastracliente.php">Registre-se</a></p>
                </div>
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
            passwordIcon.innerHTML = "<i class='bx bx-lock-open-alt'></i>";
        } else {
            passwordInput.type = "password";
            passwordIcon.innerHTML = "<i class='bx bxs-lock-alt'></i>";
        }
    }
</script>