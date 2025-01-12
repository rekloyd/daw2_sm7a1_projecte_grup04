<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Alta de usuarios</title>	
</head>  
<body>
    <?php

    function evitarRepetidos($idUsuario, $filename) {
        // Verificar si el archivo existe
        if (!file_exists($filename)) {
            echo "El archivo no existe.<br>";
            return false; // El archivo no existe, por lo que no hay usuarios repetidos
        }

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

    function crearUsuario($nombreUsuario,$idUsuario,$password,$nombreApellidos="",$email,$telContacto="",$codigoPostal = "",$filename,$tipoUsuario){
        evitarRepetidos($idUsuario,$filename);

        if($tipoUsuario == "gestor"){
            $usuario = 


        }

        if($tipoUsuario == "cliente"){

        }


    }    


    session_start(); // Iniciar sesión

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if($_POST['crearGestor'] == "1"){
            $nombreUsuario = $_POST['usuarioGestor'];
            $nombre = $_POST['nombreGestor'];
            $idNumerico = $_POST['idGestor'];
            $contraseña = $_POST['contraseñaGestor'];
            $contraseña = hash('sha256', $contraseña); // Encriptar contraseña
            $email = $_POST['emailGestor'];

            evitarRepetidos($idNumerico,$filename = "C:\xampp\htdocs\usuarios.txt");




        }
        
        // Verificar si se envían todos los campos requeridos
        if (!empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["user_type"]) && !empty($_POST["username"])) {
            $email = trim($_POST["email"]);
            $password = trim($_POST["password"]);
            $userType = trim($_POST["user_type"]);
            $username = trim($_POST["username"]);

            // Ruta del archivo usuarios.txt
            $filename = "C:\xampp\htdocs\usuarios.txt";

            // Crear el archivo si no existe, si no es mejor abrirlo con "a" para no sobreescribir
            if (!file_exists($filename)) {
                if (!$file = fopen($filename, "w")) {
                    echo "No s'ha pogut crear el fitxer d'usuaris<br>";
                    exit();
                }
                fclose($file);
            }

            // Comprobar si el usuario ya existe leyendo el fichero entero
            $existeix = false;
            $usuaris = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($usuaris as $usuari) {
                list($existentEmail, ,) = explode(':', $usuari);
                if ($existentEmail === $email) {
                    $existeix = true;
                    break;
                }
            }

            if ($existeix) {
                echo "L'usuari amb el correu $email i el nom $username ja existeix<br>";
            } else {
                // Registrar el nuevo usuario
                if ($fitxer = fopen($filename, "a")) {
                    $registre = "$email:$password:$username:$userType\n"; // Guardar el registro
                    if (fwrite($fitxer, $registre)) {
                        echo "S'ha registrat l'usuari $email amb èxit<br>";

                        // Guardar el username en la sesión
                        $_SESSION['username'] = $username;

                        // Redirigir al index.php
                        header("Location: admin.php");
                        exit();
                    } else {
                        echo "No s'ha pogut registrar l'usuari $email<br>";
                        echo "<a href='signup.html'>Vuelve al registro</a>";
                    }
                    fclose($fitxer);
                } else {
                    echo "No s'ha pogut obrir el fitxer per escriure<br>";
                }
            }
        } else {
            echo "No s'han enviat tots els camps requerits (email, password, tipus)<br>";
        }
    } else {
        echo "Mètode incorrecte<br>";
    }
    ?>
</body>
</html>
