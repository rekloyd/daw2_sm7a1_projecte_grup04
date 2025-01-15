<?php

session_start();

$_SESSION['tipoUsuario'] =$_GET['tipoUsuario'];


if (isset($_GET['tipoUsuario'])) {
    if ($_GET['tipoUsuario'] === 'gestor') {
        header('Location: gestor.php?tipoUsuario=gestor');
    }if ($_GET['tipoUsuario'] === 'cliente') {
        header('Location: cliente.php?tipoUsuario=cliente');
    } else {
        header('Location: admin.php?tipoUsuario=admin');
    }
} else {
    echo "entrado en el else de isset";
}


