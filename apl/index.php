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
$usuario = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
$tipoUsuario = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : NULL;
?>

<body>
    <header>
        <div class="logo">
            <h1>AliMorillas</h1>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php" style="text-decoration: underline;">Inicio</a></li>
                <li><a href="ayuda.php">Ayuda</a></li>
                <li><a href="carrito.php">Carrito</a></li>
                <?php
                    if ($usuario) {
                        echo "<li style=\"color:blue; font-weight:bold;\"><a href='areasPersonales.php?tipo=" . $tipoUsuario . "' style='color:inherit;'>Hola, " . strtoupper(htmlspecialchars($usuario)) . "</a></li>";

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
        <div>
            <img src="../imatges/banner.webp" height="600px" width="100%">
        </div>
    <h2 style="text-align: center;">Productos destacados</h2>
        <section class="products" style="display: flex;gap: 8px;">

                    <!-- Producto 1 -->
                    <div class="product-grid">
                <div class="product-card">
                    <img src="../imatges/p1.jpg" height="115px" width="240px" alt="Producto 1">
                    <h3>Cepillo para perros con pelo, pelaje largo, cachorros</h3>
                    <p>ID: 1</p>
                    <p class="price">€27 (+ IVA)</p>
                    <p class="availability">Disponibilidad: Si</p>
                    <form action="añadirCarrito.php" method="POST">
                        <input type="hidden" name="name" value="Cepillo para perros con pelo, pelaje largo, cachorros">
                        <input type="hidden" name="id" value="2">
                        <input type="hidden" name="price" value="27">
                        <button type="submit">Agregar a la cesta</button>
                    </form>
                </div>
            </div>


                <!-- Producto 2 -->
                <div class="product-grid">
                <div class="product-card">
                    <img src="../imatges/p2.jpg" height="115px" width="240px" alt="Producto 4">
                    <h3>iPad Mini 16GB - Reacondicionado Shenzhen</h3>
                    <p>ID: 2</p>
                    <p class="price">€107 (+ IVA)</p>
                    <p class="availability">Disponibilidad: Si</p>
                    <form action="añadirCarrito.php" method="POST">
                        <input type="hidden" name="name" value="iPad Mini 16GB - Reacondicionado Shenzhen">
                        <input type="hidden" name="id" value="2">
                        <input type="hidden" name="price" value="107">
                        <button type="submit" disabled>Agregar a la cesta</button>
                    </form>
                </div>
            </div>

        <!-- Producto 3 -->
            <div class="product-grid">
                <div class="product-card">
                    <img src="../imatges/p3.avif" width="240px" alt="Producto 4">
                    <h3>Reloj Inalámbrico medidor de pulsaciones, dormir bien</h3>
                    <p>ID: 3</p>
                    <p class="price">€49.99 (+ IVA)</p>
                    <p class="availability">Disponibilidad: Si</p>
                    <form action="añadirCarrito.php" method="POST">
                        <input type="hidden" name="name" value="Reloj Inalámbrico medidor de pulsaciones, dormir bien">
                        <input type="hidden" name="id" value="3">
                        <input type="hidden" name="price" value="49.99">
                        <button type="submit">Agregar a la cesta</button>
                    </form>
                </div>
            </div>


            <div class="product-grid">
                <!-- Producto 4 -->
                <div class="product-card">
                    <img src="../imatges/p4.jpeg" width="240px" alt="Producto 4">
                    <h3>Plug Anal Elástico Libre de látex, para hombre mujer, suave.</h3>
                    <p>ID: 4</p>
                    <p class="price">€17.31 (+ IVA)</p>
                    <p class="availability">Disponibilidad: No</p>
                    <form action="añadirCarrito.php" method="POST">
                        <input type="hidden" name="name" value="Producto 4">
                        <input type="hidden" name="id" value="4">
                        <input type="hidden" name="price" value="17.31">
                        <button type="submit" disabled>Agregar a la cesta</button>
                    </form>
                </div>
            </div>

                    <!-- Producto 5 -->
                    <div class="product-grid">
                <div class="product-card">
                    <img src="../imatges/product-1.jpeg" alt="Producto 4">
                    <h3>Producto 4</h3>
                    <p>ID: 004</p>
                    <p class="price">€49.99 (+ IVA)</p>
                    <p class="availability">Disponibilidad: No</p>
                    <form action="añadirCarrito.php" method="POST">
                        <input type="hidden" name="name" value="Producto 4">
                        <input type="hidden" name="id" value="004">
                        <input type="hidden" name="price" value="49.99">
                        <button type="submit">Agregar a la cesta</button>
                    </form>
                </div>
            </div>

                    <!-- Producto 6 -->
                    <div class="product-grid">
                <div class="product-card">
                    <img src="../imatges/product-1.jpeg" alt="Producto 4">
                    <h3>Producto 4</h3>
                    <p>ID: 004</p>
                    <p class="price">€49.99 (+ IVA)</p>
                    <p class="availability">Disponibilidad: No</p>
                    <form action="añadirCarrito.php" method="POST">
                        <input type="hidden" name="name" value="Producto 4">
                        <input type="hidden" name="id" value="004">
                        <input type="hidden" name="price" value="49.99">
                        <button type="submit">Agregar a la cesta</button>
                    </form>
                </div>
            </div>

                    <!-- Producto 7 -->
                    <div class="product-grid">
                <div class="product-card">
                    <img src="../imatges/product-1.jpeg" alt="Producto 4">
                    <h3>Producto 4</h3>
                    <p>ID: 004</p>
                    <p class="price">€49.99 (+ IVA)</p>
                    <p class="availability">Disponibilidad: No</p>
                    <form action="añadirCarrito.php" method="POST">
                        <input type="hidden" name="name" value="Producto 4">
                        <input type="hidden" name="id" value="004">
                        <input type="hidden" name="price" value="49.99">
                        <button type="submit">Agregar a la cesta</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 AliMorillas. Todos los derechos reservados.</p>
    </footer>
</body>
</html>