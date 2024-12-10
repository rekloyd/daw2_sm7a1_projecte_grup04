<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="utf-8">
    <title>Registre d'Usuaris</title>	
</head>  
<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "<b>GESTIONANT EL REGISTRE D'USUARIS</b><br>";
        
        // Verificar si se envían todos los campos requeridos
        if (!empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["user_type"]) && !empty($_POST["username"])) {
            $email = trim($_POST["email"]);
            $password = trim($_POST["password"]);
            $userType = trim($_POST["user_type"]);
            $username = trim($_POST["username"]);

            // Ruta del archivo usuarios.txt
            $filename = "C:\\Users\\paumo\\OneDrive\\Clot\\DAW2\\SM 7.1 PHP\\peroyectoPHP\\phpEcomProject\\usuarios.txt";

            // Crear el archivo si no existe,si no es mejor abrirlo con "a" para no sobreescribir
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
                echo "L'usuari amb el correu $email y el nom $username ja existeix<br>";
            } else {
                // Registrar el nuevo usuario
                if ($fitxer = fopen($filename, "a")) {
                    $registre = "$email:$password:$username:$userType\n"; //Es el formato en el que guardamos los datos es importante el \n ya que si no se escribe todo junto en una sola línea
                    if (fwrite($fitxer, $registre)) {
                        echo "S'ha registrat l'usuari $email amb èxit<br>";
                    } else {
                        echo "No s'ha pogut registrar l'usuari $email<br>";
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
