//Quitamos cantidad del producto
function menos(event, idProducto, talla, precio) {
    let idCarrito = event.target.parentElement.parentElement.getAttribute('id');
    let row = event.target.closest('tr');
    let quantityCell = row.querySelector('.cantidad');
    let cantidadActual = parseInt(quantityCell.textContent); // Get current quantity
    let preciototal = parseFloat(document.getElementById('spantotal').innerHTML);
    preciototal-=precio;
    console.log(preciototal)
    document.getElementById('spantotal').innerHTML=preciototal+'€';

    if (cantidadActual >= 1) {
        cantidadActual--; // Decrement quantity
        quantityCell.innerHTML = `${cantidadActual}`;
    }
    let tabla = (JSON.parse(localStorage.getItem('save') || '[]'));
    for (let i = 0; i < tabla.length; i++) {
        if (idProducto == tabla[i].idProducto && talla == tabla[i].talla) {
            tabla[i].cantidad--;

            $.ajax({
                url: '../../../modelo/admin/actualizarcarrito.php',
                type: 'POST',
                data: JSON.stringify(tabla[i]),
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                success: function (response) {
                    console.log('Success:', response);
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
//Si la cantidad es 0 la quitamos de la tabla
            if (cantidadActual == 0) {
                row.remove();
                tabla.splice(i, 1);
                console.log('splice');

            }

        }
    }
    localStorage.setItem("save", JSON.stringify(tabla));

}
//Incrementamos mmas la cantidad del producto
function mas(event, idProducto, talla, precio) {
    let idCarrito = event.target.parentElement.parentElement.getAttribute('id');
    let row = event.target.closest('tr');
    let quantityCell = row.querySelector('.cantidad');
    let preciototal = parseFloat(document.getElementById('spantotal').innerHTML);
    preciototal+=precio;
    console.log(preciototal)
    document.getElementById('spantotal').innerHTML=preciototal+'€';

    let cantidadActual = parseInt(quantityCell.textContent); // Get current quantity
    cantidadActual++; // Increment quantity
    quantityCell.innerHTML = `${cantidadActual}`;
    let tabla = (JSON.parse(localStorage.getItem('save') || '[]'));
    console.log('la longitud de la tabla es de: ' + tabla.length);
    for (let i = 0; i < tabla.length; i++) {
        if (idProducto == tabla[i].idProducto && talla == tabla[i].talla) {
            tabla[i].cantidad++;
            $.ajax({
                url: '../../../modelo/admin/actualizarcarrito.php',
                type: 'POST',
                data: JSON.stringify(tabla[i]),
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                success: function (response) {
                    console.log('Success:', response);
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    }
    localStorage.setItem("save", JSON.stringify(tabla));
}