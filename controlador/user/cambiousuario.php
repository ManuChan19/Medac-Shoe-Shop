<?php
include_once '../../modelo/connect.php';
//Cambiar info del usuario
//El email sera la nueva idUsuario y usaremos $id en el WHERE
$idUsuario = $_POST['editemail'];
$nombre = $_POST['editnombre'];
$apellido = $_POST['editapellido'];
$oldpass = $_POST['oldpassword'];
$newpass = $_POST['newpassword'];
$newpass2 = $_POST['newpassword2'];
$id = $_POST['editidUsuario'];
//Comprobamos que la contraseña antigua es la que estaba en la bbdd
if ($newpass == $newpass2) {
    $query = "UPDATE usuario 
    SET idUsuario = '{$idUsuario}', nombre = '{$nombre}', 
        apellidos = '{$apellido}', contraseña = '{$newpass}' WHERE (idUsuario = '{$id}' && contraseña = '{$oldpass}')";
    $result = mysqli_query($link, $query);
    header('location:../../vista/pantalla/user/main.php');
    if ($result == null) {
        header('location:../../vista/pantalla/user/Inicio.php');
        exit();
    }
} else {
    echo 'Las contraseñas deben ser iguales';
}
