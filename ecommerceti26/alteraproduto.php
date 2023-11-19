<?php
include("cabecalho.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $nome = trim($nome);
    $nome = mb_strtoupper($nome, 'UTF-8');
    $descricao = $_POST['descricao'];
    $descricao = trim($descricao);
    $descricao = strtolower($descricao);
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];
    $ativo = $_POST['ativo'];

    // Verifica se um novo arquivo foi enviado
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $imagem_temp = $_FILES['imagem']['tmp_name'];
        $imagem = file_get_contents($imagem_temp);
        $imagem_base64 = base64_encode($imagem);
    }

    // Atualiza os dados no banco de dados
    $sql = "UPDATE produtos SET pro_nome = '$nome', pro_quantidade = '$quantidade', pro_valor = '$valor', pro_descricao = '$descricao', 
        pro_ativo = '$ativo'";
    
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
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estiloadm.css">
    <title>ALTERA PRODUTO</title>
</head>
<body>
    <div>
        <form action="alteraproduto.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$id ?>">
            <label>NOME</label>
            <input type="text" name="nome" value="<?=$nome ?>" required>
            <label>QUANTIDADE</label>
            <input type="number" name="quantidade" value="<?=$quantidade ?>" required>
            <label>VALOR</label>
            <input type="decimal" name="valor" value="<?=$valor ?>" required>
            <label>DESCRIÇÃO</label>
            <input type="text" name="descricao" value="<?=$descricao ?>" required>
            <label>IMAGEM ATUAL</label>
            <img width="70px" src="data:image/png;base64,<?= $imagem ?>">
            <label>NOVA IMAGEM</label>
            <input type="file" name="imagem">
            <p></p>
            <label>STATUS: <?= $check = ($ativo == 's') ? "ATIVO" : "INATIVO" ?></label>
            <p></p>
            <input type="radio" name="ativo" value="s" <?= $ativo == "s" ? "checked" : "" ?>>ATIVO<br>
            <input type="radio" name="ativo" value="n" <?= $ativo == "n" ? "checked" : "" ?>>INATIVO<br>
            <input type="submit" value="SALVAR">
        </form>
    </div>
</body>
</html>
