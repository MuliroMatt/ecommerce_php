<?php
include("cabecalho.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $nome = trim($nome);
    $descricao = $_POST['descricao'];
    $descricao = trim($descricao);
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];
    $ativo = $_POST['ativo'];
    $categoria = $_POST['categoria'];

    // Verifica se um novo arquivo foi enviado
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagem_temp = $_FILES['imagem']['tmp_name'];
        $imagem = file_get_contents($imagem_temp);
        $imagem_base64 = base64_encode($imagem);
    }

    // Atualiza os dados no banco de dados
    $sql = "UPDATE produtos SET pro_nome = '$nome', pro_quantidade = '$quantidade', pro_valor = '$valor', pro_descricao = '$descricao', 
        pro_ativo = '$ativo', pro_categoria = '$categoria'";
    
    // Adiciona a atualização da imagem à consulta, caso uma nova imagem tenha sido enviada
    if (isset($imagem_base64)) {
        $sql .= ", pro_imagem = '$imagem_base64'";
    }

    $sql .= " WHERE pro_id = $id";

    mysqli_query($link, $sql);

    echo "<script>window.alert('Produto alterado com sucesso!');</script>";
    echo "<script>window.location.href='listaproduto.php';</script>";
}

$id = $_GET['id'];
$sql = "SELECT * FROM produtos WHERE pro_id = '$id'";
$retorno = mysqli_query($link, $sql);

while ($tbl = mysqli_fetch_array($retorno)) {
    $nome = $tbl[1];
    $descricao = $tbl[2];
    $quantidade = $tbl[3];
    $valor = $tbl[4];
    $imagem = $tbl[5];
    $ativo = $tbl[6];
    $categoria = $tbl[7];
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/style.css">
        
        <title>ALTERA PRODUTO</title>
    </head>
    <body>
        <div class="alteraproduto-container">
            <div class="wrapper">
                <form action="alteraproduto.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?=$id ?>">
                    <h3>Produto</h3>
                    <div class="input-box" id="input-box-name">
                        <input type="text" name="nome" id="nome" value="<?=$nome?>">
                    </div>
                    <h3>Descrição</h3>
                    <div class="input-box" id="input-box-desc">
                        <!-- <input id ="desc" type="text" name="descricao" id="descricao" placeholder="Descrição"> -->
                        <textarea id="desc" name="descricao" rows="4" cols="50" placeholder="Descrição"><?=$descricao?></textarea>
                    </div>
                    <h3>Preço</h3>
                    <div class="input-box" id="input-box-preco">
                        <input type="decimal" name="valor" id="valor" value="<?=$valor?>">
                    </div>
                    <h3>Quantidade</h3>
                    <div class="input-box" id="input-box-qnt">
                        <input type="number" name="quantidade" id="quantidade" value="<?=$quantidade?>">
                    </div>
                    <h3>Categoria</h3>
                    <div class="input-box" id="input-box-cat">
                        <select type="select" name="categoria" id="categoria" placeholder="Categoria">
                            <option value="Vestuario">Vestuário</option>
                            <option value="Calcados">Calçados</option>
                            <option value="Equipamentos">Equipamentos</option>
                            <option value="Acessorios">Acessórios</option>
                        </select>
                    </div>
                    <h3>Imagem Atual</h3>
                    <img src="data:image/png;base64,<?= $imagem ?>">
                    <h3>Nova Imagem</h3>
                    <div class="input-box" id="input-box-img">
                        <label class="picture" tabIndex="0">
                            <input type="file" accept="*" class="picture-input" name="imagem" id="imagem">
                            <span class="picture-image"></span>
                        </label>
                    </div>
                    <h3>Status: <?= $check = ($ativo == 's') ? "Ativo" : "Inativo" ?></h3>
                    <div  id="form-container">
                        <input type="radio" name="ativo" class="radio" value="s" id="radioativo"
                        <?= $ativo == 's' ? "checked" : "" ?>>
                        <label class="radio-label" for="radioativo">Ativo</label>
                        <input type="radio" name="ativo" class="radio" value="n" id="radioinativo"
                        <?= $ativo == 'n' ? "checked" : "" ?>>
                        <label class="radio-label" for="radioinativo">Inativo</label>
                    </div>
                    <button type="submit" class="btn">Alterar</button>
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

