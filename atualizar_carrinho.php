<?php
include("cabecalho2.php");
//* COLETA DADOS DO GET
    $id = $_GET['var1'];
    $quantidade = $_GET['var2'];
    //* ATUALIZA A QUANTIDADE DO ITEM NO BANCO DE DADOS
    $sql = "UPDATE item_carrinho SET car_item_quantidade = $quantidade WHERE fk_pro_id = $id";
    //* echo $sql;
    $resultado = mysqli_query($link, $sql);
    //* RETORNA PARA O CARRINHO
    header("Location: carrinho.php?id=$idusuario");
?>