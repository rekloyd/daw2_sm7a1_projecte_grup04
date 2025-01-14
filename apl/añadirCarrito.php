<?php
session_start();

// Comprobamos si se ha recibido la solicitud mediante POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperamos los datos del producto desde el formulario
    $product = [
        'name' => $_POST['name'],
        'id' => $_POST['id'],
        'price' => $_POST['price'],
        'quantity' => 1 // Inicializamos la cantidad en 1 por defecto
    ];

    // Comprobamos si el carrito ya existe en la sesión
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // Inicializamos el carrito si no existe
    }

    // Verificamos si el producto ya está en el carrito
    $productExists = false;
    foreach ($_SESSION['cart'] as &$cartItem) {
        if ($cartItem['id'] === $product['id']) {
            $cartItem['quantity'] += 1; // Incrementamos la cantidad
            $productExists = true;
            break;
        }
    }

    // Si el producto no estaba en el carrito, lo agregamos
    if (!$productExists) {
        $_SESSION['cart'][] = $product;
    }

    // Redirigimos al usuario de vuelta al carrito
    header('Location: carrito.php');
    exit;
}
?>
