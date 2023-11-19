<?php
include("conectadb.php");
session_start();
isset($_SESSION['nomeusuario'])?$nomeusuario = $_SESSION['nomeusuario']: "";
$nomeusuario = $_SESSION['nomeusuario'];

?>
<link rel="stylesheet" href="./css/style.css">
<nav>
    <div class="nav-container">
        <ul>
            <li><a href="cadastrausuario.php">Cadastrar usuário</a></li>
            <li><a href="listausuario.php">Listar usuário</a></li>
            <li><a href="cadastraproduto.php">Cadastrar produto</a></li>
            <li><a href="listaproduto.php">Listar produto</a></li>
            <!-- <li><a href="listacliente.php">LISTAR CLIENTES</a></li>
            <li><a href="vendas.php">VENDAS</a></li>  -->
        </ul>
        <ul class="user-info">
            <li id="btn-sair"><a href="logout.php">Sair</a></li>
            <!--VALIDA SE SESSÃO DE USUARIO ESTÁ AUTENTICADA, SENÃO, RETORNA PARA LOGIN -->
            <?php
            if($nomeusuario != null) {
            ?>
            <li><p>Olá <?= $nomeusuario ?></p></li>
            <?php
            } else {
                echo "<script>window.alert('USUÁRIO NÃO AUTENTICADO');
                window.location.href='login.php';</script>";
            }
            ?>
        </ul>
    </div>
</nav>



