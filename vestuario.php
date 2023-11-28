<?php
include('cabecalho2.php');

#PASSANDO UMA INSTRUÇÃO AO BANCO DE DADOS
$sql = "SELECT * FROM produtos WHERE pro_ativo = 's' AND pro_categoria = 'Vestuario'";
$retorno = mysqli_query($link, $sql);

#COLETA O BOTÃO MÉTODO POST VINDO DO HTML
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $sql = "SELECT * FROM produtos WHERE pro_ativo = 's' AND pro_categoria = 'vestuario'";
        $retorno = mysqli_query($link, $sql);
}
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/style2.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <title>AceStore | Roupas</title>
    </head>
    <body>
        <main class="loja-container">
            <div class="wrapper">
                <h1>Roupas</h1>
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
            <footer>
                <div id ="footer-container" >
                    <div class="wrapper">
                        <div class="footer-box">
                            <h2>Redes Sociais</h2>
                            <ul class="footer-links">
                                <li>
                                    <a href="#"><i class='bx bxl-youtube'></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class='bx bxl-instagram'></i></a>
                                </li>
                                <li>
                                    <a href="#"><i class='bx bxl-twitter'></i></a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <ul class="footer-list">
                                <li><a href="#">Início |</a></li>
                                <li><a href="#">Perfil |</a></li>
                                <li><a href="#">Favoritos |</a></li>
                                <li><a href="#">Carrinho</a></li>
                            </ul>
                        </div>
                        <div>
                            <p>
                                © AceStore 2023 Todos os direitos reservados <br>
                                A AceStore é dedicada a oferecer produtos esportivos de excelência, inspirando a busca pela excelência e o desempenho máximo. <br>
                                Nosso compromisso com a qualidade reflete-se em cada item cuidadosamente selecionado para atender às necessidades dos atletas mais exigentes. <br>
                                Seja bem-vindo ao universo da performance elevada. Sua jornada esportiva começa aqui. <br>
                                #ExcelênciaNoEsporte #DesempenhoSuperior #AceStore
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </main>
    </body>
</html>