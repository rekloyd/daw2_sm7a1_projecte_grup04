<?php

var_dump($_GET['tipo']);

if (isset($_GET['tipo'])) {
    if ($_GET['tipo'] === 'gestor') {
        echo "hola gestor";
    } elseif ($_GET['tipo'] === 'cliente') {
        echo "hola cliente";
    } else {
        echo "error";
    }
} else {
    echo "entrado en el else de isset";
}
?>
