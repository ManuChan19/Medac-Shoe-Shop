<?php 
//Cerramos la sesion
session_start();
session_destroy();
header('location: .././../vista/pantalla/user/main.php')


?>