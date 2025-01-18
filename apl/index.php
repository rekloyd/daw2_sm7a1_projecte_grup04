
<?php
session_start();
$usuario = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
$tipoUsuario = isset($_SESSION['tipoUsuario']) ? $_SESSION['tipoUsuario'] : NULL;
$archivo = __DIR__.'/../productes/productos.txt';


// Verificar si el archivo existe
if (file_exists($archivo)) {
    // Leer el contenido del archivo
    $contenido = file_get_contents($archivo);

    // Separar el contenido en líneas
    $lineas = explode("\n", $contenido);
    echo "<img src='/phpEcomProject/imatges/banner-ali.webp' height='720px' width='100%'>";
    echo "<div class='productoOrdenado'>";
    // Recorrer cada línea
    foreach ($lineas as $linea) {
        // Separar los datos por el delimitador ':'
        $datos = explode(':', $linea);

        // Verificar que la línea contiene los datos esperados
        if (count($datos) == 5) {
            // Asignar los datos a variables
            list($id, $nombre, $precio, $disponibilidad, $imagen) = $datos;

            $precio_con_iva = $precio * 1.21;

            echo '<div class="product-card">';
            echo '<img src="' . htmlspecialchars($imagen) . '" alt="' . htmlspecialchars($nombre) . '" class="product-image" style="display:none;">';
            echo '<div class="product-card-body">';
            echo '<h3 class="product-name">' . htmlspecialchars($nombre) . '</h3>';
            echo '<h4>ID: ' . htmlspecialchars($id) . '</h4>';
            echo '<p class="product-price">Precio: ' . number_format($precio, 2) . '€ (+IVA: ' . number_format($precio_con_iva - $precio, 2) . '€)</p>';
            echo '<p class="product-availability">Disponibilidad: ' . htmlspecialchars($disponibilidad) . '</p>';
            echo '<form method="POST" action="añadirCarrito.php" class="product-form">';
            echo '<input type="hidden" name="product_id" value="' . htmlspecialchars($id) . '">';
            echo '<input type="hidden" name="product_name" value="' . htmlspecialchars($nombre) . '">';
            echo '<input type="hidden" name="product_price" value="' . htmlspecialchars($precio) . '">';
            echo '<div class="quantity-container">';
            echo '<label for="quantity_' . htmlspecialchars($id) . '">Cantidad:</label>';
            echo '<input type="number" id="quantity_' . htmlspecialchars($id) . '" name="quantity" value="1" min="1" required class="quantity-input">';
            echo '</div><br>';
            if ($disponibilidad === "No") {
                echo '<button type="submit" name="add_to_cart" class="ctn-btn" disabled>Añadir al carrito</button>';
            } else {
                echo '<button type="submit" name="add_to_cart" class="ctn-btn">Añadir al carrito</button>';
            }            echo '</form>';
            echo '</div>';
            echo '</div>';
        }
    }
    echo "</div>";
} else {
    echo 'El archivo de productos no se encuentra.';
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AliMorillas - Tienda</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="../imatges/favicon.png">

</head>

<body>
<header>

<nav>
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="ayuda.php">Ayuda</a></li>
                <?php
                if ($usuario) {
                    echo "<li style='color:blue; font-weight:bold;'><a href='areasPersonales.php?tipoUsuario=" . htmlspecialchars($tipoUsuario) . "' style='color:inherit;'>Hola, " . strtoupper(htmlspecialchars($usuario)) . "</a></li>";
                    echo "<li><a href='carrito.php' style='display: inline-flex; align-items: center;'>
                <svg xmlns='http://www.w3.org/2000/svg' height='24px' viewBox='0 -960 960 960' width='24px' fill='#e8eaed'>
                    <path d='M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z'/>
                </svg>
            </a></li>";
                    echo "<li><a href='logout.php' class='log-in'>Cerrar sesión</a></li>";
                } else {
                    echo "<li style='margin-right:5px;'><a href='login.html' class='log-in'>Log In</a></li>";
                }
                ?>
            </ul>
        </nav>

    </header>

</body>

</html>
