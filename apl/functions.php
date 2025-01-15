<?php
session_start(); // Iniciar sesión

require 'vendor/autoload.php';



//EXPORTACION DE LA TABLA A PDF

require 'vendor/autoload.php'; // Asegúrate de incluir el autoload de Composer

use Dompdf\Dompdf;
use Dompdf\Options;

function exportarTablaPDF($htmlTabla) {
    // Configurar Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true); // Necesario si tienes imágenes remotas o CSS externos

    $dompdf = new Dompdf($options);

    // CSS personalizado (puedes incluir el CSS de tu tabla aquí)
    $css = '
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 16px;
            text-align: left;
            background-color: #f9f9f9;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        thead {
            background-color: #2c3e50;
            color: white;
            text-transform: uppercase;
        }

        thead th {
            padding: 12px 15px;
        }

        tbody tr {
            border-bottom: 1px solid #ddd;
            transition: background-color 0.3s ease;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        tbody td {
            padding: 10px 15px;
            color: #333;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

    </style>
    ';

    // Combina CSS y HTML de la tabla
    $html = $css . $htmlTabla;

    // Cargar contenido HTML
    $dompdf->loadHtml($html);

    // Configurar tamaño y orientación de página
    $dompdf->setPaper('A4', 'landscape'); // Opciones: 'portrait' o 'landscape'

    // Renderizar el PDF
    $dompdf->render();

    // Enviar el PDF al navegador para descargar
    $dompdf->stream("tabla_usuarios.pdf", ["Attachment" => true]);
}




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

function crearUsuario($nombreUsuario, $idUsuario, $password, $nombreApellidos = "", $email, $telContacto = "", $codigoPostal = "", $filename = "", $tipoUsuario){
    if (!file_exists($filename)) {
        if (!$file = fopen($filename, "w")) {
            echo "No s'ha pogut crear el fitxer d'usuaris<br>";
        }
        fclose($file);
    }
    evitarRepetidos($idUsuario,$filename);

    $hashPass = hash("sha256",$password);

    if($tipoUsuario == "gestor"){
        $usuario = $idUsuario . ":" . $nombreUsuario . ":" . $hashPass . ":".$nombreApellidos.":". $email . ":" . $telContacto . ":" . $codigoPostal . ":" . $tipoUsuario . "\n";
    }
    if($tipoUsuario == "cliente"){
        $usuario = $idUsuario . ":" . $nombreUsuario . ":" . $hashPass. ":". $nombreApellidos .":". $email . ":" . $telContacto . ":" . $codigoPostal . ":" . $tipoUsuario . "\n";
    }

    if ($fitxer = fopen($filename, "a")) {
        if (fwrite($fitxer, $usuario)) {
            echo "S'ha registrat l'usuari $email amb èxit<br>";

            // Guardar el username en la sesión
            $_SESSION['username'] = $nombreUsuario;
            $_SESSION['email'] = $email;
            $_SESSION['id'] = $idUsuario;
            $_SESSION['tipo'] = $tipoUsuario;

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

function modificarUsuario($idUsuario, $nombreUsuario, $password, $nombreApellidos="", $email, $telContacto="", $codigoPostal = "", $filename = "", $tipoUsuario){

    $usuaris = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $usuariosActualizados = [];

    $usuarioModificado = false;

    foreach ($usuaris as $usuari) {
        // Dividir la línea en partes usando ':' como delimitador
        list($existentId,,,,,,) = explode(':', $usuari);

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
        header("Location: admin.php?modificado=exito");
        exit();
    } else {
        echo "No se encontró un usuario con ese ID para modificar.<br>";
        echo $existentId;
        echo $idUsuario;
    }
}

function generarTabla($filename, $tipoUsuario) {
    if (!file_exists($filename)) {
        echo "El archivo no existe.";
        return;
    }

    $usuaris = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    echo "<table border='1'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>ID Usuario</th>";
    echo "<th>Nombre de Usuario</th>";
    echo "<th>Password</th>";
    echo "<th>Nombre y Apellidos</th>";
    echo "<th>Email</th>";
    echo "<th>Teléfono</th>";
    echo "<th>Código Postal</th>";
    echo "<th>Tipo de Usuario</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($usuaris as $usuari) {
        $datos = explode(":", $usuari);


        if (count($datos) < 8) {
            continue;
        }

        list($idUsuario, $nombreUsuario, $password, $nombreApellidos, $email, $telContacto, $codigoPostal, $tipo) = $datos;

  
        if ($tipo === $tipoUsuario) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($idUsuario) . "</td>";
            echo "<td>" . htmlspecialchars($nombreUsuario) . "</td>";
            echo "<td>" . htmlspecialchars($password) . "</td>";
            echo "<td>" . htmlspecialchars($nombreApellidos) . "</td>";
            echo "<td>" . htmlspecialchars($email) . "</td>";
            echo "<td>" . htmlspecialchars($telContacto) . "</td>";
            echo "<td>" . htmlspecialchars($codigoPostal) . "</td>";
            echo "<td>" . htmlspecialchars($tipo) . "</td>";
            echo "</tr>";
        }
    }

    echo "</tbody>";
    echo "</table>";
}



?>
