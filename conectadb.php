<?php
//* conecta com o servidor (xampp)
    $servidor = "localhost";
//* nome do banco
    $banco = "ecommerce";
//* nome do usuario
    $usuario = "admin";
//* senha do usuario
    $senha = "123";
//* link de conexao com o banco
    $link = mysqli_connect($servidor, $usuario, $senha, $banco);

    
?>