<?php
    session_start(); //*INICIA A SESSÃO

    //*DESTROI A SESSÃO ATUAL
    session_destroy();

    //*REDIRECIONA O USUÁRIO PARA A PÁGINA DE LOGIN
    header("Location: login.php");
    exit;
?>