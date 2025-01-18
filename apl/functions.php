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

function eliminarUsuario($filename, $idUsuario) {
    if (!file_exists($filename)) {
        echo "El archivo no existe.";
        return false;
    }

    // Leer el archivo con los usuarios
    $usuaris = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $usuariosActualizados = [];
    $usuarioEliminado = false;


    foreach ($usuaris as $usuari) {
        $datos = explode(":", $usuari);
        if (count($datos) < 9) {
            continue;
        }

        list($id, $nombreUsuario, $password, $nombreApellidos, $email, $telContacto, $codigoPostal, $visaCliente, $gestorAsignado, $tipoUsuario) = $datos;

        if ($id === $idUsuario) {
            $usuarioEliminado = true;
            continue;
        }


        $usuariosActualizados[] = $usuari;
    }

    if ($usuarioEliminado) {

        usort($usuariosActualizados, function($a, $b) {
            $datosA = explode(":", $a);
            $datosB = explode(":", $b);

            return strcmp($datosA[1], $datosB[1]); // Ordenar por nombre de usuario (índice 1)
        });

        file_put_contents($filename, implode(PHP_EOL, $usuariosActualizados) . PHP_EOL);
        header("Location:admin.php");
        return true;
    } else {
        echo "No se encontró un usuario con el ID $idUsuario.";
        return false;
    }
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
        if (count($datos) > 8) {
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

function crearUsuario($nombreUsuario, $idUsuario, $password, $nombreApellidos = "", $email, $telContacto = "", $codigoPostal = "", $visaCliente = "none", $gestorAsignado, $filename, $tipoUsuario) {
    if (!file_exists($filename)) {
 
        if (!$file = fopen($filename, "w")) {
            echo "No se ha podido crear el archivo de usuarios<br>";
            return;
        }
        fclose($file);
    }


    if (evitarRepetidos($idUsuario, $filename)) {
        echo "El usuario ya existe.";
        return;
    }


    $hashPass = hash("sha256", $password);

    if ($tipoUsuario == "gestor") {
        $usuario = $idUsuario . ":" . $nombreUsuario . ":" . $hashPass . ":" . $nombreApellidos . ":" . $email . ":" . $telContacto . ":08800:none:none:" . $tipoUsuario . PHP_EOL;
    } elseif ($tipoUsuario == "cliente") {

        $usuario = $idUsuario . ":" . $nombreUsuario . ":" . $hashPass . ":" . $nombreApellidos . ":" . $email . ":" . $telContacto . ":" . $codigoPostal . ":" . $visaCliente . ":" . $gestorAsignado . ":" . $tipoUsuario . PHP_EOL;
    }

    // Intentar abrir el archivo en modo 'append' para agregar el nuevo usuario
    if ($fitxer = fopen($filename, "a")) {
        // Escribir los datos del usuario al archivo
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
            $nuevoUsuario = $id . ":" . $nombreAdmin . ":" . $password . ":" . $nombre . ":" . $emailAdmin . ":" . "none" . ":" . "none" . ":none:none:" . "admin" . "\n";
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
    echo "<th>Visa</th>";
    echo "<th>Gestor Asignado</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($usuaris as $usuari) {
        $datos = explode(":", $usuari);

        // Comprobar que la línea tiene al menos 10 campos
        if (count($datos) < 10) {
            continue;
        }

        // Asignar los valores
        list($idUsuario, $nombreUsuario, $password, $nombreApellidos, $email, $telContacto, $codigoPostal,$visaCliente, $gestorAsignado,$tipo) = $datos;

        // Mostrar solo los usuarios del tipo especificado
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
            echo "<td>" . htmlspecialchars($visaCliente) . "</td>";
            echo "<td>" . htmlspecialchars($gestorAsignado) . "</td>";
            echo "</tr>";
        }
    }

    echo "</tbody>";
    echo "</table>";
}

// Función para obtener el HTML de la tabla de productos
function obtenerHTMLTablaProductos($filename, $disponibilidadFiltro = null) {
    if (!file_exists($filename)) {
        return "El archivo no existe.";
    }

    // Leer el archivo con los productos
    $productos = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    $html = "<table border='1'>";
    $html .= "<thead><tr><th>ID</th><th>Nombre</th><th>Precio (€)</th><th>Disponibilidad</th><th>Imagen</th></tr></thead>";
    $html .= "<tbody>";

    foreach ($productos as $producto) {
        $datos = explode(":", $producto);
        if (count($datos) < 5) {
            continue;
        }

        list($id, $nombre, $precio, $disponibilidad, $imagen) = $datos;

        // Filtrar por disponibilidad si se especifica
        if ($disponibilidadFiltro !== null && $disponibilidad !== $disponibilidadFiltro) {
            continue;
        }

        $html .= "<tr>";
        $html .= "<td>" . htmlspecialchars($id) . "</td>";
        $html .= "<td>" . htmlspecialchars($nombre) . "</td>";
        $html .= "<td>" . number_format((float)$precio, 2) . "</td>";
        $html .= "<td>" . htmlspecialchars($disponibilidad) . "</td>";
        $html .= "<td>none</td>";
        $html .= "</tr>";
    }

    $html .= "</tbody></table>";

    return $html;
}

// Función para exportar el PDF
function exportarPDFProductosDompdf($html) {
    $options = new Options();
    $options->set('defaultFont', 'Arial');

    $dompdf = new Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $dompdf->stream("productos.pdf", ["Attachment" => 1]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['exportar_pdf_productos'])) {
    $html = obtenerHTMLTablaProductos(__DIR__ . "/../productes/productos.txt");
    exportarPDFProductosDompdf($html);
    exit;
}

// Para mostrar la tabla en la página
$htmlTablaProductos = obtenerHTMLTablaProductos(__DIR__ . "/../productes/productos.txt");

function validarContraseña($password) {

    if (preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&*!])[A-Za-z\d@#$%^&*!]{8,}$/', $password)) {
        return true;
    } else {
        return false; 
    }
}


function obtenerDatosMiUsuario($filename, $username) {
    if (!file_exists($filename)) {
        return "El archivo no existe.";
    }

    $usuarios = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($usuarios as $usuario) {
        $datos = explode(":", $usuario);

        // Asegúrate de que hay suficientes campos
        if (count($datos) < 8) { // Para 8 campos en total
            continue;
        }

        list($id, $nombreUsuario, $contraseña, $nombre, $email, $telContacto, $codigoPostal, $visaCliente) = $datos;

        if ($nombreUsuario == $username) {
            return [
                'nombreUsuario' => $nombreUsuario,
                'contraseña' => $contraseña,
                'nombre' => $nombre,
                'email' => $email,
                'telContacto' => $telContacto,
                'codigoPostal' => $codigoPostal,
                'visaCliente' => $visaCliente
            ];
        }
    }

    return "No se encontraron datos para el usuario proporcionado.";
}



