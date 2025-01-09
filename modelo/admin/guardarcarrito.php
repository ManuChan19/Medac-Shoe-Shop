<?php
include_once '../connect.php';

$data = json_decode(file_get_contents('php://input'), true);

// Validamos los datos recibidos
if (isset($data['idUsuario']) && isset($data['idProducto']) && isset($data['talla']) && isset($data['cantidad'])) {
    $idUsuario = $link->real_escape_string($data['idUsuario']);
    $idProducto = $link->real_escape_string($data['idProducto']);
    $talla = $link->real_escape_string($data['talla']);
    $cantidad = $link->real_escape_string($data['cantidad']);

    if ($cantidad == 1) {
        $sql = "INSERT INTO carrito (idUsuario, idProducto, talla, cantidad) VALUES (?, ?, ?, ?)";
        $stmt = $link->prepare($sql);

        if (!$stmt) {
            $response = [
                'Error en la preparación de la consulta: ' . $link->error
            ];
            echo json_encode($response);
            exit();
        }

        // Datos que vamos a meter en la tabla carrito
        $stmt->bind_param("siii", $idUsuario, $idProducto, $talla, $cantidad);
    } else {
        $sql = "UPDATE carrito SET cantidad = ? WHERE idUsuario = ? AND idProducto = ? AND talla = ?";
        $stmt = $link->prepare($sql);

        if (!$stmt) {
            $response = [
                'Error en la preparación de la consulta: ' . $link->error
            ];
            echo json_encode($response);
            exit();
        }

        // Nos aseguramos del tipo de dato
        $stmt->bind_param("siii", $cantidad, $idUsuario, $idProducto, $talla);
    }

    if ($stmt->execute()) {
        $response = [
            'Operación realizada exitosamente.'
        ];
    } else {
        $response = [
            'Error al realizar la operación: ' . $stmt->error
        ];
    }

    echo json_encode($response);
}

$stmt->close();
$link->close();
