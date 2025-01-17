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
    if ($file) {
        // Escribir los datos del producto en el archivo
        fwrite($file, $productoData);

        // Cerrar el archivo
        fclose($file);

        // Redirigir o mostrar mensaje de éxito
        header("Location: ./index.php");
        exit();
    } else {
        echo "Error al abrir el archivo.";
    }
}

if (isset($_POST['modificarProducto'])) {
    $idProducto = $_POST['idProducto'];
    $nuevoNombre = $_POST['nombreProducto'];
    $nuevoPrecio = $_POST['precioProducto'];
    $nuevaDisponibilidad = $_POST['disponibilidadProducto'];
    $nuevaRutaImagen = $_POST['rutaImagen'];

    $file = file(__DIR__ . "/../productos.txt");
    $nuevosDatos = "";
    $productoEncontrado = false;

    foreach ($file as $linea) {
        list($id, $nombre, $precio, $disponibilidad, $rutaImagen) = explode(":", trim($linea));
        if ($id == $idProducto) {
            $linea = $idProducto . ":" . $nuevoNombre . ":" . $nuevoPrecio . ":" . $nuevaDisponibilidad . ":" . $nuevaRutaImagen;
            $productoEncontrado = true;
        }
        $nuevosDatos .= $linea . PHP_EOL;
    }

    if ($productoEncontrado) {
        file_put_contents(__DIR__ . "/../productos.txt", $nuevosDatos);
        header("Location: ./index.php");
    } else {
        header("Location: ./index.php?error=Producto no encontrado para modificar");
    }
    exit();
}

if (isset($_POST['eliminarProducto'])) {
    $idProducto = $_POST['idProducto'];

    $file = file(__DIR__ . "/../productos.txt");
    $nuevosDatos = "";
    $productoEncontrado = false;

    foreach ($file as $linea) {
        list($id, $nombre, $precio, $disponibilidad, $rutaImagen) = explode(":", trim($linea));
        if ($id == $idProducto) {
            $productoEncontrado = true;
            continue; // Saltar la línea del producto a eliminar
        }
        $nuevosDatos .= $linea . PHP_EOL;
    }

    if ($productoEncontrado) {
        file_put_contents(__DIR__ . "/../productos.txt", $nuevosDatos);
        header("Location: ./index.php");
    } else {
        echo "Error: Producto no encontrado para eliminar.";
    }
    exit();
}
?>
