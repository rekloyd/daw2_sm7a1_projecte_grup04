<?php

require("functions.php");

// Verificar variables y sesiones
$usuario = isset($_SESSION['username']) ? $_SESSION['username'] : $_SESSION['username'] = "AdministradorTest";
$tipoUsuario = $_SESSION['tipoUsuario'];
if($tipoUsuario!= "admin"){
    header("Location: index.php");
}

if (isset($_POST['exportar_pdf_gestor'])) {
    exportarTablaPDF(__DIR__ . "/../usuaris/usuarios.txt", 'gestor'); 
} elseif (isset($_POST['exportar_pdf_cliente'])) {
    exportarTablaPDF(__DIR__ . "/../usuaris/usuarios.txt", 'cliente'); 
}



// Leer datos del archivo usuarios.txt
$archivoUsuarios = __DIR__ . '/../usuaris/usuarios.txt';
$usuarios = file_exists($archivoUsuarios) ? file($archivoUsuarios, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) : [];


$gestores = [];

foreach ($usuarios as $linea) {

    $campos = explode(":", $linea);


    if (isset($campos[9]) && trim($campos[9]) === 'gestor') {

        $gestores[$campos[0]] = $campos[1]; 
    }
}


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

        .form-group select {
            width: 95%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .form-group select:focus {
            border-color: #1abc9c;
            outline: none;
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
                    <li onclick="toggleContenido(1)">Gestionar Gestores</li>
                    <li onclick="toggleContenido(2)">Gestionar Usuarios</li>
                    <li onclick="toggleContenido(3)">Gestionar tus datos de inicio de sesión</li>
                    <li onclick="toggleContenido(4)">Ver gestores actuales</li>
                    <li onclick="toggleContenido(5)">Ver listado de clientes</li>
                    <br>
                    <li onclick="window.location.href = 'index.php'">Volver al Inicio</li>

                </ul>

            </ul>
        </div>

        <div class="contenido">
            <div class = "flex-container">
            <div class="form-container formulario-1 form-select oculto">
                <h2>Formulario de Creación de Gestores</h2>
                <form action="./crearUsuarios.php" method="post">
                    <div class="form-group">
                        <label for="username">Nombre de Usuario</label>
                        <input type="text" id="username" name="usuarioGestor" required>
                    </div>
                    <div class="form-group">
                        <label for="identifier">Identificador Numérico</label>
                        <input type="number" id="identifierGestor" name="idGestor" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="passwordGestor" name="contraseñaGestor" required>
                    </div>
                    <div class="form-group">
                        <label for="fullname">Nombre y Apellidos</label>
                        <input type="text" id="fullnameGestor" name="nombreGestor" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="emailGestor" name="emailGestor" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Teléfono de Contacto</label>
                        <input type="tel" id="phoneGestor" name="telContactoGestor" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="crearGestor" value="1" class="botonesCRUD botonCrear">Crear Gestor</button>
                        <button type="submit" name="eliminarGestor" value="1" class="botonesCRUD botonEliminar">Eliminar Gestor</button>
                        <button type="submit" name="modificarGestor" value="1" class="botonesCRUD botonModificar">Modificar Gestor</button>
                    </div>
                </form>
            </div>

            <div class="formulario-4 form-select oculto">
                <h3>Listado de Gestores</h3>
                <?php generarTabla(__DIR__ . "/../usuaris/usuarios.txt","gestor"); ?>
                <form method="post">
                <button type="submit" name="exportar_pdf_gestor" style="background-color: green; color: white; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; border-radius: 5px;">Exportar PDF (Gestores)</button>

                </form>

            </div>
        </div>

            <!--FORMULARIO CLIENTES-->
            <div class="form-container formulario-2  form-select oculto">
                        <h2>Formulario de Creación de Clientes</h2>
                        <form action="./crearUsuarios.php" method="post">
                            <div class="form-group">
                                <label for="username">Nombre de Usuario</label>
                                <input type="text" id="username" name="usuarioCliente" required>
                            </div>
                            <div class="form-group">
                                <label for="identifier">Identificador Numérico</label>
                                <input type="number" id="identifierCliente" name="idCliente" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" id="passwordCliente" name="contraseñaCliente" required>
                            </div>
                            <div class="form-group">
                                <label for="fullname">Nombre y Apellidos</label>
                                <input type="text" id="fullnameCliente" name="nombreCliente" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" id="emailCliente" name="emailCliente" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Teléfono de Contacto</label>
                                <input type="tel" id="phoneCliente" name="telContactoCliente" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Dirección Postal</label>
                                <input type="tel" id="adressCliente" name="codigoPostalCliente" required>
                            </div>
                            <div class="form-group">
                                <label for="phone">Visa del cliente</label>
                                <input type="tel" id="visaCliente" name="visaCliente" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Asignar gestor</label>
                                <select name="gestorCliente" id="gestores">
                                <option value="">Seleccione un gestor</option>
                                <?php foreach ($gestores as $id => $nombre): ?>
                                    <!-- Usamos el nombre como value -->
                                    <option value="<?= htmlspecialchars($nombre) ?>"><?= htmlspecialchars($nombre) ?></option>
                                <?php endforeach; ?>
                            </select>

                            </div>
                                <div class="form-group">
                                <button type="submit" name="crearCliente" value ="1" class="botonesCRUD botonCrear">Crear Cliente</button>
                                <button type="submit" name="eliminarCliente" value = "1" class="botonesCRUD botonEliminar">Eliminar Cliente</button>
                                <button type="submit" name="modificarCliente" value = "1" class="botonesCRUD botonModificar">Modificar Cliente</button>
                            </div>
                        </form>
                    </div>
                    <div class="formulario-5 form-select oculto">
                <h3>Listado de Clientes</h3>
                <?php generarTabla(__DIR__ . "/../usuaris/usuarios.txt","cliente"); ?>
                <form method="post">
                    <button type="submit" name="exportar_pdf_cliente" style="background-color: green; color: white; border: none; padding: 10px 20px; font-size: 16px; cursor: pointer; border-radius: 5px;">Exportar PDF (Clientes)</button>
                </form>

            </div>


    <!--FORMULARIO AMINISTRADOR-->
    <div class="form-container formulario-3 oculto form-select">
                        <h2>Formulario de Modificación de los datos del Admin </h2>
                        <form action="./crearUsuarios.php" method="post">
                            <div class="form-group">
                                <label for="username">Nombre de Usuario</label>
                                <input type="text" id="usernameAdmin" name="usuarioAdmin" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" id="passwordAdmin" name="contraseñaAdmin" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" id="emailAdmin" name="emailAdmin" required>
                            </div>
                                <div class="form-group">
                                <button type="submit" name="modificarAdmin" value = "1" class="botonesCRUD botonModificar">Modificar Datos</button>
                            </div>
                        </form>
                    </div>


        </div>



    </div>

    </div><!--final div contenido-->
    <script>
        //mostrar el contenido en función del item seleccionado en el sidebar
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