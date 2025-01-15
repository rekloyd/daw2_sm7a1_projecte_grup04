<?php
// require 'apl/vendor/autoload.php'; No funciona 

// use Dompdf\Dompdf;

session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['cart'])) {
    header('Location: login.html');
    exit();
}

$usuario = $_SESSION['username'];
$cart = $_SESSION['cart'];
$total = 0;

$html = '<html><body>';
$html .= '<h1>Factura - AliMorillas</h1>';
$html .= '<p><strong>Cliente:</strong> ' . htmlspecialchars($usuario) . '</p>';
$html .= '<table border="1" cellpadding="10" cellspacing="0" width="100%">';
$html .= '<tr><th>Producto</th><th>Cantidad</th><th>Precio</th><th>Total</th></tr>';

foreach ($cart as $product) {
    $subtotal = $product['price'] * $product['quantity'];
    $total += $subtotal;
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($product['name']) . '</td>';
    $html .= '<td>' . htmlspecialchars($product['quantity']) . '</td>';
    $html .= '<td>€' . number_format($product['price'], 2) . '</td>';
    $html .= '<td>€' . number_format($subtotal, 2) . '</td>';
    $html .= '</tr>';
}

$iva = $total * 0.21;
$total_con_envio = $total + $iva + 5;

$html .= '</table>';
$html .= '<p><strong>Precio antes de IVA:</strong> €' . number_format($total, 2) . '</p>';
$html .= '<p><strong>IVA (21%):</strong> €' . number_format($iva, 2) . '</p>';
$html .= '<p><strong>Envío:</strong> €5.00</p>';
$html .= '<p><strong>Total (con IVA + Envío):</strong> €' . number_format($total_con_envio, 2) . '</p>';
$html .= '</body></html>';

try {
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream('Factura_AliMorillas_'.$usuario.'.pdf');
} catch (Exception $e) {
    echo 'Error al generar el PDF: ', $e->getMessage();
}
