<?php
if (isset($_POST['crearProducto'])) {
    // Recoger los datos del formulario
    $idProducto = $_POST['idProducto'];
    $nombreProducto = $_POST['nombreProducto'];
    $precioProducto = $_POST['precioProducto'];
    $disponibilidadProducto = $_POST['disponibilidadProducto'];
    $rutaImagen = $_POST['rutaImagen'];

    // Crear una cadena con los datos separados por ":"
    $productoData = $idProducto . ":" . $nombreProducto . ":" . $precioProducto . ":" . $disponibilidadProducto . ":" . $rutaImagen . PHP_EOL;

    // Abrir el archivo productos.txt en modo append
    $file = fopen(__DIR__ . "/../productos.txt", "a");
    //$file = fopen("/var/www/html/phpEcomProject/productos.txt", "a");
    // Verificar si se abrió correctamente
    if ($file) {
        // Escribir los datos del producto en el archivo
        fwrite($file, $productoData);

        // Cerrar el archivo
        fclose($file);

        // Redirigir o mostrar mensaje de éxito
        echo "Producto creado con éxito!";
    } else {
        echo "Error al abrir el archivo.";
    }
}
?>
