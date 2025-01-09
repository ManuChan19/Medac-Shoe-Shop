<?php


// Obtenemos todos los productos almacenados en productos
$query = "SELECT idProducto, imagen, precio, nombre FROM producto";
$result = $link->query($query);

$products = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
            $products[] = $row;
    }
}

?>