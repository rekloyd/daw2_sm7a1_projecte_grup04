<?php
session_start(); // Inicia la sesión

// Destruir todas las variables de sesión
$_SESSION = array();

// Destruir la sesión completamente
session_destroy();

// Redirigir al usuario a la página principal
header("Location: index.php");
exit();
?>