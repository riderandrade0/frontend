// Este script es opcional y agrega un efecto de iluminación al pasar el mouse sobre la tabla
document.addEventListener("DOMContentLoaded", function() {
    var tableRows = document.querySelectorAll("table tr");
    tableRows.forEach(function(row) {
        row.addEventListener("mouseover", function() {
            row.style.boxShadow = "0 0 10px rgba(255, 255, 255, 0.3)";
        });
        row.addEventListener("mouseout", function() {
            row.style.boxShadow = "none";
        });
    });
});
document.addEventListener("DOMContentLoaded", function() {
    // Agregar evento al formulario para agregar cliente
    var form = document.getElementById("cliente-form");
    form.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevenir el envío por defecto

        // Obtener los valores del formulario
        var nombreEmpresa = document.getElementById("nombre").value;
        var direccion = document.getElementById("direccion").value;
        var telefono = document.getElementById("telefono").value;
        var correo = document.getElementById("correo").value;

        // Llamar a la función para agregar cliente
        agregarCliente(nombreEmpresa, direccion, telefono, correo);
    });

    // Resto del código para centrar la tabla y aplicar efecto de iluminación
});
