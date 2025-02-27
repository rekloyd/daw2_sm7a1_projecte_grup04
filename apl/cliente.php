<?php

require("functions.php");

// Verificar variables y sesiones
$usuario = isset($_SESSION['username']) ? $_SESSION['username'] : $_SESSION['username'] = "AdministradorTest";
$tipoUsuario = $_SESSION['tipoUsuario'];
$emailUsuario = isset($_SESSION['emailUsuario']) ? $_SESSION['emailUsuario'] : $_SESSION['emailUsuario'] = "thedark3slol@gmail.com";

if ($tipoUsuario != "cliente") {
    header("Location: index.php");
}



if (isset($_POST['exportar_pdf_cliente'])) {
    exportarTablaPDF(__DIR__ . '/../usuarios.txt', 'cliente');
}


// Leer datos del archivo usuarios.txt
$archivoUsuarios = __DIR__ . '/../usuarios.txt';
$usuarios = file_exists($archivoUsuarios) ? file($archivoUsuarios, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];
?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Creación de Gestores</title>
    <style>
        .whiteText {
            color: white;
        }

        .center {
            text-align: center;
        }

        .adminContainer {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .main-container {
            display: flex;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #2c3e50;
            padding: 20px 10px;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            margin-bottom: 15px;
            background-color: #34495e;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 16px;
        }

        .sidebar ul li:hover {
            background-color: #1abc9c;
            color: white;
        }

        .contenido {
            margin-left: 270px;
            /* Espacio para la sidebar */
            padding: 20px;
            flex: 1;
        }

        .form-container {
            background-color: #f4f4f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            margin: 0 auto;

        }

        .form-container h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #2c3e50;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .form-group input {
            width: 95%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group input:focus {
            border-color: #1abc9c;
            outline: none;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            color: #fff;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-group button:hover {
            background-color: rgb(71, 78, 76);
        }

        .oculto {
            display: none;
        }

        .mostrando {
            display: block;
        }

        .botonesCRUD {
            margin-top: 10px;
        }

        .botonCrear {
            background-color: rgb(6, 112, 91);
        }

        .botonEliminar {
            background-color: rgb(189, 27, 9);
        }

        .botonModificar {
            background-color: rgb(188, 153, 12);
        }

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

        a {
            display: inline-block;
            text-decoration: none;
            color: white;
            background-color: #1abc9c;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        a:hover {
            background-color: #16a085;
        }

        .areaEmail {
            height: 30vh;
            ;
            width: 100%;
            resize: none;
        }
    </style>
</head>

<body class="adminContainer">
    <div class="main-container">
        <div class="sidebar">
            <h1 class="whiteText">Bienvenido a tu área personal</h1>
            <?php
            echo "<h3 class='whiteText'>$usuario</h3>";
            ?>
            <ul>
                <ul>
                    <!--<li onclick="toggleContenido(1)">Gestionar Gestores</li>-->
                    <li onclick="toggleContenido(2)">Mis datos</li>
                    <li onclick="toggleContenido(3)">Solicitud de eliminación de mi cuenta</li>
                    <li onclick="toggleContenido(4)">Contacto con el gestor</li>
                    <br>
                    <li onclick="window.location.href = 'index.php'">Volver al Inicio</li>

                </ul>

            </ul>
        </div>

        <div class="contenido">
            <h2 class="center" id="mensajeEnter">Desde aquí puedes ver tu información, contactar con el gestor y ver tus pedidos</h2>
            <div class="flex-container">
                <div class="form-container formulario-1 form-select oculto">
                    <h2>Formulario de Creación de Gestores</h2>
                    <form action="/crearUsuarios.php" method="post">
                        <div class="form-group">
                            <label for="username">Imagen</label>
                            <input type="text" id="username" name="usuarioGestor" required>
                        </div>
                        <div class="form-group">
                            <label for="identifier">Identificador Numérico</label>
                            <input type="number" id="identifierGestor" name="idProducto" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Nombre</label>
                            <input type="password" id="passwordGestor" name="nombreProducto" required>
                        </div>
                        <div class="form-group">
                            <label for="fullname">Precio</label>
                            <input type="text" id="fullnameGestor" name="nombreGestor" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Disponibilidad</label>
                            <input type="email" id="emailGestor" name="disponibilidadProducto" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="crearGestor" value="1" class="botonesCRUD botonCrear">Crear Gestor</button>
                            <button type="submit" name="eliminarGestor" value="1" class="botonesCRUD botonEliminar">Eliminar Gestor</button>
                            <button type="submit" name="modificarGestor" value="1" class="botonesCRUD botonModificar">Modificar Gestor</button>
                        </div>
                    </form>
                </div>

                <div class="formulario-8 form-select oculto">
                    <h3>Listado de Gestores</h3>
                    <?php generarTabla(__DIR__ . "/../usuarios.txt", "gestor"); ?>
                    <form method="post">
                        <button type="submit" name="exportar_pdf_gestor">Exportar PDF (Gestores)</button>
                    </form>

                </div>
            </div>

            <!--FORMULARIO PRODUCTOS-->
            <div class="form-container formulario-2  form-select">
                <?php

                // Obtener el nombre de usuario desde la sesión
                $usuario = isset($_SESSION['username']) ? $_SESSION['username'] : $_SESSION['username'] = "AdministradorTest";

                // Llamar a la función para obtener los datos del usuario
                $datosUsuario = obtenerDatosMiUsuario(__DIR__ . "/../usuaris/usuarios.txt", $usuario);
                ?>

                <h2>Datos sobre mí</h2>

                <?php if (is_array($datosUsuario)) { ?>
                    <p><strong>Nombre de Usuario:</strong> <?php echo htmlspecialchars($datosUsuario['nombreUsuario']); ?></p>
                    <p><strong>Nombre Completo:</strong> <?php echo htmlspecialchars($datosUsuario['nombre']); ?></p>
                    <p><strong>Contraseña: *********</strong></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($datosUsuario['email']); ?></p>
                    <p><strong>Teléfono:</strong> <?php echo htmlspecialchars($datosUsuario['telContacto']); ?></p>
                    <p><strong>Código Postal:</strong> <?php echo htmlspecialchars($datosUsuario['codigoPostal']); ?></p>
                    <p><strong>Visa Cliente: XXXXXXX<strong></p>
                    <p><i>Si desea cambiar o ver algún valor, por favor contacte con el gestor.</i></p>
                <?php } else { ?>
                    <p><?php echo htmlspecialchars($datosUsuario); ?></p>
                <?php } ?>

                <div class="formulario-5 form-select oculto">
                    <h3>Listado de Clientes</h3>
                    <?php generarTabla(__DIR__ . "/../usuaris/usuarios.txt", "cliente"); ?>
                    <form method="post">
                        <button type="submit" name="exportar_pdf_cliente" style="background-color: green; color: white; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; border-radius: 5px;">Exportar PDF (Clientes)</button>
                    </form>

                </div>

            </div>

            <div class="form-container formulario-3 oculto form-select">
                    <h2>Envia un correo al Administrador </h2>
                    <form action="crearUsuarios.php" method="post">
                        <div class="form-group">
                            <p><strong>Asunto: Petición para la modificación/eliminación de la cuenta del cliente</strong></p>
                        </div>

                        <div class="form-group">
                            <label for="mensajeGestor">Mensaje</label>
                            <textarea id="mensajeGestor" name="mensajeClienteCuenta" class="areaEmail" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="enviarEmailClienteCuenta" value="1" class="botonesCRUD botonCrear">Envia Email</button>
                        </div>
                    </form>
                </div>


                <div class="form-container formulario-4 oculto form-select">
                    <h2>Envia un correo al Administrador </h2>
                    <form action="crearUsuarios.php" method="post">
                        <div class="form-group">
                            <p><strong>Asunto: Petición de justificación de pedido rechazado</strong></p>
                        </div>

                        <div class="form-group">
                            <label for="mensajeGestor">Mensaje</label>
                            <textarea id="mensajeGestor" name="mensajeClientePedido" class="areaEmail" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="enviarEmailClientePedido" value="1" class="botonesCRUD botonCrear">Envia Email</button>
                        </div>
                    </form>
                </div>




        </div>

    </div><!--final div contenido-->
    <script>
        function toggleContenido(num) {
            var allForms = document.querySelectorAll('.form-select');
            allForms.forEach(function(form) {
                form.classList.add('oculto');
            });

            var selectedForm = document.querySelector('.formulario-' + num);
            selectedForm.classList.remove('oculto');
        }
    </script>
</body>

</html>