<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - AliMorillas</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <header>
        <div class="logo">
            <h1>AliMorillas</h1>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="index.html">Inicio</a></li>
                <li><a href="#">Categorías</a></li>
                <li><a href="#">Ofertas</a></li>
                <li><a href="ayuda.html">Ayuda</a></li>
                <li><a href="carrito_compra.html"  style="text-decoration: underline;">Carrito</a></li>
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
                session_start();
                if (isset($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $index => $product) {
                        echo "<div class='cart-item'>";
                        echo "<div class='cart-item-left'>";
                        echo "<img src='https://via.placeholder.com/150' alt='{$product['name']}'>";
                        echo "<div class='cart-item-details'>";
                        echo "<h3>{$product['name']}</h3>";
                        echo "<p class='price'>€{$product['price']}</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "<div class='cart-item-right'>";
                        echo "<label for='quantity-{$index}'>Cantidad</label><br>";
                        echo "<input type='number' id='quantity-{$index}' name='quantity[{$index}]' value='{$product['quantity']}' min='1' class='quantity-selector'>";
                        echo "<button class='cta-button'>Eliminar</button>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No hay productos en el carrito.</p>";
                }
                ?>
            </div>
            <div class="cart-summary text-center">
                <h2>Resumen del Pedido</h2>
                <p>Subtotal: <span class="price">Calculado dinámicamente</span></p>
                <p>Envío: +5€</p>
                <p><strong>Total: <span class="price">Calculado dinámicamente</span></strong></p>
                <br><br>
                <button class="cta-button-pay">Proceder al Pago</button>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 AliMorillas. Todos los derechos reservados.</p>
    </footer>
</body>
</html>