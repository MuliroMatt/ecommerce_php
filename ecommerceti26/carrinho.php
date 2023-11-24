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
$retorno2 = mysqli_query($link, $sql);//*USADO PARA FAZER O TOTAL

$total = 0; //*INICIALIZA A VARIÁVEL TOTAL

while($row = mysqli_fetch_assoc($retorno2)) {
    $preco = $row['pro_valor'];
    $quantidade = $row['car_item_quantidade'];
    $subtotal = $preco * $quantidade;
    $total += $subtotal;//*ADICIONA O SUBTOTAL AO TOTAL
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style2.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>AceStore | Carrinho</title>
</head>
<body>
    <main class="carrinho-container">
        <div class="wrapper">
            <?php
            if(mysqli_num_rows($retorno) > 0){
            ?>
                <div class="small-container">
                    <div class="grid-products">
                    <?php
                    while($tbl = mysqli_fetch_array($retorno)) {
                    ?>
                    <div class="product-card">
                        <div class="product-img">
                            <img src="data:image/jpeg;base64,<?= $tbl[7] ?>" alt="Product Image">
                        </div>
                        
                            <div class="product-info">
                                <p class="product-title"><?= $tbl[4] ?></p>
                                <h2 class="product-price">R$ <?= $tbl[6] * $tbl[8]?></h2>
                                <div class="qtd-container">
                                    <button onclick="location.href='atualizar_carrinho.php?var1=<?=$tbl[3]?> &var2=<?=$tbl[8] - 1?>'" class="qtd-button" id="decrement">
                                        -
                                    </button>
                                    <div class="qtd-btn">
                                        <p><?= $tbl[8]?> </p>
                                    </div>
                                    <button onclick="location.href='atualizar_carrinho.php?var1=<?=$tbl[3]?> &var2=<?=$tbl[8] + 1?>'" class="qtd-button" id="increment">
                                        +
                                    </button>
                                </div>
                            </div>
                        <button onclick="location.href='deleta_produto_carrinho.php?var1=<?=$tbl[3]?> &var2=<?=$tbl[0]?>'" class="delete-btn">
                        <i class='bx bx-x'></i>
                        </button>
                    </div>
                    <?php
                    }
                    ?>
                    </div>
                    <div class="finaliza-container">
                        <div class="preco-total">
                            <p>Total</p>
                            <p>R$ <?=$total ?></p>
                        </div>
                        <a href="finaliza_carrinho.php?id=<? ($idusuario) ?>" class="finaliza-btn">Comprar</a>
                    </div>
                </div>
            <?php
            } else {
            ?>
                <div class="carrinho-vazio">
                    <div class="carrinho-img">
                        <i class="bx bx-cart"></i>
                    </div>
                    <h1>Seu carrinho está vazio</h1>
                    <p>Dê uma olhada nos nossos produtos</p>
                    <button onclick="location.href='loja.php'">Comece a comprar agora</button>
                </div>
            <?php
            }
            ?>
        </div>
    </main>
</body>
</html>