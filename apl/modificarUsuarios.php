<?php
session_start(); // Iniciar sesión

function evitarRepetidos($idUsuario, $filename) {
    // Leer el contenido del archivo línea por línea
    $usuaris = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Comprobar si el usuario ya existe en el archivo
    foreach ($usuaris as $usuari) {
        // Dividir la línea en partes usando ':' como delimitador
        list($existentId, ,) = explode(':', $usuari);  //Guarda el primer elemento del array que sale del explode

        if ($existentId === $idUsuario) {
            return true; 
        }
    }

    return false;
}

function crearUsuario($nombreUsuario, $idUsuario, $password, $nombreApellidos = "", $email, $telContacto = "", $codigoPostal = "", $filename = "", $tipoUsuario) {
    if (!file_exists($filename)) {
        if (!$file = fopen($filename, "w")) {
            echo "No se ha podido crear el archivo de usuarios<br>";
            return; // Salir de la función si no se puede crear el archivo
        }
        fclose($file);
    }
    
    // Verificar si el usuario ya existe antes de crear uno nuevo
    if (evitarRepetidos($idUsuario, $filename)) {
        echo "El usuario con ID $idUsuario ya existe.<br>";
        return;
    }

    // Crear el nuevo usuario con el formato adecuado
    $usuario = $idUsuario . ":" . $nombreUsuario . ":" . $password . ":" . $nombreApellidos . ":" . $email . ":" . $telContacto . ":" . $codigoPostal . ":" . $tipoUsuario . "\n";

    // Escribir el usuario en el archivo
    if ($fitxer = fopen($filename, "a")) {
        if (fwrite($fitxer, $usuario)) {
            echo "Se ha registrado el usuario $email con éxito.<br>";
            fclose($fitxer);

            // Redirigir después de un exitoso registro
            header("Location: admin.php?creado=exito");
            exit(); 
        } else {
            echo "Error al escribir en el archivo.<br>";
        }
        fclose($fitxer);
    } else {
        echo "No se ha podido abrir el archivo para escribir.<br>";
    }
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
?>