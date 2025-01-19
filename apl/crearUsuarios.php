<?php
require('functions.php');

$emailUsuario = $_SESSION['emailUsuario'];
$asuntoGestor = "Petición para añadir/modificar/borrar cliente";
$asuntoClienteCuenta = "Petición para la modificación/eliminación de la cuenta del cliente";
$asuntoClientePedido = "Petición de justificación del pedido rechazado";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    //enviar email

    if (isset($_POST['mensajeGestor'])) {
        $mensajeGestor = trim($_POST['mensajeGestor']); 
        $emailUsuario="paumorillasrivera129@gmail.com"; //Se ha cambiado para hacer pruebas y poder probar la app
    
        $cuerpoCorreo = nl2br(htmlspecialchars($mensajeGestor));
        enviarCorreo($emailUsuario,$cuerpoCorreo,$asuntoGestor);
    } 


    //enviar email cliente

    
    if (isset($_POST['mensajeClienteCuenta'])) {
        $mensajeCliente = trim($_POST['mensajeClienteCuenta']); 
        $emailUsuario="paumorillasrivera129@gmail.com"; //Se ha cambiado para hacer pruebas y poder probar la app
    
        $cuerpoCorreo = nl2br(htmlspecialchars($mensajeCliente));
        enviarCorreo($emailUsuario,$cuerpoCorreo,$asuntoClienteCuenta);
    }

    if (isset($_POST['mensajeClientePedido'])) {
        $mensajeCliente = trim($_POST['mensajeClientePedido']); 
        $emailUsuario="paumorillasrivera129@gmail.com"; //Se ha cambiado para hacer pruebas y poder probar la app
    
        $cuerpoCorreo = nl2br(htmlspecialchars($mensajeCliente));
        enviarCorreo($emailUsuario,$cuerpoCorreo,$asuntoClientePedido);
    } 

    // Crear Gestor
    if (isset($_POST['crearGestor']) && $_POST['crearGestor'] == "1") {
        $nombreUsuario = $_POST['usuarioGestor'];
        $nombre = $_POST['nombreGestor'];
        $idNumerico = $_POST['idGestor'];
        $contraseña = $_POST['contraseñaGestor'];
        $email = $_POST['emailGestor'];
        $telContacto = $_POST['telContactoGestor'];

        if (!validarContraseña($contraseña)) {
            echo '<div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; font-family: Arial, sans-serif; width: 80%; margin: 0 auto; margin-top: 20px;">
            <strong>La contraseña debe cumplir con los siguientes requisitos:</strong>
            <ul style="list-style-type: none; padding-left: 0;">
                <li>- Al menos 8 caracteres.</li>
                <li>- Al menos una letra mayúscula.</li>
                <li>- Al menos un número.</li>
                <li>- Al menos un carácter especial (@#$%^&*!).</li>
            </ul>
          </div>';
            echo '<br><a href="admin.php" style="display: block; text-align: center; margin-top: 20px;">
            <button type="button" style="background-color: red; color: white; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; border-radius: 5px;">
                Volver a la Página Principal
            </button>
          </a>';
        } else {
            if (evitarRepetidos($idNumerico, __DIR__ . "/../usuaris/usuarios.txt")) {
                header('Location: admin.php?creado=repetido');
            } else {
                crearUsuario($nombreUsuario, $idNumerico, $contraseña, $nombre, $email, $telContacto, "none","none","none", __DIR__ . "/../usuaris/usuarios.txt", "gestor");
            }
        }
    }

    // Modificar Gestor
    if (isset($_POST['modificarGestor']) && $_POST['modificarGestor'] == "1") {
        $nombreUsuario = $_POST['usuarioGestor'];
        $nombre = $_POST['nombreGestor'];
        $idNumerico = $_POST['idGestor'];
        $contraseña = $_POST['contraseñaGestor'];
        $email = $_POST['emailGestor'];
        $telContacto = $_POST['telContactoGestor'];

        if (!validarContraseña($contraseña)) {
            echo '<div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; font-family: Arial, sans-serif; width: 80%; margin: 0 auto; margin-top: 20px;">
            <strong>La contraseña debe cumplir con los siguientes requisitos:</strong>
            <ul style="list-style-type: none; padding-left: 0;">
                <li>- Al menos 8 caracteres.</li>
                <li>- Al menos una letra mayúscula.</li>
                <li>- Al menos un número.</li>
                <li>- Al menos un carácter especial (@#$%^&*!).</li>
            </ul>
          </div>';
            echo '<br><a href="index.php" style="display: block; text-align: center; margin-top: 20px;">
            <button type="button" style="background-color: red; color: white; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; border-radius: 5px;">
                Volver a la Página Principal
            </button>
          </a>';
        } else {
            modificarUsuario($idNumerico, $nombreUsuario, $contraseña, $nombre, $email, $telContacto, "08800","none","none", __DIR__ . "/../usuaris/usuarios.txt", "gestor");


        }
    }

    if(isset($_POST['eliminarGestor']) && $_POST['eliminarGestor']){
        $nombreUsuario = $_POST['usuarioGestor'];
        $nombre = $_POST['nombreGestor'];
        $idNumerico = $_POST['idGestor'];
        $contraseña = $_POST['contraseñaGestor'];
        $email = $_POST['emailGestor'];
        $telContacto = $_POST['telContactoGestor'];
        eliminarUsuario($idNumerico,__DIR__ . "/../usuaris/usuarios.txt");
    }

    if(isset($_POST['eliminarCliente']) && $_POST['eliminarCliente']){
        $nombreUsuario = $_POST['usuarioCliente'];
        $nombre = $_POST['nombreCliente'];
        $idNumerico = $_POST['idCliente'];
        $contraseña = $_POST['contraseñaCliente'];
        $email = $_POST['emailCliente'];
        $telContacto = $_POST['telContactoCliente'];
        $codigoPostal = $_POST['codigoPostalCliente'];
        $visaCliente = $_POST['visaCliente'];
        eliminarUsuario($idNumerico,__DIR__ . "/../usuaris/usuarios.txt");
    }
    // Crear Cliente
    if (isset($_POST['crearCliente']) && $_POST['crearCliente'] == "1") {
        $nombreUsuario = $_POST['usuarioCliente'];
        $nombre = $_POST['nombreCliente'];
        $idNumerico = $_POST['idCliente'];
        $contraseña = $_POST['contraseñaCliente'];
        $email = $_POST['emailCliente'];
        $telContacto = $_POST['telContactoCliente'];
        $codigoPostal = $_POST['codigoPostalCliente'];
        $visaCliente = $_POST['visaCliente'];
        $gestorAsignado = $_POST['gestorCliente'];

        if (!validarContraseña($contraseña)) {
            echo '<div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; font-family: Arial, sans-serif; width: 80%; margin: 0 auto; margin-top: 20px;">
            <strong>La contraseña debe cumplir con los siguientes requisitos:</strong>
            <ul style="list-style-type: none; padding-left: 0;">
                <li>- Al menos 8 caracteres.</li>
                <li>- Al menos una letra mayúscula.</li>
                <li>- Al menos un número.</li>
                <li>- Al menos un carácter especial (@#$%^&*!).</li>
            </ul>
          </div>';
            echo '<br><a href="admin.php" style="display: block; text-align: center; margin-top: 20px;">
            <button type="button" style="background-color: red; color: white; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; border-radius: 5px;">
                Volver a la Página Principal
            </button>
          </a>';
        } else {
            crearUsuario($nombreUsuario, $idNumerico, $contraseña, $nombre, $email, $telContacto, $codigoPostal,$visaCliente,$gestorAsignado,__DIR__ . "/../usuaris/usuarios.txt", "cliente");
        }
    }

    // Modificar Cliente
    if (isset($_POST['modificarCliente']) && $_POST['modificarCliente'] == "1") {
        $nombreUsuario = $_POST['usuarioCliente'];
        $nombre = $_POST['nombreCliente'];
        $idNumerico = $_POST['idCliente'];
        $contraseña = $_POST['contraseñaCliente'];
        $email = $_POST['emailCliente'];
        $telContacto = $_POST['telContactoCliente'];
        $codigoPostal = $_POST['codigoPostalCliente'];
        $gestorAsignado = $_POST['gestorCliente'];
        $visaCliente = $_POST['visaCliente'];

        if (!validarContraseña($contraseña)) {
            echo '<div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; font-family: Arial, sans-serif; width: 80%; margin: 0 auto; margin-top: 20px;">
            <strong>La contraseña debe cumplir con los siguientes requisitos:</strong>
            <ul style="list-style-type: none; padding-left: 0;">
                <li>- Al menos 8 caracteres.</li>
                <li>- Al menos una letra mayúscula.</li>
                <li>- Al menos un número.</li>
                <li>- Al menos un carácter especial (@#$%^&*!).</li>
            </ul>
          </div>';
            echo '<br><a href="index.php" style="display: block; text-align: center; margin-top: 20px;">
            <button type="button" style="background-color: red; color: white; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; border-radius: 5px;">
                Volver a la Página Principal
            </button>
          </a>';
        } else {
            modificarUsuario($idNumerico, $nombreUsuario, $contraseña, $nombre, $email, $telContacto, $codigoPostal,$visaCliente,$gestorAsignado, __DIR__ . "/../usuaris/usuarios.txt", "cliente");
        }
    }

    // Modificar Admin
    if (isset($_POST['modificarAdmin']) && $_POST['modificarAdmin'] == '1') {
        // Obtener los datos del formulario
        $nombreAdmin = $_POST['usuarioAdmin'];
        $passwordAdmin = $_POST['contraseñaAdmin'];
        $emailAdmin = $_POST['emailAdmin'];

        // Validar la contraseña
        if (!validarContraseña($passwordAdmin)) {
            echo '<div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; font-family: Arial, sans-serif; width: 80%; margin: 0 auto; margin-top: 20px;">
            <strong>La contraseña debe cumplir con los siguientes requisitos:</strong>
            <ul style="list-style-type: none; padding-left: 0;">
                <li>- Al menos 8 caracteres.</li>
                <li>- Al menos una letra mayúscula.</li>
                <li>- Al menos un número.</li>
                <li>- Al menos un carácter especial (@#$%^&*!).</li>
            </ul>
          </div>';
            // Mostrar botón para volver a la página principal
            echo '<br><a href="index.php" style="display: block; text-align: center; margin-top: 20px;">
            <button type="button" style="background-color: red; color: white; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; border-radius: 5px;">
                Volver a la Página Principal
            </button>
          </a>';
        } else {
            // Si la contraseña es válida, la guardamos
            $idAdmin = "01"; // Este es el ID del admin, asegúrate de obtenerlo correctamente
            $filename = __DIR__.'/../usuaris/usuarios.txt';

            // Llamar a la función para modificar los datos del admin
            modificarAdmin($idAdmin, $nombreAdmin, $passwordAdmin, $emailAdmin, $filename);

            // Mostrar botón para volver a la página principal después de la modificación
            echo '<br><a href="index.php"><button type="button">Volver a la Página Principal</button></a>';
        }
    }

}
?>
