<?php
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['name']) && $_SESSION['rol'] == 'admin') {
    require_once '../../../modelo/connect.php';
    require_once '../../../modelo/admin/tablaadmin.php';

?>
<!-- Gestion de usuarios -->
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Inicio Admin</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' type='text/css' media='screen' href='../../css/main.css'>

        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    </head>

    <body>
        <header>
            <img id="logo" src="../../img/logo.png" alt="">
            <a href="mainadmin.php"><button>Control Usuarios</button></a>
            <a href="productoadmin.php"><button>Control Producto</button></a>
            <a href="../user/main.php"><button>Principal</button></a>
            <a href="../user/Inicio.php"><button>Mi cuenta</button></a>
            <a href="../user/carrito.php" id="acarrito"><div><span id="spancarrito"></span><img id="imagencarrito" src="../../img/Carrito.png" alt=""></div></a>

        </header>
        <main>
<!-- Crear nuevo usuario -->
            <div class="nuevoButton">
                <button onclick="nuevoUsuario()">Nuevo Usuario</button>
            </div>
            <div class="form">
                <form action="../../../controlador/admin/editarusuario.php" style="visibility: hidden;" id="usuarioForm" method="POST">
                    Email:<input type="email" id="email" name="email" class="input" required><br>
                    Nombre:<input type="text" id="nombre" name="nombre" class="input"><br>
                    Apellidos:<input type="text" id="apellido" name="apellido" class="input"><br>
                    Rol:<select id="rol" name="rol" required class="input">
                        <option value="user">user</option>
                        <option value="admin">admin</option>
                    </select><br>
                    <input type="hidden" id="idUsuario" name="idUsuario" class="input">
                    <button type="submit" id="submitUser">Aceptar</button>
                </form>
            </div>
            <!-- tabla con los usuarios -->
            <div class="table">
                <table id="tablaUsuario">
                    <tr>
                        <th>idUsuario</th>
                        <th>nombre</th>
                        <th>apellido</th>
                        <th>rol</th>
                    </tr>

                    <tbody id="tbodyadmin">
                        <?php cargarTabla(); ?>
                    </tbody>
                </table>
            </div>

        </main>
        <script src='../../js/main.js'></script>
    </body>
<?php
} else {
    header('location:../../../vista/pantalla/user/Inicio.php ');
}
?>