<?php
include("cabecalho2.php");
//*RECEBE O PRODUTO QUE O USUÁRIO QUER FAVORITAR
$id = $_GET['id'];
//*VERIFICA SE O USUÁRIO ESTÁ LOGADO
if(isset($idusuario)){
    //*VERIFICAÇÃO SE JÁ ESTÁ FAVORITADO, CASO JÁ ESTEJA REMOVA
    $sql = "SELECT COUNT(fav_id) FROM favoritos WHERE fav_cli_id = $idusuario AND fav_pro_id = $id";
    $retorno = mysqli_query($link,$sql);

    while($tbl = mysqli_fetch_array($retorno)) {
        $cont = $tbl[0];
        if($cont == 0) {
            $sql = "INSERT INTO favoritos (fav_cli_id, fav_pro_id) VALUES($idusuario, $id)";
            mysqli_query($link, $sql);
        } else {
            $sql = "DELETE FROM favoritos WHERE fav_cli_id = $idusuario AND fav_pro_id = $id";
            mysqli_query($link, $sql);
        }
    }
}else {
    echo "<script>window.alert('FAÇA LOGIN PARA FAVORITAR');</script>";
    header("Location: logincliente.php");
}
header("Location: verproduto.php?id=$id");
exit;
?>