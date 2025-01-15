<?php
session_start();
date_default_timezone_set('Europe/Madrid');

// Inicialización del carrito si no existe
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$usuario = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
$tipoUsuario = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : NULL;
$cart_empty = count($_SESSION['cart']) == 0;

// Verificar si ya existe un archivo con la cesta guardada
$filename = __DIR__ . '/../cesta.txt';

// Cargar la cesta guardada en la sesión si existe
if ($usuario && file_exists($filename)) {
    $file = fopen($filename, 'r'); // Abrir el archivo para lectura

    if ($file) {
        // Leer el contenido del archivo línea por línea
        while (($line = fgets($file)) !== false) {
            $data = explode(':', trim($line));

            if (count($data) == 5 && $data[4] == $usuario) {
                // Si la línea contiene datos válidos y corresponde al usuario
                // Formato esperado: id:producto:cantidad:Si:usuario
                $id = $data[0];
                $name = $data[1];
                $quantity = $data[2];

                // Agregar el producto a la cesta de la sesión si no está ya
                if (!isset($_SESSION['cart'][$id])) {
                    $_SESSION['cart'][$id] = [
                        'name' => $name,
                        'quantity' => $quantity
                    ];
                }
            }
        }

        fclose($file); // Cerrar el archivo
    } else {
        echo "Error al leer la cesta guardada.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - AliMorillas</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <div class="logo">
            <h1>AliMorillas</h1>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="ayuda.php">Ayuda</a></li>
                <?php if ($usuario): ?>
                    <li style="color:blue; font-weight:bold;">
                        <a href="areasPersonales.php?tipo=<?php echo htmlspecialchars($tipoUsuario); ?>" style="color:inherit;">Hola, <?php echo strtoupper(htmlspecialchars($usuario)); ?></a>
                    </li>
                    <li>
                        <a href="carrito.php" style="display: inline-flex; align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                                <path d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z" />
                            </svg>
                        </a>
                    </li>
                    <li><a href="logout.php" class="log-in">Cerrar sesión</a></li>
                <?php else: ?>
                    <li><a href="login.html" class="log-in">Log In</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <main>
        <div class="banner">
            <h2>Tu Carrito</h2>
            <p>Revisa los productos que has añadido antes de completar tu compra.</p>
        </div>
        <section class="cart-container">
            <div class="cart-items">
                <h2>Productos en tu carrito</h2>
                <?php
                $subtotal_without_tax = 0;

                if (!$usuario) {
                    echo "<p><b>Debe iniciar sesión antes.</b></p>";
                } elseif (!$cart_empty) {
                    foreach ($_SESSION['cart'] as $id => $product) {
                        $price_without_tax = $product['price'] * $product['quantity'];
                        $price_with_tax = $price_without_tax * 0.21;
                        $subtotal_without_tax += $price_without_tax;

                        echo "<div class='cart-item'>";
                        echo "<div class='cart-item-left'>";
                        echo "<div class='cart-item-details'>";
                        echo "<h3>{$product['name']}</h3>";
                        echo "<p class='price'>" . number_format($price_without_tax, 2) . "€ + " . number_format($price_with_tax, 2) . " IVA</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='cart-item-right'>";
                        echo "<p>Cantidad: <span class='quantity-selector'>{$product['quantity']}</span></p>";
                        echo "<form method='POST' action='eliminarDeCarrito.php' style='display:inline;'>";
                        echo "<input type='hidden' name='id' value='{$id}'>";
                        echo "<button type='submit' class='cta-button'>Eliminar</button>";
                        echo "</form>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No hay productos en el carrito.</p>";
                }
                ?>

                <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'cesta_guardada'): ?>
                    <p>¡Cesta guardada correctamente!</p>
                <?php endif; ?>
                <form method="POST" action="guardarCesta.php">
                    <button type="submit" class="cta-button" <?php echo $cart_empty ? 'disabled' : ''; ?>>Guardar Cesta</button>
                </form>

            </div>
            <div class="cart-summary text-center">
                <h2>Resumen del Pedido</h2>
                <p>Subtotal (sin IVA): <span id="subtotal" class="price"><?php echo number_format($subtotal_without_tax, 2); ?></span>€</p>
                <p>IVA (21%): <span class="price"><?php echo number_format($subtotal_without_tax * 0.21, 2); ?>€</span></p>
                <p>Envío: +5€</p>
                <p><strong>Total: <span id="total" class="price"><?php echo number_format($subtotal_without_tax * 1.21 + 5, 2); ?>€</span></strong></p>
                <form method="POST" action="factura.php">
                    <?php foreach ($_SESSION['cart'] as $id => $product): ?>
                        <input type="hidden" name="products[<?php echo $id; ?>][id]" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="products[<?php echo $id; ?>][name]" value="<?php echo $product['name']; ?>">
                        <input type="hidden" name="products[<?php echo $id; ?>][price]" value="<?php echo $product['price']; ?>">
                    <?php endforeach; ?>
                    <button type="submit" class="cta-button-pay" <?php echo $cart_empty ? 'disabled' : ''; ?>>Proceder al Pago</button>
                </form>
            </div>
        </section>

        <!-- Ver cestas guardadas -->
        <section class="saved-carts">
            <h2>Cestas Guardadas</h2>
            <?php
            if ($usuario && file_exists($filename)) {
                $file = fopen($filename, 'r');
                if ($file) {
                    echo "<ul>";
                    while (($line = fgets($file)) !== false) {
                        $data = explode(':', trim($line));
                        if (count($data) == 5 && $data[4] == $usuario) {
                            echo "<li>Cesta: {$data[1]}, Cantidad: {$data[2]}</li>";
                        }
                    }
                    echo "</ul>";
                    fclose($file);
                }
            }
            ?>
            <?php if ($usuario): ?>
                <p><a href="vaciarCesta.php" class="vaciar-cesta">Vaciar cesta</a></p>
            <?php endif; ?>

        </section>
    </main>

    <footer>
        <p>&copy; 2024 AliMorillas. Todos los derechos reservados.</p>
    </footer>
</body>

</html>