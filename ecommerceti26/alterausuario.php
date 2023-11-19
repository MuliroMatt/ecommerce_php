<?php
include("cabecalho.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $nome = trim($nome);
    $ativo = $_POST['ativo'];
    $senha = $_POST['senha'];

    $sql = "SELECT usu_tempero  FROM usuarios WHERE usu_nome = '$nome'";
    $retorno = mysqli_query($link, $sql);
    while ($tbl = mysqli_fetch_array($retorno)) {
        $tempero = $tbl[0];
    }
    if ( $senha != $senha2)
    {
        $senha = md5($senha . $tempero);
    }

    $sql = "UPDATE usuarios SET usu_senha = '$senha', usu_nome = '$nome', usu_ativo = '$ativo' WHERE usu_id = $id";

    mysqli_query($link, $sql);

    echo "<script>window.alert('USUÁRIO ALTERADO COM SUCESSO!');</script>";
    echo "<script>window.location.href='listausuario.php';</script>";
    exit();
}

$id = $_GET['id'];
$sql = "SELECT * FROM usuarios WHERE usu_id = '$id'";
$retorno = mysqli_query($link, $sql);

while ($tbl = mysqli_fetch_array($retorno)) {
    $nome = $tbl[1];
    $senha = $tbl[2];
    $ativo = $tbl[3];
    #$tempero = $tbl[4];
    $senha2 = $senha;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/style.css">
        <title>ALTERA USUÁRIO</title>
    </head>
    <body>
        <div class="alterausuario-container">
            <div class="wrapper">
                <form action="alterausuario.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?=$id ?>">
                    <h3>Nome</h3>
                    <div class="input-box" id="input-box-name">
                        <input type="text" name="nome" id="nome" value="<?=$nome?>">
                    </div>
                    <h3>Senha</h3>
                    <div class="input-box" id="input-box-password">
                        <input type="password" name="senha" id="senha" placeholder="********" value="<?=$senha?>">
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
                    <button type="submit" class="btn">Cadastrar</button>
                </form>
            </div>
        </div>
    </body>
</html>