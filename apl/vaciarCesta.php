<?php
session_start();

// Verificar si el usuario está autenticado
if (isset($_SESSION['cart'])) {
    // Vaciar el carrito
    $_SESSION['cart'] = [];
}

// Redirigir al carrito
header('Location: carrito.php');
exit();
?>
