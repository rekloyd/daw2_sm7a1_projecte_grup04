<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Modificar datos de usuario</title>  
</head>  
<body>
    <?php

    function evitarRepetidos($idUsuario, $filename) {
        // Leer el contenido del archivo línea por línea
        $usuaris = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Comprobar si el usuario ya existe en el archivo
        foreach ($usuaris as $usuari) {
            // Dividir la línea en partes usando ':' como delimitador
            list($existentId, ,) = explode(':', $usuari); 
            
            if ($existentId === $idUsuario) {
                return true; 
            }
        }

        return false;
    }

    function modificarUsuario($idUsuario, $nombreUsuario, $password, $nombreApellidos="", $email, $telContacto="", $codigoPostal = "", $filename = "", $tipoUsuario){

        $usuaris = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $usuariosActualizados = [];

        $usuarioModificado = false;

        foreach ($usuaris as $usuari) {
            // Dividir la línea en partes usando ':' como delimitador
            list($existentId, $nombre, $contraseña, $correo, $telefono, $codigo, $tipo) = explode(':', $usuari);

            // Si encontramos el usuario con el id que queremos modificar
            if ($existentId === $idUsuario) {
                // Modificar los datos del usuario
                $usuarioModificado = true;
                $usuario = $idUsuario . ":" . $nombreUsuario . ":" . $password . ":" . $email . ":" . $telContacto . ":" . $codigoPostal . ":" . $tipoUsuario . "\n";
                array_push($usuariosActualizados, $usuario); // Agregar el nuevo usuario modificado
            } else {
                // Mantener el usuario sin modificar
                array_push($usuariosActualizados, $usuari);
            }
        }

        if ($usuarioModificado) {
            // Sobrescribir el archivo con los usuarios actualizados
            file_put_contents($filename, implode("\n", $usuariosActualizados));


            // Guardar los nuevos datos en la sesión
            $_SESSION['username'] = $nombreUsuario;
            $_SESSION['email'] = $email;
            $_SESSION['id'] = $idUsuario;
            $_SESSION['tipo'] = $tipoUsuario;

            // Redirigir a admin.php con el mensaje de éxito
            header("Location: admin.php?modificado=exito");
            exit();
        } else {
            echo "No se encontró un usuario con ese ID para modificar.<br>";
        }
    }

    session_start(); // Iniciar sesión

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if($_POST['modificarUsuario'] == "1") {
            $nombreUsuario = $_POST['usuario'];
            $idNumerico = $_POST['idUsuario'];
            $contraseña = $_POST['contraseña'];
            $email = $_POST['email'];
            $telContacto = $_POST['telContacto'];
            $codigoPostal = $_POST['codigoPostal'];
            $tipoUsuario = $_POST['tipoUsuario'];

            // Verificar si el usuario ya existe
            if (evitarRepetidos($idNumerico, __DIR__ . "/usuarios.txt")) {
                // Llamar a la función para modificar los datos del usuario
                modificarUsuario($idNumerico, $nombreUsuario, $contraseña, "", $email, $telContacto, $codigoPostal, __DIR__ . "/usuarios.txt", $tipoUsuario);
            } else {
                echo "No se ha encontrado un usuario con ese ID para modificar.<br>";
            }
        }
    }

    ?>
</body>
</html>
