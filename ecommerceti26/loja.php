<?php
    #ABRE UMA CONEXÃO COM O BANCO DE DADOS
    include("cabecalho2.php");

    #PASSANDO UMA INSTRUÇÃO AO BANCO DE DADOS
    $sql = "SELECT * FROM produtos WHERE pro_ativo = 's'";
    $retorno = mysqli_query($link, $sql);

    #COLETA O BOTÃO MÉTODO POST VINDO DO HTML
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $sql = "SELECT * FROM produtos WHERE pro_ativo = 's'";
            $retorno = mysqli_query($link, $sql);
    }
?>


<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/style2.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
        <title>LOJA</title>
    </head>
    <body>
        <div class="loja-container">
            <div class="wrapper">
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
                        <span class="product-stock">Fora de Estoque</span>
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
    </body>
</html>