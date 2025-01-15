<?php
session_start();

// Array de productos
$productos = [
    [
        'id' => 1,
        'name' => 'Cepillo para perros con pelo, pelaje largo, cachorros',
        'price' => 27,
        'availability' => 'Si',
        'image' => 'imatges/pd1.jpg',
    ],
    [
        'id' => 2,
        'name' => 'Comedero automático para perros y gatos',
        'price' => 45,
        'availability' => 'Si',
        'image' => 'imatges/pd2.jpg',
    ],
    [
        'id' => 3,
        'name' => 'Juguete interactivo para perros',
        'price' => 22,
        'availability' => 'Si',
        'image' => 'imatges/pd3.jpg',
    ],
    [
        'id' => 4,
        'name' => 'Correa retráctil para perros pequeños',
        'price' => 18,
        'availability' => 'Si',
        'image' => 'imatges/pd4.jpg',
    ],
    [
        'id' => 5,
        'name' => 'Cama ortopédica para perros',
        'price' => 75,
        'availability' => 'Si',
        'image' => 'imatges/pd5.jpg',
    ],
    [
        'id' => 6,
        'name' => 'Higiene dental para perros',
        'price' => 12,
        'availability' => 'Si',
        'image' => 'imatges/pd6.jpg',
    ],
];

// Asegurarse de que el carrito está inicializado
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Lógica para agregar al carrito
if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Encontrar el producto por su id
    foreach ($productos as $product) {
        if ($product['id'] == $productId) {
            // Agregar el producto al carrito
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['quantity'] += $quantity;  // Incrementar cantidad si ya existe
            } else {
                $_SESSION['cart'][$productId] = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity,
                    'image' => $product['image'],
                ];
            }
            break;
        }
    }
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
</head>

<body>
<?php
session_start();
date_default_timezone_set('Europe/Madrid');

$usuario = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
$tipoUsuario = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : NULL;
$cart_empty = !(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0);
?>
<header>
        <div class="logo">
            <h1>AliMorillas</h1>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="ayuda.php">Ayuda</a></li>
                <?php
                if ($usuario) {
                    echo "<li style='color:blue; font-weight:bold;'><a href='areasPersonales.php?tipo=" . htmlspecialchars($tipoUsuario) . "' style='color:inherit;'>Hola, " . strtoupper(htmlspecialchars($usuario)) . "</a></li>";
                    echo "<li><a href='carrito.php' style='display: inline-flex; align-items: center;'>
                <svg xmlns='http://www.w3.org/2000/svg' height='24px' viewBox='0 -960 960 960' width='24px' fill='#e8eaed'>
                    <path d='M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Zm134 280h280-280Z'/>
                </svg>
            </a></li>";
                    echo "<li><a href='logout.php' class='log-in'>Cerrar sesión</a></li>";
                } else {
                    echo "<li><a href='login.html' class='log-in'>Log In</a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Productos Disponibles</h2>
        <div class="product-list">
            <?php foreach ($productos as $product): ?>
                <div class="product-item">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    <h3><?php echo $product['name']; ?></h3>
                    <p>Precio: <?php echo number_format($product['price'], 2); ?>€</p>
                    <p>Disponibilidad: <?php echo $product['availability']; ?></p>
                    <form method="POST" action="index.php">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <label for="quantity_<?php echo $product['id']; ?>">Cantidad:</label>
                        <input type="number" id="quantity_<?php echo $product['id']; ?>" name="quantity" value="1" min="1" required>
                        <button type="submit" name="add_to_cart">Añadir al carrito</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 AliMorillas. Todos los derechos reservados.</p>
    </footer>
</body>

</html>
