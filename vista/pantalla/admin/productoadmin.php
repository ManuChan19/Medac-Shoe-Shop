<?php

session_start();
if (isset($_SESSION['user']) && isset($_SESSION['name']) && $_SESSION['rol']== 'admin') {
    include_once '../../../modelo/connect.php';
include_once '../../../modelo/admin/cargaimagen.php';


?>
<!-- Pagina para gestionar los productos -->
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Producto Admin</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../css/main.css'>
    

</head>

<body>
<header>
<img id="logo" src="../../img/logo.png" alt="">
<a href="mainadmin.php"><button>Control Usuarios</button></a>
<a href="productoadmin.php"><button>Control Producto</button></a>
<a href="../user/main.php"><button>Principal</button></a>
<a href="../user/Inicio.php"><button>Mi cuenta</button></a>
<a href="../user/carrito.php" id="acarrito"><div><span id="spancarrito"></span><img id="imagencarrito" src="../../img/Carrito.png" alt=""></div></a>

</header>
    <main>
        <div class="nuevoButton">
            <button onclick="crearProducto()">Nuevo Producto</button>
        </div>

        <div class="form">
            <!-- Cargamos la imagen y datos y los enviamos a guardarimagen.php -->
            <form id="imagenForm" action='../../../controlador/admin/guardarimagen.php' method="post" enctype="multipart/form-data">
                Nombre:<input type="text" name="nombre" id="nombre" class="input" required>
                Precio:<input type="decimal" name="precio" id="precio" class="input" required><br>
                Seleccionar imagen:<input type="file" name="imagen" id="imagen" class="input" required>
                <input type="hidden" id="idProducto" name="idProducto">
                <button type="submit" id='productobutton' style="visibility: hidden;">Editar Producto</button>
            </form>

        </div>
        <h1>All Products</h1>
        <!-- Vista de los productos -->
        <div id="products" class="productos">
            <?php foreach ($products as $product): ?>
                <div class="ventanaproducto">
                    <?php if (!empty($product['imagen'])): ?>
                        <img class="producttext" src="data:image/jpeg;base64,<?= base64_encode($product['imagen']) ?>" alt="Product Image" width="200px" height="200px">
                    <?php else: ?>
                        <p>No image available</p>
                    <?php endif; ?>
                    <p class="producttext"><strong>Name:</strong> <?= htmlspecialchars($product['nombre']) ?></p>
                    <p class="producttext"><strong>Price:</strong> $<?= htmlspecialchars($product['precio']) ?></p>
                    <button   id="editarProducto" onclick="cambiarProducto(<?php echo $product['idProducto'] ?>,'<?php echo $product['nombre'] ?>',<?php echo $product['precio'] ?>)">Editar</button>
                    <form  id="formBorrarProducto" action="../../../controlador/admin/borrarimagen.php" method="POST">
                        <input type="hidden" name="idBorrar" id="idBorrar" value='<?php echo $product['idProducto'] ?>'>
                        <button  type="submit">Borrar</button>
                    </form>
                </div>
            <?php endforeach; ?>
    </main>
    <script src='../../js/main.js'></script>
</body>

</html>
<?php
}else {
    header('location:../../../vista/pantalla/user/Inicio.php ');
}
?>