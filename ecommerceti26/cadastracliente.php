<?php
//*INICIA A CONEXÃO COM O BANCO DE DADOS 
include("cabecalho2.php");

//*COLETA DE VARIÁVEIS VIA FORMULÁRIO DE HTML
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nomecliente'];
    $senha = $_POST['senha'];
    $email = $_POST['email'];

    if (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d])/', $senha)) {
        //*(?=.*[a-z]): Pelo menos 1 letra minúscula.
        //*(?=.*[A-Z]): Pelo menos 1 letra maiúscula.
        //*(?=.*\d): Pelo menos 1 numeral.
        //*(?=.*[^a-zA-Z\d]): Pelo menos 1 caractere especial 

        //*PASSANDO INSTRUÇÕES SQL PARA O BANCO
        //*VALIDANDO SE USUARIO EXISSTE
        $sql = "SELECT COUNT(cli_id) FROM clientes WHERE cli_nome = '$nome' AND cli_senha = '$senha' AND cli_ativo = 's'";
        $retorno = mysqli_query($link, $sql);
        while($tbl = mysqli_fetch_array($retorno)){
            $cont = $tbl[0];
        }
        //*VERIFICAÇÃO SE USUARIO EXISTE, SE EXISTE = 1 SENÃO = 0
        if($cont == 1) {
            echo "<script>window.alert('USUÁRIO JÁ CADASTRADO!');</script>";
        }
        else{
            $tempero = md5(rand() . date('H:i:s'));
            $senha = md5($senha . $tempero);
            $sql = "INSERT INTO clientes (cli_nome, cli_senha, cli_email, cli_ativo, cli_tempero) 
            VALUES('$nome','$senha','$email','s', '$tempero')";
            mysqli_query($link, $sql);
            echo "<script>window.alert('USUÁRIO CADASTRADO!');</script>";
            echo "<script>window.location.href='logincliente.php';</script>";
        }
    }
    else {
        echo "<script>window.alert('SENHA INVÁLIDA!');</script>";
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
        <title>CADASTRO DE CLIENTE</title>
    </head>
    <body>
        <div class="cadastracliente-container">
            <div class="wrapper">
                <form action="cadastracliente.php" method="post">
                    <h1>Registre-se</h1>
                    <p>Crie a sua conta e aproveito ao máximo o que nós temos para oferecer</p>
                    <div class="input-box">
                        <input id="signin-email" type="text" name="email" placeholder="E-mail">
                        <i class='bx bxs-envelope'></i>
                    </div>
                    <div class="input-box" id="input-box-name">
                        <input id="login-name" type="text" name="nomecliente" placeholder="Nome">
                        <i class='bx bxs-user'></i>
                    </div>
                    <div class="input-box" id="input-box-password">
                        <input id="login-password" type="password" name="senha" minlength="6" maxlength="18" placeholder="Senha">
                        <span id="MostraSenha" onclick="MostraSenha()"><i class='bx bxs-lock-alt'></i></span>
                    </div>
                    <button type="submit" class="btn">Registrar</button>
                </form>
                <div class="register-link">
                    <p>Já tem uma conta? <a href="logincliente.php">Faça login</a></p>
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