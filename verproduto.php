<?php
    include("cabecalho2.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id'];
        $nomeproduto = $_POST['nomeproduto'];
        $descricao = $_POST['descricao'];
        $quantidade = $_POST['quantidade'];
        $quantidade = (int)$quantidade;
        $preco = $_POST['preco'];
        $preco = (float)$preco;
        $totalitem = (($preco));

        //*GERAR UM RANDOM PARA DEFINIR UM CARRINHO UNICO E EXCLUSIVO
        $numerocarrinho = ($idusuario . RAND());

        //*VALIDAÇÃO CLIENTE LOGADO
        if($idusuario <= 0){
            echo "<script>window.alert('VOCÊ PRECISA FAZER LOGIN PARA ADICIONAR ALGUM ITEM AO CARRINHO!');</script>";
            echo "<script>window.location.href='loja.php';</script>";
        } else {
            //*VERIFICA SE EXISTE UM CARRINHO JÁ ABERTO
            $sql = "SELECT COUNT(car_id) FROM carrinho INNER JOIN clientes ON fk_cli_id = cli_id WHERE cli_id = $idusuario AND car_finalizado = 'n'";
            
            $retorno = mysqli_query($link, $sql);
            //*SE CARRINHO NÃO EXISTE CRIA UM NOVO CARRINHO
            while ($tbl = mysqli_fetch_array($retorno)){
                $cont = $tbl[0];

                if ($cont == 0 ){
                    $valor_venda = $quantidade * $preco;

                    //*SE O CARRINHO NÃO EXISTE GERA UM NOVO CARRINHO E INSERE NA TABELA ITENS DO CARRINHO
                    $sql = "INSERT INTO carrinho(car_id, car_valorvenda, fk_cli_id, car_finalizado) VALUES ($numerocarrinho, $valor_venda,$idusuario,'n')";
                    mysqli_query($link,$sql);
                    

                    //*INSERE O ITEM NO CARRINHO
                    $sql2 = "INSERT INTO 'item_carrinho'('fk_car_id','fk_pro_id','car_item_quantidade') VALUES ($numerocarrinho, $id,$quantidade)";
                    mysqli_query($link,$sql2);
                    $_SESSION['carrinhoid'] = $numerocarrinho;
                    echo "<script>window.alert('PRODUTO ADICIONADO AO CARRINHO $numerocarrinhocliente');</script>";
                    echo "<script>window.location.href='loja.php';</script>";
                } else {
                    //*SE CARRINHO EXISTE, CONSULTA O NUMERO DO CARRINHO PARA ADICIONAR MAIS ITENS
                    $sql = "SELECT car_id FROM carrinho WHERE fk_cli_id = '$idusuario' AND car_finalizado = 'n'";
                    $retorno = mysqli_query($link,$sql);

                    while ($tbl = mysqli_fetch_array($retorno)){
                        $numerocarrinhocliente = $tbl[0];
                        $_SESSION['carrinhoid'] = $numerocarrinhocliente;

                        //*VERIFICA SE JÁ EXISTE ESSE ITEM AO CARRINHO
                        //*SE JÁ EXISTE, ATUALIZA A QUANTIDADE
                        $sql2 = "SELECT car_item_quantidade FROM item_carrinho WHERE fk_car_id = '$numerocarrinhocliente' AND fk_pro_id = $id";
                        $retorno2 = mysqli_query($link, $sql2);
                        $qtd_atual = mysqli_fetch_array($retorno2);
                        if($retorno2) {
                            if(mysqli_num_rows($retorno2) >= 1) {
                                $sql = "UPDATE item_carrinho SET car_item_quantidade = ($quantidade+$qtd_atual[0]) 
                                WHERE fk_car_id = $numerocarrinhocliente AND fk_pro_id = $id";
                                mysqli_query($link,$sql);
                                echo "<script>window.alert('PRODUTO ADICIONADO AO CARRINHO $numerocarrinhocliente');</script>";
                                echo "<script>window.location.href='loja.php';</script>";
                            }
                            //*SE JÁ EXISTE, ADICIONA O NOVO ITEM
                            else{ 
                                $sql = "INSERT INTO item_carrinho(fk_car_id,fk_pro_id,car_item_quantidade)
                                VALUES ($numerocarrinhocliente,$id,$quantidade)";
                                mysqli_query($link, $sql);
                                echo "<script>window.alert('PRODUTO ADICIONADO AO CARRINHO $numerocarrinhocliente');</script>";
                                echo "<script>window.location.href='loja.php';</script>";
                            }
                        }
                    }
                }
            }
        }
        echo "<script>window.location.href='loja.php';</script>";
        exit();
    }
    $id = $_GET['id'];
    $sql = "SELECT * FROM produtos WHERE pro_id = $id";
    $retorno = mysqli_query($link, $sql);
    while($tbl = mysqli_fetch_array($retorno)) {
        $id = $tbl[0];
        $nomeproduto = $tbl[1];
        $quantidade = $tbl[3];
        $descricao = $tbl[2];
        $preco = $tbl[4];
        $imagem_atual = $tbl[5];
        $categoria = $tbl[7];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/stylenew.css">
    <title>AceStore | <?=$nomeproduto?></title>
</head>
<body>
    <div class="container verproduto">
        <main>
            <div class="wrapper">
                <div class="small-container">
                    <div class="col-2 product-img">
                        <td><img name="imagem_atual" class="imagem_atual" src="data:image/jpeg;base64,<?= $imagem_atual ?>"></td>
                    </div>
                    <div class="col-2 product-info">
                        <h4><?= $categoria ?></h4>
                        <div class="pro-container">
                            <h1><?=$nomeproduto?></h1>
                            <?php
                            if (isset($idusuario)) {
                                $sql = "SELECT COUNT(fav_id) FROM favoritos WHERE fav_cli_id = $idusuario AND fav_pro_id = $id";
                                $retorno = mysqli_query($link,$sql);
                                while ($tbl = mysqli_fetch_array($retorno)) {
                                    $cont = $tbl[0];
                                    if($cont <= 0){
                                    ?>
                                    <a class="fav-icon" href="favoritar.php?id=<?= $id ?>">
                                        <i class='bx bx-heart bx-flip-horizontal' style='color:#000' ></i>
                                    </a>
                                    <?php
                                    } else{
                                    ?>
                                    <a class="fav-icon" href="favoritar.php?id=<?= $id ?>">
                                        <i class='bx bxs-heart bx-flip-horizontal' style='color:#000' ></i>
                                    </a>
                                    <?php
                                    }
                                }
                            } else {
                                ?>
                                <a class="fav-icon" href="favoritar.php?id=<?= $id ?>">
                                    <i class='bx bx-heart bx-flip-horizontal' style='color:#000' ></i>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                        if ($quantidade > 0) {
                        ?>
                        <h2>R$ <?=$preco?></h2>
                        <form  class="visualizaproduto" action="verproduto.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $id ?>" readonly>
                            <input type="hidden" name="nomeproduto" id="nome" value="<?= $nomeproduto ?>" readonly>
                            <input type="hidden" name="descricao" readonly value="<?= $descricao ?>">
                            <input type="hidden" name="preco" id="preco" value="R$ <?= $preco ?>" readonly>
                            <div class="qtd-container">
                                <button type="button" class="btn decrement" id="decrement" onclick="stepper(this)"> - </button>
                                <input type="number" name="quantidade" id="quantidade" min="1" value="1" max="<?= $quantidade ?>" step="1" readonly>
                                <button type="button" class="btn increment" id="increment" onclick="stepper(this)"> + </button>
                            </div>
                            <button class="btn carrinho" type="submit">Adicionar ao carrinho</button>
                        </form>
                        <?php
                        }else{
                        ?>
                        <h2 class="esgotado">Esgotado</h2>
                        <form  class="visualizaproduto" action="verproduto.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $id ?>" readonly>
                            <input type="hidden" name="nomeproduto" id="nome" value="<?= $nomeproduto ?>" readonly>
                            <input type="hidden" name="descricao" readonly value="<?= $descricao ?>">
                            <input type="hidden" name="preco" id="preco" value="R$ <?= $preco ?>" readonly>
                            <div class="qtd-container disabled">
                                <button type="button" class="qtd-button" id="decrement" onclick="stepper(this)" disabled> - </button>
                                <input type="number" name="quantidade" id="quantidade" min="1" value="1" max="<?= $quantidade ?>" step="1" readonly>
                                <button type="button" class="qtd-button" id="increment" onclick="stepper(this)" disabled> + </button>
                            </div>
                            <button class="btn carrinho disabled" type="submit" disabled>Adicionar ao carrinho</button>
                        </form>
                        <?php
                        }
                        ?>
                        <hr>
                        <div class="product-desc">
                            <h3>Descrição</h3>
                            <p><?=$descricao?></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php
            include("footer.html");
            ?>
    </div>
</body>
</html>
<script>
    const myInput = document.getElementById("quantidade");
    function stepper(btn){
        let id = btn.getAttribute("id");
        let min = myInput.getAttribute("min");
        let max = myInput.getAttribute("max");
        let step = myInput.getAttribute("step");
        let val = myInput.getAttribute("value");
        let calcStep = (id === "increment") ? (step * 1) : (step * -1);
        let newValue = parseInt(val) + calcStep;

        if (newValue >= min && newValue <= max) {
            myInput.setAttribute("value", newValue);
        }
    }
</script>