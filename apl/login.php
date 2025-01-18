<?php
session_start(); // Iniciar sesión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<b>GESTIONANT EL LOGIN D'USUARI</b><br>";

    if (!empty($_POST["username"]) && !empty($_POST["password"])) {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        // Ruta del archivo usuarios.txt
        $filename = __DIR__ . "/../usuaris/usuarios.txt";

        // Verificar si el archivo existe
        if (!file_exists($filename)) {
            echo "El archivo de usuarios no existe.<br>";
            exit();
        }

        // Leer todo el contenido del archivo
        $usuaris = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);


        $usuarioValido = false;

        // Recorrer el archivo y verificar si el usuario y la contraseña coinciden
        foreach ($usuaris as $usuari) {
            $datos = explode(':', $usuari);

            if (count($datos) === 8) {
                list($idUsuario, $user, $passwordHash, $nombreApellidos, $email, $telefono, $codigoPostal, $tipoUsuario) = $datos;

                // Comprobar si el username coincide
                if ($user === $username) {
                    // Info par depurar
                    echo "Contraseña ingresada (sin espacio): '" . $password . "'<br>";
                    echo "Contraseña ingresada (hasheada): '" . hash('sha256', $password) . "'<br>";
                    echo "Hash almacenado en el archivo: '" . $passwordHash . "'<br>";

                    // Hashear la contraseña ingresada y compararla con el hash almacenado
                    if ($passwordHash === hash('sha256', $password)) {
                        // Si la contraseña es válida, iniciar la sesión
                        $_SESSION['idUsuario'] = $idUsuario;
                        $_SESSION['username'] = $username;
                        $_SESSION['nombreApellidos'] = $nombreApellidos;
                        $_SESSION['emailUsuario'] = $email;
                        $_SESSION['telefono'] = $telefono;
                        $_SESSION['codigoPostal'] = $codigoPostal;
                        $_SESSION['tipoUsuario'] = $tipoUsuario;

                        $usuarioValido = true;
                        break;
                    } else {
                        echo "Contraseña incorrecta.<br>";
                    }
                }
            } else {
                echo "Datos incompletos en la línea: " . htmlspecialchars($usuari) . "<br>";
            }
        }

        // Verificar si el usuario fue encontrado y validado
        if ($usuarioValido) {
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
