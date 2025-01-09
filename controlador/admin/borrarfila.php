<?php
include_once '../../modelo/connect.php';
//Borrar usuario de la base de datos
    global $link;
    $idUsuario = $_POST['idBorrar'];
    echo $idUsuario;
    $query = "DELETE FROM usuario WHERE (idUsuario = '{$idUsuario}')";
    $result = mysqli_query($link, $query);
    header("location:../../vista/pantalla/admin/mainadmin.php");
