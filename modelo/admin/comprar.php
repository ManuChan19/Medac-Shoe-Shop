<?php
include_once '../connect.php';

session_start();



// Guardar el pedido
function hacerPedido($idUsuario)
{
    global $link;

    $query = "SELECT idcarrito, idProducto, talla, cantidad FROM carrito WHERE idUsuario = ?";
    $stmt = $link->prepare($query);

    if (!$stmt) {
        echo "Error en la preparación de la consulta: " . $link->error;
        return [];
    }
    //Nos aseguramos del tipo de parametro
    $stmt->bind_param("s", $idUsuario);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $objCarrito[] = $row;
        }
    } else {
        echo "Error al obtener los artículos del carrito: " . $stmt->error;
    }

    $stmt->close();

    // Pasamos objCarrito a JSON para almacenarlo
    $ordenPedido = json_encode($objCarrito);
    $query = "INSERT INTO pedidos (idUsuario, Detalles) VALUES (?, ?)";
    $stmt = $link->prepare($query);

    if (!$stmt) {
        echo "Error en la preparación de la consulta: " . $link->error;
        return;
    }

    $stmt->bind_param("ss", $idUsuario, $ordenPedido);

    if ($stmt->execute()) {
        // Una vez insertado en la tabla pedidos lo eliminamos de carrito
        clearCart($idUsuario);
        echo "Orden realizada correctamente!";
    } else {
        echo "Error al realizar la orden: " . $stmt->error;
    }

    $stmt->close();
}

// Borrar Carrito si el usuario coincide
function clearCart($idUsuario)
{
    global $link;
 //Borramos el carrito de la base de datos
    $query = "DELETE FROM  carrito WHERE idUsuario= ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("s", $idUsuario);

    if ($stmt->execute()) {
        echo "Orden realizada correctamente!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
   header('location: ../../vista/pantalla/user/main.php');
}

$idUsuario = $_SESSION['user'];
hacerPedido($idUsuario);
?>