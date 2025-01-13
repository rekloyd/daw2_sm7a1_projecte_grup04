<?php
require('modificarUsuarios.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($_POST['crearGestor'] == "1") {
        $nombreUsuario = $_POST['usuarioGestor'];
        $nombre = $_POST['nombreGestor'];
        $idNumerico = $_POST['idGestor'];
        $contraseña = $_POST['contraseñaGestor'];
        $email = $_POST['emailGestor'];
        $telContacto = $_POST['telContactoGestor'];

        // Evitar usuarios repetidos antes de crear
        if (evitarRepetidos($idNumerico, __DIR__ . "/usuarios.txt")) {
            echo "El ID de usuario ya está registrado.<br>";
        } else {
            crearUsuario($nombreUsuario, $idNumerico, $contraseña, $nombre, $email, $telContacto, "null", __DIR__ . "/usuarios.txt", "gestor");
        }
    }elseif ($_POST['crearCliente'] == "1"){
        $nombreUsuario = $_POST['usuarioCliente'];
        $nombre = $_POST['nombreCliente'];
        $idNumerico = $_POST['idCliente'];
        $contraseña = $_POST['contraseñaCliente'];
        $email = $_POST['emailCliente'];
        $telContacto = $_POST['telContactoCliente'];
        $codigoPostal = $_POST['codigoPostalCliente'];
        crearUsuario($nombreUsuario, $idNumerico, $contraseña, $nombre, $email, $telContacto, $codigoPostal, __DIR__ . "/usuarios.txt", "cliente");
    }
}
?>
