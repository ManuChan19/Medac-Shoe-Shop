<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Inicio Sesion</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../css/main.css'>

</head>

<?php
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['name'])) {
    /*Codigo HTML si tiene iniciada session*/
?>

    <body>
        <header>
        <img id="logo" src="../../img/logo.png" alt="">
            <?php
            if ($_SESSION['rol'] == 'admin') { ?>
                <a href="../admin/mainadmin.php"><button>Control Usuarios</button></a>
                <a href="../admin/productoadmin.php"><button>Control Producto</button></a>
            <?php
            }
            ?>
            <a href="main.php"><button>Principal</button></a>

        </header>
        <main>
            <!-- Formulario para cambiar datos -->
            <form action='../../../controlador/user/cambiousuario.php' method="POST">
                Email:<input type="email" id="editemail" name="editemail" class="input" required value="<?php echo $_SESSION['user'] ?>"><br>
                Nombre:<input type="text" id="editnombre" name="editnombre" class="input" required value="<?php echo $_SESSION['name'] ?>"><br>
                Apellidos:<input type="text" id="editapellido" name="editapellido" class="input" value="<?php echo $_SESSION['apellido'] ?>"><br>
                Contraseña Antigua:<input type="password" name="oldpassword" id="oldPassword" class="input" placeholder="Contraseña actual" required><br>
                Nueva contraseña: <input type="password" name="newpassword" id="newPassword" class="input" placeholder="Nueva contraseña"><br>
                Repite contraseña: <input type="password" name="newpassword2" id="newPassword2" class="input" placeholder="Repita contraseña"><br>
                <input type="hidden" id="EditidUsuario" name="editidUsuario" class="input" value="<?php echo $_SESSION['user'] ?>">
                <button type="submit" id="submitEditUser">Aceptar</button>

            </form>
            <a href="../../../controlador/user/cerrarsesion.php"><button>Cerrar Sesión</button></a>
        </main>
    </body>

<?php } else {
    //Codigo HTML si no tiene sesion iniciada
?>

    <body>
        <header>
            <button>Mi cuenta</button>
            <button>Favoritos</button>
            <button>Carrito</button>
        </header>
        <main>
            <div>
                <!-- Inicio de sesion -->
                <form action="../../../controlador/user/iniciosesion.php" method="post" id="inicio">
                    <fieldset>
                        Usuario <input type="email" name="email" id="usuario" placeholder="Escribe tu correo de usuario" required>
                        Contraseña <input type="password" name="password" id="userpassword" placeholder="Escribe tu contraseña" required>
                        <input type="submit" value="LogIn">
                    </fieldset>
                </form>
            </div>
            <div>
                <!-- Registrarte como usuario -->
                <form action="../../../controlador/user/codigoregistro.php" method="post" id="registro">
                    <fieldset>
                        Nombre: <input type="text" name="name" id="name" placeholder="Nombre"><br>
                        Apellidos: <input type="text" name="apellido" id="apellido" placeholder="Apellidos"><br>
                        Email: <input type="email" name="email" id="email" placeholder="Correo electronico" required><br>
                        Contraseña: <input type="password" name="password" id="password" placeholder="Contraseña" required><br>
                        Confirma contraseña: <input type="password" name="password2" id="password2" placeholder="Repite contraseña" required><br>
                        <button type="submit">Registrar</button>
                    </fieldset>
                </form>
            </div>

        </main>
        <script src='../../js/main.js'></script>
    </body>
<?php } ?>

</html>