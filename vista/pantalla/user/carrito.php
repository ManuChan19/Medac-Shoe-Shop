<?php
include_once '../../../modelo/connect.php';
include_once '../../../modelo/admin/cargaimagen.php';
include_once '../../../modelo/admin/cargarcarrito.php';

if (isset($_SESSION['user']) && isset($_SESSION['name'])) {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Carrito</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' type='text/css' media='screen' href='../../css/main.css'>
        <script src='../../js/carrito.js'></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    </head>

    <body>
        <header>
        <img id="logo" src="../../img/logo.png" alt="">
            <?php
            if ($_SESSION['rol'] == 'admin') { ?>
                <a href="../admin/mainadmin.php"><button>Control Usuarios</button></a>
                <a href="../admin/productoadmin.php"><button>Control Producto</button></a>
            <?php
            }
            ?>
            <a href="main.php"><button>Principal</button></a>
            <a href="Inicio.php"><button>Mi cuenta</button></a>

        </header>

        <main>

            <div>
                <div class="productoscarrito">
                    <!-- Tabla con los productos en el carrito -->
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2">Producto</th>
                                <th>Cantidad</th>
                                <th>Talla</th>
                                <th>Precio Ud.</th>
                            </tr>
                        </thead>
                        <tbody id="tbodycarrito">
                            <?php
                            $preciototal = 0; 
                            $processedIds = []; //Variable para ver que idcarritos han sido procesadas
                            foreach ($carrito as $lista) {
                                foreach ($datosproducto as $datos) {
                                    if ($lista['idProducto'] == $datos['idProducto'] && !in_array($lista['idcarrito'], $processedIds)) {
                                        $processedIds[] = $lista['idcarrito']; // Metemos idcarrito en processedIds 
                            ?>
                                        <tr id="<?php echo htmlspecialchars($lista['idcarrito']); ?>">
                                            <td class="imagen">
                                                <?php if (!empty($datos['imagen'])) { ?>
                                                    <img class="productocarrito" src="data:image/jpeg;base64,<?= base64_encode($datos['imagen']) ?>" alt="Product Image" width="200px" height="200px">
                                                <?php } else { ?>
                                                    No image available
                                                <?php } ?>
                                            </td>
                                            <td class="nombre">
                                                <button class="menos" onclick="menos(event, <?php echo $lista['idProducto'] ?>, <?php echo $lista['talla'] ?>, <?php echo $datos['precio'] ?> )">-</button>
                                                <?php echo htmlspecialchars($datos['nombre']); ?>
                                                <button class="mas" onclick="mas(event, <?php echo $lista['idProducto'] ?>, <?php echo $lista['talla'] ?>, <?php echo $datos['precio'] ?>)">+</button>
                                            </td>

                                            <td class="cantidad">

                                                <?php echo $lista['cantidad']; ?>

                                            </td>
                                            <td class="talla"><?php echo htmlspecialchars($lista['talla']); ?></td>
                                            <td class="precio"><?php echo htmlspecialchars(number_format($datos['precio'], 2)); ?>€</td>
                                        </tr>
                            <?php
                                        $preciototal += $datos['precio'] * $lista['cantidad']; // Precio total
                                    }
                                }
                            }
                            ?>
                            <tr>
                                <td colspan="3"></td>
                                <th>Precio total:</th>
                                <td id="spantotal"><?php echo htmlspecialchars(number_format($preciototal, 2)); ?>€</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div><a href="../../../modelo/admin/comprar.php"><button id="compraahora" onclick="localStorage.clear()">Compra ahora</button></a></div>
            </div>
        </main>


    </body>

<?php
} else {
    header('location: Inicio.php');
    exit();
}
?>