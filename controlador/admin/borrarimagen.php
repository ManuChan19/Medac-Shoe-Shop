<?php
include_once '../../modelo/connect.php';
//Borrar producto de la base de datos
    global $link;
    $idProducto = $_POST['idBorrar'];
    echo $idUsuario;
    $query = "DELETE FROM producto WHERE (idProducto = '{$idProducto}')";
    $result = mysqli_query($link, $query);
    header("location:../../vista/pantalla/admin/productoadmin.php");