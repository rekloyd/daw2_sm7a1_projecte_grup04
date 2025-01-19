<?php
if (isset($_POST['crearProducto'])) {
    // Recoger los datos del formulario
    $idProducto = $_POST['idProducto'];
    $nombreProducto = $_POST['nombreProducto'];
    $precioProducto = $_POST['precioProducto'];
    $disponibilidadProducto = $_POST['disponibilidadProducto'];
    $rutaImagen = $_POST['rutaImagen'];

    // Crear una cadena con los datos separados por ":"
    $productoData = $idProducto . ":" . $nombreProducto . ":" . $precioProducto . ":" . $disponibilidadProducto . ":" . $rutaImagen  . PHP_EOL;

    // Verificar la ruta del archivo
    $archivoRuta = __DIR__ . "/../productes/productos.txt";
    echo "Ruta del archivo: " . $archivoRuta; // Para verificar la ruta

    // Abrir el archivo productos.txt en modo append
    $file = fopen($archivoRuta, "a");

    // Verificar si se abrió correctamente
    if ($file) {
        // Escribir los datos del producto en el archivo
        fwrite($file, $productoData);

        // Cerrar el archivo
        fclose($file);

        // Redirigir o mostrar mensaje de éxito
        header("Location: ./index.php");
    } else {
        // En caso de error, mostrar el error detallado
        echo "Error al abrir el archivo: " . error_get_last()['message'];
    }
}

if (isset($_POST['modificarProducto'])) {
    $idProducto = $_POST['idProducto'];
    $nuevoNombre = $_POST['nombreProducto'];
    $nuevoPrecio = $_POST['precioProducto'];
    $nuevaDisponibilidad = $_POST['disponibilidadProducto'];
    $nuevaRutaImagen = $_POST['rutaImagen'];

    $file = file(__DIR__ . "/../productes/productos.txt");
    $nuevosDatos = "";
    $productoEncontrado = false;

    foreach ($file as $linea) {
        list($id, $nombre, $precio, $disponibilidad, $rutaImagen) = explode(":", trim($linea));
        if ($id == $idProducto) {
            $linea = $idProducto . ":" . $nuevoNombre . ":" . $nuevoPrecio . ":" . $nuevaDisponibilidad . ":" .$nuevaRutaImagen . PHP_EOL;
            $productoEncontrado = true;
        }
        $nuevosDatos .= $linea . PHP_EOL;
    }

    if ($productoEncontrado) {
        file_put_contents(__DIR__ . "/../productes/productos.txt", $nuevosDatos);
        header("Location: ./index.php");
    } else {
        header("Location: ./index.php");
    }
}

if (isset($_POST['eliminarProducto'])) {
    $idProducto = $_POST['idProducto'];

    $file = file(__DIR__ . "/../productes/productos.txt");
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
        file_put_contents(__DIR__ . "/../productes/productos.txt", $nuevosDatos);
        header("Location: ./index.php");
    } else {
        echo "Error: Producto no encontrado para eliminar.";
    }
}

?>