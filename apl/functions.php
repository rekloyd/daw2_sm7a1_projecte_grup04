<?php
session_start(); // Iniciar sesión

require '../vendor/autoload.php';


//DOMpdf
use Dompdf\Dompdf;
use Dompdf\Options;



//PHPmailer 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


function enviarCorreo($emailUsuario,$mensajeEmail,$asunto){
    #
    # AQUEST EXEMPLE ÉS VÀLID UTILITZANT EL COMPTE DE L'ESCOLA FJE.EDU
    # Heu d'activar "Accés d'aplicacions menys segures" del teu compte de correu:
    # 	1- Entra al correu de gmail
    #   2- Fes clic amb el botó de l'esquerra del ratolí a sobre de la icona rodona amb la teva inicial que hi ha a la part superior a de la dreta
    #	3- Selecciona "Gestiona el teu Compte de Google" 
    #	4- Selecciona "Seguretat" a la llista de l'esquerra
    #	5- Selecciona "Verificació en 2 passos"
    #	6- Selecciona "Activa la verificació en 2 passos"
    #	7- Introdueix un número de telèfon
    #	8- Selecciona "Contrasenya d'aplicacions"
    #	9- Crea un nova contrasenya per la teva aplicació
    #	10- Còpia la contrasenya (4 combinacions de 4 lletres)
    #	11- Fes clic al botó inferior per finalitzar
    #
    // Instanciant un objecte de la classe PHPMailer
    $mail = new PHPMailer();
    $mail->CharSet = "UTF-8";
    // Activa debug --> https://phpmailer.github.io/PHPMailer/classes/PHPMailer-PHPMailer-SMTP.html
    $mail->SMTPDebug=0; // 0 - 4 -> Des de 0 que no fa debug fins al màxim debug amb el valor 4
    //SMTP SERVER
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "PHPMailer::ENCRYPTION_STARTTLS";
    //USUARI
    $mail->Username = "thedark3slol@gmail.com"; // El teu compte de gmail.com
    $mail->Password = "hhta jeya seft mmem"; // El teu password d'aplicació			                 
    //Missatge
    $mail->SetFrom("thedark3slol@gmail.com","Pau Morillas"); //El teu ccompte de gmail i el teu nom i cognoms
    $mail->addAddress($emailUsuario,"Pau Morillas"); //El compte al qual s'envia el correu, i el nom i cognoms del receptor del correu
    $mail->Subject =  $asunto;
    $mail->isHTML(true);
    $mail->Body = $mensajeEmail;					
    //Enviament i tractament errors
    try {
        if ($mail->send()) header("Location: areasPersonales.php");
    }
    catch (Exception $e) {
        echo "Error d'enviament del missatge: " . $mail->ErrorInfo; //El missatge d'error depén del nivell de debug indicat a SMTPDebug
    }
    $mail->smtpClose();
}


