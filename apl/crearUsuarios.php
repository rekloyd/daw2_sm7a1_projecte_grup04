<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Alta de usuarios</title>	
</head>  
<body>
    <?php

    function evitarRepetidos($idUsuario, $filename) {

        // Leer el contenido del archivo línea por línea
        $usuaris = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Comprobar si el usuario ya existe en el archivo
        foreach ($usuaris as $usuari) {
            // Dividir la línea en partes usando ':' como delimitador, ojo con el orden de las variables que hemos escrito
            list($existentId, ,) = explode(':', $usuari);  //Guarda el primer elemento del array que sale del explode
    

            if ($existentId === $idUsuario) {
                return true; 
            }
        }

        return false;
    }

    function crearUsuario($nombreUsuario,$idUsuario,$password,$nombreApellidos="",$email,$telContacto="",$codigoPostal = "",$filename = "",$tipoUsuario){
        if (!file_exists($filename)) {
            if (!$file = fopen($filename, "w")) {
                echo "No s'ha pogut crear el fitxer d'usuaris<br>";
            }
            fclose($file);
        }
        evitarRepetidos($idUsuario,$filename);
 
        if($tipoUsuario == "gestor"){
            $usuario = $idUsuario . ":" . $nombreUsuario . ":" . $password . ":". $nombreApellidos . ":" . $email . ":" . $telContacto . ":" . $codigoPostal . ":" . $tipoUsuario . "\n";

        }
        if($tipoUsuario == "cliente"){
            $usuario = $idUsuario . ":" . $nombreUsuario . ":" . $password . ":". $nombreApellidos .":" . $email . ":" . $telContacto . ":" . $codigoPostal . ":" . $tipoUsuario . "\n";

        }

        if ($fitxer = fopen($filename, "a")) {
            if (fwrite($fitxer, $usuario)) {
                echo "S'ha registrat l'usuari $email amb èxit<br>";

                // Guardar el username en la sesión
                $_SESSION['username'] = $nombreUsuario;
                $_SESSION['email'] = $email;
                $_SESSION['id'] = $idUsuario;
                $_SESSION['tipo'] = $tipoUsuario;

                // Redirigir al index.php
                fclose($fitxer);
                header("Location: admin.php?creado=exito");
                exit();
            } else {
                echo "error";
            }
            fclose($fitxer);
        } else {
            echo "No s'ha pogut obrir el fitxer per escriure<br>";
        }
    }
    
    session_start(); // Iniciar sesión

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if(isset($_POST['crearGestor'] == "1")){
            $nombreUsuario = $_POST['usuarioGestor'];
            $nombre = $_POST['nombreGestor'];
            $idNumerico = $_POST['idGestor'];
            $contraseña = $_POST['contraseñaGestor'];
            $email = $_POST['emailGestor'];
            $telContacto = $_POST['telContactoGestor'];
            //$contraseña = hash('sha256', $contraseña); // Encriptar contraseña
            $email = $_POST['emailGestor'];

            evitarRepetidos($idNumerico, __DIR__ . "/usuarios.txt");
            crearUsuario($nombreUsuario,$idNumerico,$contraseña,$nombre,$email,$telContacto,"null",__DIR__ . "/usuarios.txt","gestor");

        }
    }
        

    ?>
</body>
</html>
