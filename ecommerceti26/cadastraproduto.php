<?php
//*INICIA A CONEXÃO COM O BANCO DE DADOS 
include("cabecalho.php");

//*COLETA DE VARIÁVEIS VIA FORMULÁRIO DE HTML
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $nome = trim($nome);
    $descricao = $_POST['descricao'];
    $descricao = trim($descricao);
    $valor = str_replace(",",".", $_POST['valor']);
    $quantidade = $_POST['quantidade'];
    $imagem = $_POST['imagem'];

    $sql = "SELECT COUNT(pro_id) FROM produtos WHERE pro_nome = '$nome' AND pro_ativo = 's'";
    $retorno = mysqli_query($link, $sql);
    while($tbl = mysqli_fetch_array($retorno)){
        $cont = $tbl[0];
    }

    # Inserção e criptografia da imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK){
        $tipo = exif_imagetype($_FILES['imagem']['tmp_name']);
    
        if ($tipo !== false){
            // O arquivo é uma imagem
            $imagem_temp = $_FILES['imagem']['tmp_name'];
            $imagem = file_get_contents($imagem_temp);
            $imagem_base64 = base64_encode($imagem);
        } else{
            // O arquivo não é uma imagem
            $imagem = file_get_contents (".\\img\\alert.png");
            $imagem_base64 = base64_encode($imagem);
        }
    } else{
        // O arquivo não foi enviado
        $imagem = file_get_contents (".\\img\\alert.png");
        $imagem_base64 = base64_encode($imagem);
    }    

    if($cont == 1) {
        echo "<script>window.alert('PRODUTO JÁ CADASTRADO!');</script>";
    }
    else{
        $sql = "INSERT INTO produtos (pro_nome, pro_quantidade, pro_valor, pro_descricao, pro_imagem, pro_ativo) 
        VALUES('$nome','$quantidade','$valor','$descricao','$imagem_base64','s')";
        mysqli_query($link, $sql);
        echo "<script>window.alert('PRODUTO CADASTRADO!');</script>";
        echo "<script>window.location.href='cadastraproduto.php';</script>";
    }
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width-device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/style.css">
        <title>CADASTRO DE PRODUTO</title>
    </head>
    <body>
        <div class="cadastraproduto-container">
            <div class="wrapper">
                <form action="cadastraproduto.php" method="post" enctype="multipart/form-data">
                    <h3>Produto</h3>
                    <div class="input-box" id="input-box-name">
                        <input type="text" name="nome" id="nome" placeholder="Nome do Produto">
                    </div>
                    <h3>Quantidade</h3>
                    <div class="input-box" id="input-box-qnt">
                        <input type="number" name="quantidade" id="quantidade" placeholder="Quantidade">
                    </div>
                    <h3>Preço</h3>
                    <div class="input-box" id="input-box-preco">
                        <input type="decimal" name="valor" id="valor" placeholder="R$">
                    </div>
                    <h3>Descrição</h3>
                    <div class="input-box" id="input-box-desc">
                        <!-- <input id ="desc" type="text" name="descricao" id="descricao" placeholder="Descrição"> -->
                        <textarea id="desc" name="descricao" rows="4" cols="50" placeholder="Descrição"></textarea>
                    </div>
                    <h3>Imagem</h3>
                    <div class="input-box" id="input-box-img">
                        <label class="picture" tabIndex="0">
                            <input type="file" accept="*" class="picture-input" name="imagem" id="imagem">
                            <span class="picture-image"></span>
                        </label>
                    </div>
                    <button type="submit" class="btn">Cadastrar</button>
                </form>
            </div>
        </div>
    </body>
</html>

<script>
    const inputFile = 
    document.querySelector('.picture-input');
    const pictureImage =
    document.querySelector('.picture-image');
    const pictureImageTxt = 'Escolha uma imagem';
    pictureImage.innerHTML = pictureImageTxt;

    inputFile.addEventListener("change", function(e) {
        const inputTarget = e.target;
        const file = inputTarget.files[0];

        if (file) {
            const reader = new FileReader();

            reader.addEventListener("load", function(e){
                const readerTarget = e.target;

                const img = document.createElement('img');
                img.src = readerTarget.result;
                img.classList.add('picture-img');
                
                pictureImage.innerHTML = '';
                pictureImage.appendChild(img);
            });

            reader.readAsDataURL(file);
        } else {
            pictureImage.innerHTML = pictureImageTxt;
        }
    });
</script>