function exportarTablaPDF($archivoUsuarios, $tipoUsuario) {
    // Leer usuarios desde el archivo
    $usuarios = file($archivoUsuarios, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Generar tabla HTML filtrada
    $htmlTabla = '<table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th>Código Postal</th>
                <th>Tipo de Usuario</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($usuarios as $usuario) {
        $datos = explode(':', $usuario);

        // Verificar que la línea tiene al menos 8 campos
        if (count($datos) >= 8) {
            list($id, $username, $password, $nombre, $email, $telefono, $codigoPostal, $tipo) = $datos;

            // Agregar a la tabla solo si coincide el tipo de usuario
            if (trim($tipo) === $tipoUsuario) {
                $htmlTabla .= '<tr>
                    <td>' . htmlspecialchars($id) . '</td>
                    <td>' . htmlspecialchars($username) . '</td>
                    <td>' . htmlspecialchars($nombre) . '</td>
                    <td>' . htmlspecialchars($email) . '</td>
                    <td>' . htmlspecialchars($telefono) . '</td>
                    <td>' . htmlspecialchars($codigoPostal) . '</td>
                    <td>' . htmlspecialchars($tipo) . '</td>
                </tr>';
            }
        }
    }

    $htmlTabla .= '</tbody></table>';

    // Configurar Dompdf
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf($options);

    // CSS para la tabla
    $css = '
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
    </style>';

    // Combinar CSS y tabla HTML
    $html = $css . $htmlTabla;

    // Cargar contenido HTML
    $dompdf->loadHtml($html);

    // Configurar tamaño de la página
    $dompdf->setPaper('A4', 'landscape');

    // Renderizar el PDF
    $dompdf->render();

    // Descargar el PDF
    $dompdf->stream("usuarios_" . $tipoUsuario . ".pdf", ["Attachment" => true]);
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

function crearUsuario($nombreUsuario, $idUsuario, $password, $nombreApellidos = "", $email, $telContacto = "", $codigoPostal = "", $filename = "",$visaCliente="none",$gestorAsignado,$tipoUsuario){
    if (!file_exists($filename)) {
        if (!$file = fopen($filename, "w")) {
            echo "No se ha podido crear el archivo de usuarios<br>";
        }
        fclose($file);
    }


    if (evitarRepetidos($idUsuario, $filename)) {
        echo "El usuario ya existe.";
        return;
    }

    $hashPass = hash("sha256", $password);

    if ($tipoUsuario == "gestor") {
        $usuario = $idUsuario . ":" . $nombreUsuario . ":" . $hashPass . ":" . $nombreApellidos . ":" . $email . ":" . $telContacto . ":" . "08800" . ":" ."none".":none". $tipoUsuario . PHP_EOL;
    } elseif ($tipoUsuario == "cliente") {
        $usuario = $idUsuario . ":" . $nombreUsuario . ":" . $hashPass . ":" . $nombreApellidos . ":" . $email . ":" . $telContacto . ":" . $codigoPostal . ":".$visaCliente.":".$gestorAsignado.":". $tipoUsuario . PHP_EOL;
    }


    if ($fitxer = fopen($filename, "a")) {
        if (fwrite($fitxer, $usuario)) { 
            fclose($fitxer); 
            header("Location: admin.php?creado=exito");
            exit(); 
        } else {
            echo "Error al escribir en el archivo";
            fclose($fitxer); 
        }
    } else {
        echo "No se ha podido abrir el archivo para escribir<br>";
    }
    
}

function modificarUsuario($idUsuario, $nombreUsuario, $password, $nombreApellidos = "", $email, $telContacto = "none", $codigoPostal = "none", $filename = "",$visaCliente="none",$gestorAsignado="",$tipoUsuario) {
    $usuaris = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $usuariosActualizados = [];
    $usuarioModificado = false;

    foreach ($usuaris as $usuari) {
        list($existentId,,,,,,) = explode(':', $usuari);

        if ($existentId === $idUsuario) {

            $password = hash('sha256', $password);
            $usuario = $idUsuario . ":" . $nombreUsuario . ":" . $password . ":" . $nombreApellidos . ":" . $email . ":" . $telContacto . ":" . $codigoPostal . ":" .$visaCliente.":" . $tipoUsuario . "\n";
            array_push($usuariosActualizados, $usuario);
            $usuarioModificado = true;
        } else {
    
            array_push($usuariosActualizados, $usuari);
        }
    }

    if ($usuarioModificado) {

        $resultado = file_put_contents($filename, implode("\n", $usuariosActualizados));

        if ($resultado === false) {
            echo "Error al guardar los cambios en el archivo.";
        } else {

            header("Location: admin.php?modificado=exito");
            exit();
        }
    } else {
        echo "No se encontró un usuario con ese ID para modificar.<br>";
    }
}


function modificarAdmin($idAdmin, $nombreAdmin, $passwordAdmin, $emailAdmin, $filename) {
    $usuaris = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $usuariosActualizados = [];

    $adminModificado = false;


    foreach ($usuaris as $usuari) {
        list($id, $usuario, $password, $nombre, $email, $telefono, $codigoPostal, $tipoUsuario) = explode(":", $usuari);

        if ($id === $idAdmin) {
            // Modificar los datos del admin
            $password = hash('sha256', $passwordAdmin); // Encriptar la nueva contraseña
            $nuevoUsuario = $id . ":" . $nombreAdmin . ":" . $password . ":" . $nombre . ":" . $emailAdmin . ":" . "none" . ":" . "none" . ":" . "admin" . "\n";
            array_push($usuariosActualizados, $nuevoUsuario); // Añadir el admin actualizado
            $adminModificado = true;
        } else {
            // Si no es el admin que se modifica, se mantiene igual
            array_push($usuariosActualizados, $usuari);
        }
    }

    if ($adminModificado) {
        // Sobrescribir el archivo con los usuarios actualizados
        file_put_contents($filename, implode("\n", $usuariosActualizados));

   
        $_SESSION['username'] = $nombreAdmin; 
        $_SESSION['email'] = $emailAdmin; 
        $_SESSION['id'] = $idAdmin; 
        $_SESSION['tipo'] = 'admin'; 

        header("Location: admin.php?modificado=exito");
        exit();
    } else {
        echo "No se encontró un administrador con ese ID para modificar.<br>";
    }
}

function generarTabla($filename, $tipoUsuario) {
    if (!file_exists($filename)) {
        echo "El archivo no existe.";
        return;
    }

    // Leer el archivo con los usuarios
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
            echo "<td>" . "hashed" . "</td>";  // Mostrar "hashed" por razones de seguridad
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

function validarContraseña($password) {

    if (preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&*!])[A-Za-z\d@#$%^&*!]{8,}$/', $password)) {
        return true;
    } else {
        return false; 
    }
}


?>
