<?php
include("cabecalho.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];
    $imagem = $_POST['imagem'];
    $ativo = $_POST['ativo'];

    $sql = "UPDATE produtos SET pro_nome = '$nome', pro_descricao = '$descricao', pro_quantidade = '$quantidade',
    pro_valor = '$valor', pro_imagem = '$imagem', pro_ativo = '$ativo' WHERE pro_id = $id";

    mysqli_query($link, $sql);

    echo "<script>window.alert('PRODUTO ALTERADO COM SUCESSO!');</script>";
    echo "<script>window.location.href='listaproduto.php';</script>";
    exit();
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
    <div>
        <form action="alteraproduto.php" method="post">
            <input type="hidden" name="id" value="<?=$id ?>">
            <label>NOME</label>
            <input type="text" name="nome" value="<?=$nome ?>" required>
            <label>QUANTIDADE</label>
            <input type="number" name="quantidade" value="<?=$quantidade ?>" required>
            <label>VALOR</label>
            <input type="decimal" name="valor" value="<?=$valor ?>" required>
            <label>DESCRIÇÃO</label>
            <input type="text" name="descricao" value="<?=$descricao ?>" required>
            <label>IMAGEM</label>
            <input type="file" name="imagem" value="<?=$imagem ?>">
            <p></p>
            <label>STATUS: <?= $check = ($ativo == 's') ? "ATIVO" : "INATIVO" ?></label>
            <p></p>
            <input type="radio" name="ativo" value="s"
            <?= $ativo == "s" ? "checked" : "" ?>>ATIVO<br>
            <input type="radio" name="ativo" value="n"
            <?= $ativo == "n" ? "checked" : "" ?>>INATIVO<br>

            <input type="submit" value="SALVAR">
        </form>
    </div>>
</html>