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

<link rel="stylesheet" href="./css/style2.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <header>
        <div class="header-container">
            <div class="content-left">
                <div class="logo">
                    <a href="loja.php">
                        <h1>AceStore</h1>
                    </a>
                </div>
                <div class="search">
                    <input type="text" class="search__input" placeholder="O que você procura?">
                    <button class="search__button">
                        <svg class="search__icon" aria-hidden="true" viewBox="0 0 24 24">
                            <g>
                                <path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path>
                            </g>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="content-right">
                <?php
                if($nomeusuario != ""){
                ?>
                    <div class="user-actions">
                        <div class="dropdown">
                            <a href="perfil.php?id=<?= ($idusuario) ?>"><i class='bx bx-user-circle'></i>Olá, <?=$nomeusuario?></a>
                            <div class="content">
                                <a href="perfil.php?id=<?= ($idusuario) ?>"><i class='bx bx-user'></i>Perfil</a>
                                <a href="favoritos.php?id=<?= ($idusuario) ?>"><i class='bx bx-heart'></i>Favoritos</a>
                                <a href="carrinho.php?id=<?= ($idusuario) ?>"><i class='bx bx-cart'></i>Carrinho</a>
                                <a href="logoutcliente.php"><i class='bx bx-exit'></i>Sair</a>
                            </div>
                        </div>
                    </div>
                    <div class="icon-actions">
                        <a href="favoritos.php?id=<?= ($idusuario) ?>"><i class='bx bx-heart'></i></a>
                        <a href="carrinho.php?id=<?= ($idusuario) ?>"><i class='bx bx-cart'></i></a>
                    </div>
                <?php
                }else {
                ?>
                    <div class="user-actions">
                        <a href="logincliente.php"><i class='bx bx-user-circle'></i>Entre ou cadastre-se</a>
                    </div>
                    <div class="icon-actions">
                        <a href="logincliente.php?id=<?= ($idusuario) ?>"><i class='bx bx-heart'></i></a>
                        <a href="logincliente.php?id=<?= ($idusuario) ?>"><i class='bx bx-cart'></i></i></a>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </header>
    <nav>
        <div class="nav-container">
            <ul>
                <li><a href="#">Masculino</a></li>
                <li><a href="#">Feminino</a></li>
                <li><a href="#">Roupas</a></li>
                <li><a href="#">Calçados</a></li>
                <li><a href="#">Acessórios</a></li>
                <li><a href="#">Equipamentos</a></li>
                <li><a href="#">Esportes</a></li>
            </ul>
        </div>
    </nav>

