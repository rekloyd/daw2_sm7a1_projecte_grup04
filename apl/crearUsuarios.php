<?php
require('modificarUsuarios.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        if (isset($_POST['crearGestor']) && $_POST['crearGestor'] == "1") {
            $nombreUsuario = $_POST['usuarioGestor'];
            $nombre = $_POST['nombreGestor'];
            $idNumerico = $_POST['idGestor'];
            $contraseña = $_POST['contraseñaGestor'];
            $email = $_POST['emailGestor'];
            $telContacto = $_POST['telContactoGestor'];
            //$contraseña = hash('sha256', $contraseña); // Encriptar contraseña
    
            evitarRepetidos($idNumerico, __DIR__ . "/usuarios.txt");
            crearUsuario($nombreUsuario, $idNumerico, $contraseña, $nombre, $email, $telContacto, "null", __DIR__ . "/usuarios.txt", "gestor");
        }
        
        //CRUD DEL GESTOR
    
        if ($_POST['crearGestor'] == "1") {
                $nombreUsuario = $_POST['usuarioGestor'];
                $nombre = $_POST['nombreGestor'];
                $idNumerico = $_POST['idGestor'];
                $contraseña = $_POST['contraseñaGestor'];
                $email = $_POST['emailGestor'];
                $telContacto = $_POST['telContactoGestor'];
        
                if (evitarRepetidos($idNumerico, __DIR__ . "/usuarios.txt")) {
                    header('Location: admin.php?creado=repetido');
                }
                } elseif(crearUsuario($nombreUsuario, $idNumerico, $contraseña, $nombre, $email, $telContacto, "null", __DIR__ . "/usuarios.txt", "gestor");
                    header('Location: admin.php?creado=exito');
                ) {
                }elseif ($_POST['modificarGestor'] == "1") {
                    $nombreUsuario = $_POST['usuarioGestor'];
                    $nombre = $_POST['nombreGestor'];
                    $idNumerico = $_POST['idGestor'];
                    $contraseña = $_POST['contraseñaGestor'];
                    $email = $_POST['emailGestor'];
                    $telContacto = $_POST['telContactoGestor'];
            
                    if (evitarRepetidos($idNumerico, __DIR__ . "/usuarios.txt")) {
                    header('Location: admin.php?creado=repetido')
                    } else {
                        modificarUsuario($nombreUsuario, $idNumerico, $contraseña, $nombre, $email, $telContacto, "null", __DIR__ . "/usuarios.txt", "gestor");
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
</body>
</html>
