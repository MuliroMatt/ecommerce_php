<?php
include('cabecalho2.php');

#PASSANDO UMA INSTRUÇÃO AO BANCO DE DADOS
$sql = "SELECT * FROM produtos WHERE pro_ativo = 's' AND pro_categoria = 'Acessorios'";
$retorno = mysqli_query($link, $sql);

#COLETA O BOTÃO MÉTODO POST VINDO DO HTML
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $sql = "SELECT * FROM produtos WHERE pro_ativo = 's' AND pro_categoria = 'Acessorios'";
        $retorno = mysqli_query($link, $sql);
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/stylenew.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <title>AceStore | Acessórios</title>
    </head>
    <body>
        <div class="container loja">
            <main>
                <div class="wrapper">
                    <h1>Produtos</h1>
                    <div class="grid-products">
                        <?php
                        while ($tbl = mysqli_fetch_array($retorno)) {
                        ?>
                        <a href="verproduto.php?id=<?= $tbl[0] ?>" class="product-card">
                            
                            <div class="product-img">
                                <img src="data:image/jpeg;base64,<?=$tbl[5] ?>" alt="Product Image">
                            </div>
                            <p class="product-title"><?=$tbl[1] ?></p>
                            <?php
                            if ($tbl[3] > 0) {
                            ?>
                            <section class="price-container">
                                <p class="product-price">R$ <?=$tbl[4] ?></p>
                            </section>
                            
                            <?php
                            } else { //FORA DE ESTOQUE
                            ?>
                            <section class="price-container">
                                <span class="product-stock">Esgotado</span>
                            </section>
                            <?php
                            }
                            ?>
                        </a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </main>
            <?php
            include("footer.html");
            ?>
        </div>
    </body>
</html>