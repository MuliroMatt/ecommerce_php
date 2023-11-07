<?php
//*INICIA A CONEXÃO COM O BANCO DE DADOS 
include("conectadb.php");

//*COLETA DE VARIÁVEIS VIA FORMULÁRIO DE HTML
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
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

<html>
    <head>
        <link rel="stylesheet" href="./css/estiloadm.css">
        <title>CADASTRO DE CLIENTE</title>
    </head>
    <body>
        <div>
            <form action="cadastracliente.php" method="post">
                <input type="text" name="email" id="email" placeholder="E-mail">
                <p></p>
                <input type="text" name="nome" id="nome" placeholder="Nome de Usuario">
                <p></p>
                <input type="password" name="senha" id="senha" minlength="6" maxlength="18" placeholder="Senha">
                <span id="MostraSenha" onclick="MostraSenha()">👁</span>
                <p></p>
                <input type="submit" name="cadastrar" id="cadastrar" placeholder="Cadastrar">
            </form>
        </div>
    </body>
</html>

<!-- SCRIPT PARA MOSTRAR A SENHA -->

<script>
    function MostraSenha() {
        var passwordInput = document.getElementById("senha");
        var passwordIcon = document.getElementById("MostraSenha");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            passwordIcon.textContent = "❌";
        } else {
            passwordInput.type = "password";
            passwordIcon.textContent = "👁";
        }
    }
</script>