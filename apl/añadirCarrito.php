<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreProducto = $_POST['name'];
    $idProducto = $_POST['id'];
    $precioProducto = $_POST['price'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][] = [
        'nombre' => $nombreProducto,
        'id' => $idProducto,
        'precio' => $precioProducto
    ];

    header("Location: index.php");
    exit();
}
?>
