<?php
//*INICIA A CONEXÃO COM O BANCO DE DADOS 
include("conectadb.php");

//*COLETA DE VARIÁVEIS VIA FORMULÁRIO DE HTML
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];

    //*PASSANDO INSTRUÇÕES SQL PARA O BANCO
    //*VALIDANDO SE USUARIO EXISSTE
    $sql = "SELECT COUNT(usu_id) FROM usuarios WHERE usu_nome = '$nome' AND usu_senha = '$senha' AND usu_ativo = 's'";
    $retorno = mysqli_query($link, $sql);
    while($tbl = mysqli_fetch_array($retorno)){
        $cont = $tbl[0];
    }
    //*VERIFICAÇÃO SE USUARIO EXISTE, SE EXISTE = 1 SENÃO = 0
    if($cont == 1) {
        echo "<script>window.alert('USUÁRIO JÁ CADASTRADO!');</script>";
    }
    else{
        $sql = "INSERT INTO usuarios (usu_nome, usu_senha, usu_ativo) VALUES('$nome','$senha','n')";
        mysqli_query($link, $sql);
        echo "<script>window.alert('USUÁRIO CADASTRADO!');</script>";
        echo "<script>window.location.href='cadastrousuario.php';</script>";
    }
}
?>







<html>
    <head>
        <link rel="stylesheet" href="./css/estiloadm.css">
        <title>CADASTRO DE USUÁRIO</title>
    </head>
    <body>
        <div>
            <form action="cadastrousuario.php" method="post">
                <input type="text" name="nome" id="nome" placeholder="Nome de Usuario">
                <p></p>
                <input type="password" name="senha" id="senha" placeholder="Senha">
                <p></p>
                <input type="submit" name="cadastrar" id="cadastrar" placeholder="Cadastrar">
            </form>
        </div>
    </body>
</html>