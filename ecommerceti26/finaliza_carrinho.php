<?php
include("cabecalho2.php");
$idusuario = $_SESSION['idusuario'];

//*PESQUISA IDENTIFICADOR DO CARRINHO
$sql = "SELECT
c.car_id, c.fk_cli_id, c.car_finalizado,
p.pro_id, p.pro_nome, p.pro_descricao, p.pro_valor, p.pro_imagem,
ic.car_item_quantidade, ic.fk_car_id, ic.fk_pro_id
FROM carrinho c
JOIN item_carrinho ic ON c.car_id = ic.fk_car_id
JOIN produtos p ON ic.fk_pro_id = p.pro_id
WHERE c.fk_cli_id = $idusuario
AND c.car_finalizado = 'n'";
$retorno = mysqli_query($link,$sql);
//* USADO PARA FAZER A REMOÇÃO DOS ITENS DO INVENTARIO
$retorno2 = mysqli_query($link, $sql);
//* USADO PARA FAZER O TOTAL
$retorno3 = mysqli_query($link, $sql);
//* USADO PARA FAZER A FINALIZAÇÃO DO CARRINHO

$total = 0; //* INICIALIZA A VARIÁVEL TOTAL

while($row = mysqli_fetch_assoc($retorno2)) {
    $preco = $row['pro_valor'];
    $quantidade = $row['car_item_quantidade'];
    $subtotal = $preco * $quantidade;

    $total += $subtotal;//*ADICIONA O SUBTOTAL AO TOTAL
}

//* TIRA OS ITENS DO INVENTÁRIO
while ($tbl = mysqli_fetch_array($retorno)) {
    $sql3 = "SELECT pro_quantidade FROM produtos WHERE pro_id = $tbl[3]";

    $retorno4 = mysqli_query($link, $sql3);
    while ($row = mysqli_fetch_assoc($retorno4)){
        $quantidade_produto = $row['pro_quantidade'];
        $sql4 = "UPDATE produtos SET pro_quantidade = $quantidade_produto - $tbl[8] WHERE pro_id = $tbl[3]";
        $resultado4 = mysqli_query($link, $sql4);
    }
}

$tbl = mysqli_fetch_array($retorno3);
//* INCLUI O TOTAL, DATA DA VENDA E FINALIZA O CARRINHO
$data = date("Y-m-d"); //* PEGANDO O DIA ATUAL

//* PEGANDO O TOTAL DE ITENS QUE TEM NO CARRINHO
$sql2 = "SELECT COUNT(*) FROM item_carrinho WHERE fk_car_id = $tbl[0]";
$retorno3 = mysqli_query($link, $sql2);
$total_itens = mysqli_fetch_array($retorno3);

//* REALIZANDO O UPDATE 
$sql_total = "UPDATE carrinho SET car_valorvenda = $total, car_datavenda = '$data', car_finalizado = 's', 
car_total_item = $total_itens[0] WHERE car_id = $tbl[0]";
$resultado2 = mysqli_query($link, $sql_total);

header("Location: loja.php");
?>