<?php
include_once '../connect.php';

$data = json_decode(file_get_contents('php://input'), true);

// Validamos los datos
if (isset($data['idUsuario']) && isset($data['idProducto']) && isset($data['talla']) && isset($data['cantidad'])) {
    $idUsuario = $link->real_escape_string($data['idUsuario']);
    $idProducto = $link->real_escape_string($data['idProducto']);
    $talla = $link->real_escape_string($data['talla']);
    $cantidad = $link->real_escape_string($data['cantidad']);
//Se la cantidad es mayor que 0 actualizamos la cantidad en carrito
    if ($cantidad > 0){
        $sql = "UPDATE carrito SET cantidad = ? WHERE idUsuario = ? AND idProducto = ? AND talla = ?";
        $stmt = $link->prepare($sql);

        if (!$stmt) {
            $response = ['Error en la preparación de la consulta: ' . $link->error
            ];
            echo json_encode($response);
            exit();
        }

        // Nos aseguramos del tipo de datos
        $stmt->bind_param("siii", $cantidad, $idUsuario, $idProducto, $talla);
    } else{
        //se la cantidad es 0 barramos
        $sql = "DELETE FROM carrito WHERE idUsuario = ? AND idProducto = ? AND talla = ? AND cantidad = 1";
        $stmt = $link->prepare($sql);

        if (!$stmt) {
            $response = ['Error en la preparación de la consulta: ' . $link->error
            ];
            echo json_encode($response);
            exit();
        }

       // Nos aseguramos del tipo de datos
        $stmt->bind_param("sii", $idUsuario, $idProducto, $talla);
    }

    if ($stmt->execute()) {
        $response = ['Operación realizada exitosamente.'
        ];
    } else {
        $response = ['Error al realizar la operación: ' . $stmt->error
        ];
    }

    echo json_encode($response);
}

$stmt->close();
$link->close();
?>