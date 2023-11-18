<?php
include("conectadb.php");
session_start();
if (isset($_SESSION['nomeusuario'])) {
    $nomeusuario = $_SESSION['nomeusuario'];
    $idusuario = $_SESSION['idusuario'];
}else{
    $nomeusuario = "";
}
?>

<link rel="stylesheet" href="./css/style.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<nav>
    <div class="nav-container">
        <ul>
            <li><a href="loja.php">Home</a></li>
            
        </ul>
        <ul class="user-info">
            <?php
            if($nomeusuario != ""){
            ?>
            <li><a href="logoutcliente.php">Sair</a></li>
            <li><a href="perfil.php?id=<?= ($idusuario) ?>">Olá <?=$nomeusuario?></a></li>
            <li><a href="carrinho.php?id=<?= ($idusuario) ?>"><i class='bx bxs-cart'></i></a></li>
            <?php
            }else {
            ?>
                <li><a href="logincliente.php">Login</a></li>
            <?php
            }
            ?>
        </ul>
    </div>
</nav>
