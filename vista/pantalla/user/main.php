<?php
include_once '../../../modelo/connect.php';
include_once '../../../modelo/admin/cargaimagen.php';
session_start();
if (isset($_SESSION['user']) && isset($_SESSION['name'])) {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>MedacSports</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' type='text/css' media='screen' href='../../css/main.css'>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    </head>

    <body>
        <header>
            <img id="logo" src="../../img/logo.png" alt="">
            <?php
            if ($_SESSION['rol'] == 'admin') { ?>
                <a class="headerbutton" href="../admin/mainadmin.php"><button>Control Usuarios</button></a>
                <a class="headerbutton" href="../admin/productoadmin.php"><button>Control Producto</button></a>
            <?php
            }
            ?>
            <a class="headerbutton" href="Inicio.php"><button>Mi cuenta</button></a>
            <a href="carrito.php" id="acarrito"><div><span id="spancarrito"></span><img id="imagencarrito" src="../../img/Carrito.png" alt=""></div></a>

        </header>
        <main>
            <!--Productos disponibles en la web -->
            <div id="products" class="productos">
                <?php foreach ($products as $product) { ?>
                    <div class="ventanaproducto" id="<?php echo $product['idProducto'] ?>">
                        <?php if (!empty($product['imagen'])) { ?>
                            <img class="imagenproducto" src="data:image/jpeg;base64,<?= base64_encode($product['imagen']) ?>" alt="Product Image" width="200px" height="200px">
                        <?php } else { ?>
                            <p>No image available</p>
                        <?php } ?>
                        <p class="producttext"> <?= htmlspecialchars($product['nombre']) ?></p>
                        <p class="producttext"> <?= htmlspecialchars($product['precio']) ?> €</p>
                        <p class="producttext">Eligue tu talla</p>
                        <div class="maintallas"><br>
                            <button onclick="agregaTalla(event)">35</button>
                            <button onclick="agregaTalla(event)">36</button>
                            <button onclick="agregaTalla(event)">37</button>
                            <button onclick="agregaTalla(event)">38</button>
                            <button onclick="agregaTalla(event)">39</button>
                            <button onclick="agregaTalla(event)">40</button>
                            <button onclick="agregaTalla(event)">41</button>
                            <button onclick="agregaTalla(event)">42</button>
                            <button onclick="agregaTalla(event)">43</button>
                            <button onclick="agregaTalla(event)">44</button>
                            <button onclick="agregaTalla(event)">45</button>
                        </div>
                        <form id="carritoForm<?php echo $product['idProducto'] ?>">
                            <input type="hidden" name="idUsuario" value="<?php echo $_SESSION['user'] ?>">
                            <input type="hidden" name="idProducto" value="<?php echo $product['idProducto'] ?>">
                            <input type="hidden" name="talla" id="idtalla<?php echo $product['idProducto'] ?>" value="">
                        </form>
                        <button class="agregarAlCarrito" onclick="agregarAlCarrito(event)">Añadir al carrito</button>

                    </div>
                <?php } ?>
            </div>
        </main>
        <script src='../../js/main.js'></script>
    </body>

    </html>
<?php } else {
    header('location: Inicio.php');
    exit();
} ?>