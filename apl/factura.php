<?php
session_start();
date_default_timezone_set('Europe/Madrid');


if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}

$usuario = $_SESSION['username'];
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura - AliMorillas</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background-color: #fff;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        header .logo h1 {
            margin: 0;
            font-size: 28px;
            color: #333;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 20px 0 0;
        }

        nav ul li {
            display: inline;
            margin: 0 15px;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
            font-size: 28px;
            font-weight: 500;
            background-color: orange;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.2s ease;
        }

        nav ul li a:hover {
            background-color: orangered;
        }

        main {
            padding: 40px 20px;
        }

        .invoice-container {
            background-color: #fff;
            padding: 30px;
            margin: 0 auto;
            max-width: 800px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
        }

        h2 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #333;
        }

        .invoice-header p {
            font-size: 18px;
            color: #555;
        }

        .invoice-items {
            margin-top: 30px;
        }

        .invoice-item {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }

        .item-info {
            font-size: 16px;
            color: #333;
        }

        .item-name {
            font-weight: bold;
        }

        .item-quantity {
            color: #888;
        }

        .item-price {
            text-align: right;
            font-size: 16px;
            color: #333;
        }

        .price {
            font-size: 14px;
        }

        .total {
            font-weight: bold;
            font-size: 18px;
            color: #27ae60;
        }

        .invoice-summary {
            margin-top: 30px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
        }

        .summary-item p {
            font-size: 16px;
            color: #555;
        }

        .total-price p {
            font-size: 20px;
            font-weight: bold;
            color: #27ae60;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            margin-top: 50px;
            font-size: 14px;
            color: #aaa;
        }

        .botonFacturaPDF{
            background-color: red;
            font-family: 'Roboto', sans-serif;
            color: white;
            padding: 10px 20px;
            border: none;
            text-decoration: none;
            font-size: 24px;
            margin-top: 15px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <ul class="nav-links">
                <li><a href="carrito.php" class="cta-button">Volver</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="invoice-container">
            <h2>Factura</h2>
            <div class="invoice-header">
                <p><strong>Cliente:</strong> <?php echo htmlspecialchars($usuario); ?></p>
            </div>
            
            <div class="invoice-items">
                <?php foreach ($cart as $product): ?>
                <div class="invoice-item">
                    <div class="item-info">
                        <p class="item-name"><?php echo htmlspecialchars($product['name']); ?></p>
                        <p class="item-quantity">Cantidad: <?php echo htmlspecialchars($product['quantity']); ?></p>
                    </div>
                    <div class="item-price">
                        <p class="price">€<?php echo number_format($product['price'], 2); ?> x <?php echo htmlspecialchars($product['quantity']); ?></p>
                        <p class="total">€<?php echo number_format($product['price'] * $product['quantity'], 2); ?></p>
                    </div>
                </div>
                <?php
                $total += $product['price'] * $product['quantity'];
                endforeach;
                ?>
            </div>

            <div class="invoice-summary">
                <div class="summary-item">
                    <p><strong>Precio antes de IVA:</strong> €<?php echo number_format($total, 2); ?></p>
                </div>
                <div class="summary-item">
                    <p><strong>IVA (21%):</strong> €<?php echo number_format($total * 0.21, 2); ?></p>
                </div>
                <div class="summary-item">
                    <p><strong>Envío:</strong> 5.00€</p>
                </div>
                <div class="summary-item total-price">
                    <p><strong>Total (con IVA + Envío):</strong> €<?php echo number_format($total * 1.21 + 5, 2); ?></p>
                    <p style="color: #333;font-weight:bold;">Hora de factura realizada: <?php echo date("d/m/Y H:i:s"); ?></p> 
                </div>
            </div>
            <div class="centrarBoton" style="text-align:center;">
                <form action="facturaPDF.php" method="post">
                <button type="submit" class="botonFacturaPDF">Generar PDF</button>
            </form>
            </div>

        </section>
    </main>

    <footer>
        <p>&copy; 2024 AliMorillas. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
