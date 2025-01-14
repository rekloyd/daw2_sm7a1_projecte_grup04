<?php
session_start(); // Iniciar sesión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<b>GESTIONANT EL LOGIN D'USUARI</b><br>";
    
    // Verificar si se envían los campos requeridos (username y password)
    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        // Ruta del archivo usuarios.txt
        $filename = dirname(__FILE__) . "/../usuarios.txt";

        // Leer todo el contenido del archivo
        $usuaris = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Variable para verificar si el usuario existe y la contraseña es correcta
        $usuarioExiste = false;

        // Recorrer el archivo y verificar si el usuario y la contraseña coinciden
        foreach ($usuaris as $usuari) {
            list(, $passwd, $user) = explode(':', $usuari);  // Descomponer el registro

            if ($user === $username && $passwd === $password) {
                // Si el usuario y la contraseña coinciden, iniciar la sesión
                $_SESSION['username'] = $username;
                $usuarioExiste = true;
                break;
            }
        }

        // Verificar si el usuario fue encontrado
        if ($usuarioExiste) {
            echo "Login exitoso. Redirigiendo...<br>";
            // Redirigir a la página principal (index.php)
            header("Location: index.php");
            exit();
        } else {
            echo "Usuario o contraseña incorrectos<br>";
        }
    } else {
        echo "Por favor, ingrese tanto el usuario como la contraseña<br>";
    }
} else {
    echo "Método de solicitud incorrecto<br>";
}
?>
