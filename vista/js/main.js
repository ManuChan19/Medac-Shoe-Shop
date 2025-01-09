
// funcion editartabla admin
function editarfila(event) {
    const fila = event.target.closest('tr');
    const celdas = fila.querySelectorAll('td');
    const formulario = document.getElementById('usuarioForm');
    formulario.style.visibility = 'visible';
    formulario.setAttribute('action', '../../../controlador/admin/editarusuario.php');
    let submitUser = document.getElementById('submitUser');
    submitUser.innerHTML = 'Editar Fila';
    document.getElementById('email').value = celdas[0].textContent; // Email
    document.getElementById('nombre').value = celdas[1].textContent;    // Nombre
    document.getElementById('apellido').value = celdas[2].textContent; // Apellidos
    document.getElementById('rol').value = celdas[3].textContent;      // Rol
    document.getElementById('idUsuario').value = celdas[0].textContent; //id
}
//Muestra la tabla para crear un nuevo usuario
function nuevoUsuario() {
    const formulario = document.getElementById('usuarioForm');
    formulario.style.visibility = 'visible';
    formulario.style.backgroundColor = '#F5EFFF';
    formulario.style.border = '#E5D9F2 solid 3px';
    formulario.style.padding = '10px';
    formulario.reset();
    formulario.setAttribute('action', '../../../controlador/admin/crearusuario.php');
    let submitUser = document.getElementById('submitUser');
    submitUser.innerHTML = 'Crear Usuario';
}

//Muestra el producto que querramos editar
function cambiarProducto(id, nombre, precio) {
    let productoButton = document.getElementById('productobutton');
    productoButton.innerHTML = 'Editar Producto';
    productoButton.style.visibility = 'visible';
    document.getElementById('idProducto').value = id;
    document.getElementById('nombre').value = nombre;
    document.getElementById('precio').value = precio;
    let productoForm = document.getElementById('imagenForm');
    productoForm.setAttribute('action', '../../../controlador/admin/guardarimagen.php');
}

//Cambia la tabla para crear un nuevo producto
function crearProducto() {
    let productoButton = document.getElementById('productobutton');
    productoButton.innerHTML = 'Crear Producto';
    productoButton.style.visibility = 'visible';
    let productoForm = document.getElementById('imagenForm');
    productoForm.reset();
    productoForm.setAttribute('action', '../../../controlador/admin/crearimagen.php');
}

//Agrega la talla al producto elegido
function agregaTalla(event) {
    let talla = event.target.innerHTML;
    let idProducto = event.target.parentElement.parentElement.getAttribute('id');
    document.getElementById('idtalla' + idProducto).value = talla;
}

//Carga al inicio, el localStorage y el elemento span del carrito
(function () {
    
    if (JSON.parse(localStorage.getItem("save")) == false) {
        let tabla = [];
        localStorage.setItem("save", JSON.stringify(tabla));
    }
    let retrievedScores = JSON.parse(localStorage.getItem("save"));
    let cantidadtotal = 0;
   
    if (retrievedScores.length > 0) {

        for (i = 0; i < retrievedScores.length; i++) {    
                cantidadtotal += retrievedScores[i].cantidad;  
        }
    }
    console.log(retrievedScores.length);
    let span = document.getElementById('spancarrito');
    span.innerHTML = cantidadtotal;
    console.log('adios');
})()


//Agregamos productos al carrito
function agregarAlCarrito(event) {
    let idProducto = event.target.parentElement.getAttribute('id');
    let form = document.getElementById('carritoForm' + idProducto);
    const { elements } = form;
    let tabla = []
    const seleccion = {
        idUsuario: elements.idUsuario.value,
        idProducto: elements.idProducto.value,
        talla: elements.talla.value,
        cantidad: 1
    };
    if (seleccion.talla !== "") {
        tabla = tabla.concat(JSON.parse(localStorage.getItem('save') || '[]'));
        let x = true;

        for (let i = 0; i < tabla.length; i++) {
            if (seleccion.idUsuario == tabla[i].idUsuario && seleccion.idProducto == tabla[i].idProducto && seleccion.talla == tabla[i].talla) {
                tabla[i].cantidad++;
//Si el producto está ya en el carrito
                $.ajax({
                    url: '../../../modelo/admin/guardarcarrito.php',
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
                x = false;
            }
        }
//Si el producto es nuevo
        if (x == true) {
            console.log(seleccion);
            $.ajax({
                url: '../../../modelo/admin/guardarcarrito.php',
                type: 'POST',
                data: JSON.stringify(seleccion),
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                success: function (response) {
                    console.log('Success:', response);
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                }
            });

            tabla.push(seleccion);
        }
        localStorage.setItem("save", JSON.stringify(tabla));



        let retrievedScores = JSON.parse(localStorage.getItem("save"));
        let cantidadtotal = 0;
        if (retrievedScores.length > 0) {

            for (i = 0; i < retrievedScores.length; i++) {
                if (seleccion.idUsuario == tabla[i].idUsuario) {
                    cantidadtotal += tabla[i].cantidad;
                }

            }
        }
        
        document.getElementById('spancarrito').innerHTML = cantidadtotal;
    }
}
