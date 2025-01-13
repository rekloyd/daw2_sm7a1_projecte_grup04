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
    }
        

    ?>
</body>
</html>
