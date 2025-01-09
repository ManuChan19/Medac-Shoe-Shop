<?php
require_once '../../modelo/connect.php';
//Registro en el sistema
if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $nombre=$_POST["name"];
    $apellido=$_POST["apellido"];
    $usuario=$_POST["email"];
    $contraseña=$_POST["password"];
    $contraseña2=$_POST["password2"];  
}
//Comprobamos que repite la contraseña
if ($contraseña !== $contraseña2){
    echo "Las contraseñas deben coincidir.";
}else {
//comprobamos que el mail no este en la base de datos
$query= "SELECT idUsuario FROM usuario WHERE (idUsuario = '{$usuario}')";
$result = mysqli_query($link, $query) or die ('consulta fallida');
$resultado = mysqli_fetch_assoc($result);
mysqli_free_result($result);

if ($resultado['idUsuario'] == $usuario){
    echo 'El usuario ya existe <br>';
    header('location:../../vista/pantalla/user/Inicio.php');
    exit();
}else{
    $query2= "INSERT  INTO usuario  (idUsuario, contraseña, nombre, apellidos, rol) VALUES ('{$usuario}', '{$contraseña}', '{$nombre}', '{$apellido}', 'user')"or die ('No se ha podido crear.');
    $result= mysqli_query($link, $query2);
echo 'se ha insertado <br>';
$query= "SELECT * FROM usuario WHERE (idUsuario = '{$usuario}' AND contraseña = '{$contraseña}')";
$result = mysqli_query($link, $query) or die ('consulta fallida');
$resultado= mysqli_fetch_assoc($result);
if ($result==null){
    header('location:../../vista/pantalla/user/Inicio.php');
    exit();
}else {
    //Iniciamos la sesion
    session_start();
    $_SESSION['name']=$resultado['nombre'];
    $_SESSION['user']=$resultado['idUsuario'];
    $_SESSION['apellido']=$resultado['apellidos'];
    $_SESSION['rol']=$resultado['rol'];
    $_SESSION['pass']=$resultado['pass'];
    header("location:../../vista/pantalla/user/main.php");
    exit();
}
}

mysqli_close($link);
echo 'cerramos bd';
}
?>