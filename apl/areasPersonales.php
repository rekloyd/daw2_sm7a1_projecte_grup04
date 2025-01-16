<?php

session_start();

$_SESSION['tipoUsuario'];

//echo $_SESSION['tipoUsuario'];


if (isset($_SESSION['tipoUsuario'])) {
    if ($_SESSION['tipoUsuario'] === 'gestor') {
        header('Location: gestor.php');
    }if ($_SESSION['tipoUsuario'] === 'cliente') {
        header('Location: cliente.php');
    }if($_SESSION['tipoUsuario'] === 'admin') {
        header('Location: admin.php');
    }
} else {
    echo "entrado en el else de isset";
}



?>
