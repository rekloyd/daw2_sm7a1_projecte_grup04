<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProducto = $_POST['product_id'];
    $nombreProducto = $_POST['product_name'];
    $precioProducto = $_POST['product_price'];
    $cantidad = $_POST['quantity'];

    // Inicializar el carrito si no existe
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Verificar si el producto ya está en el carrito
    if (isset($_SESSION['cart'][$idProducto])) {
        // Incrementar la cantidad
        $_SESSION['cart'][$idProducto]['quantity'] += $cantidad;
    } else {
        // Añadir el producto al carrito
        $_SESSION['cart'][$idProducto] = [
            'name' => $nombreProducto,
            'price' => $precioProducto,
            'quantity' => $cantidad
        ];
    }

    // Redirigir al usuario de vuelta a la página principal
    header("Location: index.php");
    exit();
}
?>
