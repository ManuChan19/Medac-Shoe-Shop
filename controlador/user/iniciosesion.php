<?php
require_once '../../modelo/connect.php';
//Inicio de sesion
if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $usuario=$_POST["email"];
    $contraseña=$_POST["password"];
}
//comprobamos que idusuario y contraseña coinciden
$query= "SELECT * FROM usuario WHERE (idUsuario = '{$usuario}' AND contraseña = '{$contraseña}')";
$result = mysqli_query($link, $query) or die ('consulta fallida');
$resultado= mysqli_fetch_assoc($result);
if ($result==null){
    header("location:../../vista/pantalla/user/Inicio.php");
    exit();
}else {
    //Iniciamos sesion
    session_start();
    $_SESSION['name']=$resultado['nombre'];
    $_SESSION['user']=$resultado['idUsuario'];
    $_SESSION['apellido']=$resultado['apellidos'];
    $_SESSION['rol']=$resultado['rol'];
    $_SESSION['pass']=$resultado['pass'];
    header("location:../../vista/pantalla/user/main.php");
    exit();
}
mysqli_close($link);
echo 'cerramos bd';
?>