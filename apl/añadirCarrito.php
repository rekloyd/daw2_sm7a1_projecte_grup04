<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = [
        'name' => $_POST['name'],
        'id' => $_POST['id'],
        'price' => $_POST['price'],
        'quantity' => 1
    ];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $_SESSION['cart'][] = $product;
    header("Location: carrito.php");
}
?>
