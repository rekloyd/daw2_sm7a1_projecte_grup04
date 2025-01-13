<?php

var_dump($_GET['tipo']);

if (isset($_GET['tipo'])) {
    if ($_GET['tipo'] === 'gestor') {
        header('Location: gestor.php');
    } elseif ($_GET['tipo'] === 'cliente') {
        header('Location: cliente.php');
    } else {
        header('Location: admin.php');
    }
} else {
    echo "entrado en el else de isset";
}


