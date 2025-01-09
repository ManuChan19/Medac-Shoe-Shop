<?php
require_once '../../modelo/connect.php';
//Crear un producto nuevo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $idProducto = $_POST['idProducto'];
    $imagen = $_FILES['imagen']['tmp_name'];
    if (!$imagen || !is_uploaded_file($imagen)) {
        die("Error: No se cargó la imagen.");
    }
    // Leer contenido del archivo binario
    $imagenContenido = file_get_contents($imagen);
    // Preparar la consulta para insertar
    $query = "INSERT INTO producto (nombre, precio, imagen) VALUES (?,?,?)";
    $stmt = $link->prepare($query);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $link->error);
    }

    // Comprobar parametros
    $stmt->bind_param("sds", $nombre, $precio, $imagenContenido);
    if ($stmt->execute()) {
        echo "Producto insertado exitosamente.";
    } else {
        echo "Error al insertar el producto: " . $stmt->error;
    }
    $stmt->close();
    $link->close();
    header('location:../../vista/pantalla/admin/productoadmin.php');
}