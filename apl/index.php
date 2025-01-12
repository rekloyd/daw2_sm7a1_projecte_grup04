<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AliMorillas</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>

<?php
session_start();

// Verificar si existe la clave 'username' en la sesión
$usuario = isset($_SESSION['username']) ? $_SESSION['username'] : null;
?>

<body>
    <header>
        <div class="logo">
            <h1>AliMorillas</h1>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="index.html" style="text-decoration: underline;">Inicio</a></li>
                <li><a href="#">Categorías</a></li>
                <li><a href="#">Ofertas</a></li>
                <li><a href="ayuda.html">Ayuda</a></li>
                <li><a href="carrito_compra.html">Carrito</a></li>
                <?php
                    if ($usuario) {
                        echo "<li style=\"color:blue; font-weight:bold;\">Hola, " . strtoUpper(htmlspecialchars($usuario)) . "</li>";
                        echo "<li><a href='logout.php' class='log-in'>Cerrar sesión</a></li>";
                    } else {
                        echo "<li><a href='signup.html' class='sign-up' style='color: #333;'>Sign Up</a></li>";
                        echo "<li><a href='login.html' class='log-in'>Log In</a></li>";
                    }
                ?>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Banner principal -->
        <section class="banner">
            <h2>¡Grandes ofertas del día!</h2>
            <p>Descuentos increíbles en miles de productos</p>
            <a href="#" class="cta-button">Explorar ahora</a>
        </section>

        <!-- Productos -->
        <section class="products">
            <h2>Productos destacados</h2>
            <div class="product-grid">
                <!-- Producto 1 -->
                <div class="product-card">
                    <img src="https://via.placeholder.com/150" alt="Producto 1">
                    <h3>Producto 1</h3>
                    <p>ID: 001</p>
                    <p class="price">€19.99 (+ IVA)</p>
                    <p class="availability">Disponibilidad: Sí</p>
                </div>
                <!-- Producto 2 -->
                <div class="product-card">
                    <img src="https://via.placeholder.com/150" alt="Producto 2">
                    <h3>Producto 2</h3>
                    <p>ID: 002</p>
                    <p class="price">€29.99 (+ IVA)</p>
                    <p class="availability">Disponibilidad: No</p>
                </div>
                <!-- Producto 3 -->
                <div class="product-card">
                    <img src="https://via.placeholder.com/150" alt="Producto 3">
                    <h3>Producto 3</h3>
                    <p>ID: 003</p>
                    <p class="price">€39.99 (+ IVA)</p>
                    <p class="availability">Disponibilidad: Sí</p>
                </div>
                <!-- Producto 4 -->
                <div class="product-card">
                    <img src="https://via.placeholder.com/150" alt="Producto 4">
                    <h3>Producto 4</h3>
                    <p>ID: 004</p>
                    <p class="price">€49.99 (+ IVA)</p>
                    <p class="availability">Disponibilidad: No</p>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 AliMorillas. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
