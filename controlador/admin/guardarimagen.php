<?php
require_once '../../modelo/connect.php';
//Editar producto
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
    $query = "UPDATE producto 
              SET nombre = ?, 
                  precio = ?, 
                  imagen = ? 
              WHERE idProducto = ?";
    $stmt = $link->prepare($query);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $link->error);
    }
    // Comprobar los parametros
    $stmt->bind_param("sdsi", $nombre, $precio, $imagenContenido, $idProducto);
    if ($stmt->execute()) {
        echo "Producto insertado exitosamente.";
    } else {
        echo "Error al insertar el producto: " . $stmt->error;
    }
    
    $stmt->close();
    $link->close();
    header('location:../../vista/pantalla/admin/productoadmin.php');
}