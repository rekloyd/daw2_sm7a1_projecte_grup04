<?php
session_start();
$usuario = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;

// Verificar si el usuario está logueado
if (!$usuario || !isset($_POST['cesta'])) {
    echo "<p>Error: Usuario no logueado o no se seleccionó una cesta.</p>";
    exit;
}

// Recuperar el ID de la cesta seleccionada
$cesta_id = $_POST['cesta'];

// Leer el archivo y restaurar la cesta seleccionada
$filename = __DIR__.'/../cesta.txt';
if (file_exists($filename)) {
    $file = fopen($filename, 'r');
    while (($line = fgets($file)) !== false) {
        $data = explode(':', trim($line));
        if (count($data) == 5 && $data[4] == $usuario && $data[0] == $cesta_id) {
            // Restaurar los productos del carrito de la cesta seleccionada
            $_SESSION['cart'][$data[0]] = [
                'name' => $data[1],
                'quantity' => $data[2]
            ];
        }
    }
    fclose($file);
}

// Redirigir al carrito para ver los productos restaurados
header('Location: carrito.php');
exit;
?>
