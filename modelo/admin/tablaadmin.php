<?php

//Cargamos la tabla de usuario de la base de datos
function cargarTabla()
{
    global $link;
    $query = 'SELECT * FROM usuario';
    $result = mysqli_query($link, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr><td>' . $row['idUsuario'] . '</td><td>' . $row['nombre'] . '</td><td>' . $row['apellidos'] . '</td><td>' . $row['rol'] . '</td><td><form action="../../../controlador/admin/borrarfila.php" method="POST">
                    <input type="hidden" name="idBorrar" id="idBorrar" value='.$row['idUsuario'].'>
                    <button type="submit">Borrar</button>
                </form></td><td><button onclick="editarfila(event)">Editar</button></td></tr>';
    }
    mysqli_free_result($result);
}
?>


