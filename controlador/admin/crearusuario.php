<?php
require_once '../../modelo/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUsuario = $_POST['email'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $rol = $_POST['rol'];
       
    // Preparar la consulta para insertar
    $query = "INSERT INTO usuario (idUsuario, nombre, apellidos, rol) VALUES (?,?,?,?)";
    
    $stmt = $link->prepare($query);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $link->error);
    }

    // Comprobar los parametros
    $stmt->bind_param("ssss", $idUsuario, $nombre, $apellido, $rol);
    if ($stmt->execute()) {
        echo "Producto insertado exitosamente.";
    } else {
        echo "Error al insertar el producto: " . $stmt->error;
    }
    
    $stmt->close();
    $link->close();
    header('location:../../vista/pantalla/admin/mainadmin.php');
}