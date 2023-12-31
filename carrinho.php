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
                                    <button onclick="updateQuantity('decrement', <?=$tbl[3]?>, <?=$tbl[8]?>)" class="qtd-button" id="decrement">-</button>
                                    <div class="qtd-btn">
                                        <p><?= $tbl[8]?> </p>
                                    </div>
                                    <button onclick="updateQuantity('increment', <?=$tbl[3]?>, <?=$tbl[8]?>)" class="qtd-button" id="increment">+</button>

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
    <script>
        function updateQuantity(action, var1, currentQuantity) {
            let newQuantity = (action === 'increment') ? (currentQuantity + 1) : (currentQuantity - 1);

            // Garante que a nova quantidade não seja menor que 0
            if (newQuantity > 0) {
                location.href = `atualizar_carrinho.php?var1=${var1}&var2=${newQuantity}`;
            }
        }
    </script>
</body>
</html>