<?php
session_start();

$idUsuario = $_SESSION['user'] ?? null;
$preciototal=0;

if (!$idUsuario) {
    $response = [
        'error' => 'El usuario no está autenticado.'
    ];
    echo json_encode($response);
    exit();
}

// Consulta para obtener los productos del carrito
$query = 'SELECT idProducto, cantidad, talla, idcarrito FROM carrito WHERE idUsuario = ?';
$stmt = $link->prepare($query);

if (!$stmt) {
    $response = [
        'error' => 'Error en la preparación de la consulta del carrito: ' . $link->error
    ];
    echo json_encode($response);
    exit();
}

$stmt->bind_param("s", $idUsuario);

if (!$stmt->execute()) {
    $response = [
        'error' => 'Error al ejecutar la consulta del carrito: ' . $stmt->error
    ];
    echo json_encode($response);
    exit();
}

$result = $stmt->get_result();
$carrito = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $carrito[] = $row;
    }
}

$stmt->close();

// Preparar la consulta para obtener detalles de productos
$query = 'SELECT nombre, precio, imagen, idProducto FROM producto WHERE idProducto = ?';
$stmt = $link->prepare($query);

if (!$stmt) {
    $response = [
        'error' => 'Error en la preparación de la consulta de productos: ' . $link->error
    ];
    echo json_encode($response);
    exit();
}

$datosproducto = [];

foreach ($carrito as $item) {
    $idProducto = $item['idProducto'];
    $cantidad = $item['cantidad'];

    $stmt->bind_param("i", $idProducto);

    if (!$stmt->execute()) {
        $response = [
            'error' => 'Error al ejecutar la consulta de productos: ' . $stmt->error
        ];
        echo json_encode($response);
        exit();
    }

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['cantidad'] = $cantidad; // Añadir cantidad al producto.
            $datosproducto[] = $row;
        }
    }
}

$stmt->close();
$link->close();
?>
