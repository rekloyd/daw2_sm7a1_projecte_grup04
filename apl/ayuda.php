<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AliMorillas</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
</head>
<?php
session_start();

// Verificar si existe la clave 'username' en la sesión
$usuario = isset($_SESSION['username']) ? $_SESSION['username'] : NULL;
$tipoUsuario = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : NULL;
?>
<body>
    <header>
        <div class="logo">
            <h1>AliMorillas</h1>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="#">Categorías</a></li>
                <li><a href="ayuda.php" style="text-decoration: underline;">Ayuda</a></li>
                <li><a href="carrito.php">Carrito</a></li>
                <?php
                    if ($usuario) {
                        echo "<li style=\"color:blue; font-weight:bold;\"><a href='areasPersonales.php?tipo=" . $tipoUsuario . "' style='color:inherit;'>Hola, " . strtoupper(htmlspecialchars($usuario)) . "</a></li>";

                        echo "<li><a href='logout.php' class='log-in'>Cerrar sesión</a></li>";
                    } else {
                        echo "<li><a href='signup.html' class='sign-up' style='color: #333;'>Sign Up</a></li>";
                        echo "<li><a href='login.html' class='log-in'>Log In</a></li>";
                    }
                ?>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Banner principal -->
        <section class="banner">
            <h2>Funcionamiento de la página</h2>
        </section>

        <!-- Funciones de la página -->
        <div class="center">
            <h4>Recreación de la página:</h4>
            <p>Esta página simula un E-Commerce similar a <i>AliExpress</i> (antes del cambio de estilos en 2024) sin
                bases de datos.</p>
            <hr>
            <h4>Usuarios:</h4>
            <p>Permite el acceso y la creación de tres tipos de usuario:</p>
            <p><strong>Administrador:</strong> solo existe un administrador.</p>
            <p style="font-size: 14px;">(Creado por defecto admin:FjeClot2425#).</p>
            <p><strong>Gestor:</strong> puede haber uno o más gestores.</p>
            <p><strong>Cliente:</strong> puede haber uno o más clientes.</p>
            <hr>
            <h4>Funciones de los usuarios:</h4>
            <p><strong>Administrador:</strong></p>
            <p>• El administrador tiene una cuenta predefinida: usuario <code>admin</code>, contraseña
                <code>FjeClot2425#</code>, y correo <code>admin@fjeclot.net</code>.</p>
            <p>• Puede modificar su propio nombre de usuario, contraseña y correo electrónico.</p>
            <p>• Crear gestores de la tienda con información como:</p>
            <p> ○ Nombre de usuario, identificador numérico, contraseña, nombre completo, correo electrónico y teléfono
                de contacto.</p>
            <p>• Gestionar clientes:</p>
            <p> ○ Crear clientes con datos como: nombre de usuario, identificador numérico, contraseña, nombre completo,
                correo electrónico, teléfono de contacto, dirección postal, número de tarjeta Visa y gestor asignado.
            </p>
            <p> ○ Ver una lista ordenada de gestores o clientes y exportarla a PDF.</p>
            <p> ○ Modificar cualquier dato de un gestor o cliente.</p>
            <p> ○ Eliminar gestores o clientes, incluyendo las carpetas relacionadas con estos últimos.</p>
            <p><strong>Restricciones de contraseñas:</strong></p>
            <p>• Las contraseñas deben cumplir con requisitos mínimos de seguridad.</p>
            <p>• Las contraseñas se guardan de forma segura mediante hashing.</p>
            <hr>
            <p><strong>Gestores:</strong></p>
            <p>• Pueden ver una lista ordenada de clientes con sus datos.</p>
            <p>• Pueden enviar peticiones al administrador para añadir, modificar o eliminar clientes mediante un
                formulario con el asunto correspondiente.</p>
            <hr>
            <p><strong>Catálogo de productos:</strong></p>
            <p>• Un producto incluye: nombre, número identificador, precio (con IVA indicado) y disponibilidad.</p>
            <p>• Los productos se guardan en un archivo dentro de la carpeta <code>tienda</code>.</p>
            <p>• Los gestores pueden:</p>
            <p> ○ Añadir nuevos productos con sus características.</p>
            <p> ○ Modificar o eliminar productos existentes.</p>
            <p> ○ Visualizar y exportar a PDF una lista ordenada de productos.</p>
            <p><strong>Restricciones:</strong></p>
            <p>• Usuarios no autenticados no tienen acceso a las áreas de gestión de productos.</p>
            <p>• Los clientes no pueden ver ni acceder a las áreas de gestión de productos.</p>
            <p>• El administrador no tiene acceso a la gestión de productos.</p>
            <hr>
            <h4>Gestión del área personal de los clientes:</h4>
            <p><strong>Funciones disponibles para los clientes:</strong></p>
            <p>• Visualizar sus datos personales.</p>
            <p>• Enviar un correo a su gestor de la tienda solicitando una modificación o la eliminación de su cuenta de
                usuario.</p>
            <p> ○ El contenido del correo es libre, pero debe enviarse desde un formulario dentro de la aplicación con
                el asunto: "solicitud de modificación/eliminación de cuenta de cliente".</p>
            <p>• Enviar un correo a su gestor solicitando el motivo por el cual un pedido ha sido rechazado.</p>
            <p> ○ El contenido del correo es libre, pero debe enviarse desde un formulario dentro de la aplicación con
                el asunto: "solicitud de justificación de pedido rechazado".</p>
            <p>• Gestionar su carrito y pedido:</p>
            <p> ○ Un carrito se convierte en un pedido cuando el cliente acepta la compra con su precio final.</p>
            <p> ○ El carrito y el pedido se guardan en archivos dentro de las carpetas <code>carritos</code> y
                <code>pedidos</code>, respectivamente.</p>
            <p><strong>Restricciones:</strong></p>
            <p>• Los usuarios no autenticados y el administrador no pueden ver ni acceder al área personal de los
                clientes.</p>
            <p>• Los gestores no pueden crear ni modificar pedidos o carritos.</p>
        </div>

        <!-- Funciones página -->
    </main>

    <footer>
        <p>&copy; 2024 AliMorillas. Todos los derechos reservados.</p>
    </footer>
</body>

</html>