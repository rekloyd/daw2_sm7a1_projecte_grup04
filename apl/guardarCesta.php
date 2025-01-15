<?php
session_start();

$usuario = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
$cart_empty = count($_SESSION['cart']) == 0;

if (!$usuario || $cart_empty) {
    // Si no hay usuario o el carrito está vacío, redirigir a la página del carrito
    header('Location: carrito.php');
    exit;
}

$filename = __DIR__.'/../cesta.txt';

try {
    $file = fopen($filename, 'a'); // Intentar abrir el archivo para añadir datos al final

    if (!$file) {
        throw new Exception("Error al abrir el archivo para escribir.");
    }

    // Recorrer el carrito y escribir los datos
    foreach ($_SESSION['cart'] as $id => $product) {
        $line = "{$id}:{$product['name']}:{$product['quantity']}:Si:{$usuario}\n";
        fwrite($file, $line);  // Escribir en el archivo
    }

    fclose($file); // Cerrar el archivo

    // Redirigir de nuevo al carrito o a una página de éxito
    header('Location: carrito.php?mensaje=cesta_guardada');
    exit;

} catch (Exception $e) {
    // Capturar cualquier excepción y mostrar el mensaje de error
    echo "Error: " . $e->getMessage();
}
?>
