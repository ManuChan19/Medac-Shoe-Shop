<?php
include_once '../../modelo/connect.php';
//Editar datos de usuarios
//El email sera la nueva idUsuario y usaremos $id en el WHERE
$idUsuario = $_POST['email'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$rol = $_POST['rol'];
$id = $_POST['idUsuario'];

$query = "UPDATE usuario 
          SET idUsuario = '{$idUsuario}', nombre = '{$nombre}', 
              apellidos = '{$apellido}', rol = '{$rol}' WHERE idUsuario = '{$id}'";
$result = mysqli_query($link, $query);

header('location: ../../vista/pantalla/admin/mainadmin.php');

?>