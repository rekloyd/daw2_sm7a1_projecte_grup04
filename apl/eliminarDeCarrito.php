<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    // Verificar si el carrito existe en la sesión y si el producto está en el carrito
    if (isset($_SESSION['cart']) && array_key_exists($id, $_SESSION['cart'])) {
        unset($_SESSION['cart'][$id]);
    }

    // Redirigir de vuelta al carrito
    header("Location: carrito.php");
    exit();
}
?>
