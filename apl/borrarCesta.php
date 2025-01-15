<?php
session_start();

// Obtener el nombre de usuario de la sesión
$usuario = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;

if ($usuario) {
    $filename = __DIR__ . '/../cesta.txt';
    
    // Verificar si el archivo existe
    if (file_exists($filename)) {
        $file = fopen($filename, 'r');
        $lines = [];
        
        // Leer todas las líneas del archivo
        while (($line = fgets($file)) !== false) {
            $data = explode(':', trim($line));
            
            // Si el usuario no coincide, mantener la línea
            if (count($data) == 5 && $data[4] != $usuario) {
                $lines[] = $line;
            }
        }
        
        fclose($file);
        
        // Escribir las líneas restantes de nuevo en el archivo
        $file = fopen($filename, 'w');
        foreach ($lines as $line) {
            fwrite($file, $line);
        }
        
        fclose($file);
    }
    
    // Redirigir al carrito
    header("Location: carrito.php?mensaje=cesta_vaciada");
    exit();
} else {
    // Si no hay usuario en sesión, redirigir al login
    header("Location: login.html");
    exit();
}
?>
