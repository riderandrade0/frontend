<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <script src="scripts.js"></script>

    <title>Clientes</title>
   
</head>
<body>
    
    <div class="container">
        <table border="2">
        <h2>RIDER ANDRADE HEREDIA</h2>
        <details>
            
            <summary>Agregar Cliente</summary>
            <form id="addForm">
            <div class="fondo-personalizado"> 
                <label for="nombreEmpresaAdd">Nombre de la empresa:</label>
                <input type="text" id="nombreEmpresaAdd" name="nombreEmpresaAdd"><br><br>
                
                <label for="direccionAdd">Dirección:</label>
                <input type="text" id="direccionAdd" name="direccionAdd"><br><br>
                
                <label for="telefonoAdd">Teléfono:</label>
                <input type="text" id="telefonoAdd" name="telefonoAdd"><br><br>
                
                <label for="correoAdd">Correo:</label>
                <input type="text" id="correoAdd" name="correoAdd"><br><br>
                
                <button type="button" onclick="agregarCliente()">Agregar Cliente</button>
            </div>
            </form>
        </details>
        <div class="fondo-personalizado">
    <div id="panel-edicion" class="panel-edicion" style="display: none;">
        <h2>Editar Cliente</h2>
        <form id="editForm">
            <input type="hidden" id="idEditar" name="idEditar">
            <label for="nombreEmpresaEdit">Nombre de la empresa:</label>
            <input type="text" id="nombreEmpresaEdit" name="nombreEmpresaEdit"><br><br>
            
            <label for="direccionEdit">Dirección:</label>
            <input type="text" id="direccionEdit" name="direccionEdit"><br><br>
            
            <label for="telefonoEdit">Teléfono:</label>
            <input type="text" id="telefonoEdit" name="telefonoEdit"><br><br>
            
            <label for="correoEdit">Correo:</label>
            <input type="text" id="correoEdit" name="correoEdit"><br><br>
            
            <button type="button" onclick="guardarCambiosCliente()">Guardar Cambios</button>
            <button type="button" onclick="ocultarFormularioEditar()">Salir</button>
        </form>
    </div>
    </div>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre de la Empresa</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Acciones</th> <!-- Nueva columna para los botones de editar y eliminar -->
                </tr>
            </thead>
            <tbody>
                <?php
                $canal = curl_init();
                $url = 'http://localhost/ApiRestRider/get_all_cliente.php';
                curl_setopt($canal, CURLOPT_URL, $url);
                curl_setopt($canal, CURLOPT_RETURNTRANSFER, true);
                $respuesta = curl_exec($canal);

                if (curl_errno($canal)) {
                    $error_msg = curl_error($canal);
                    echo "<tr><td colspan='6'>Error en la conexión: $error_msg</td></tr>";
                } else {
                    curl_close($canal);

                    $clientes = json_decode($respuesta, true);
                    foreach ($clientes as $cliente) {
                        echo "<tr>";
                        echo "<td>{$cliente['id']}</td>";
                        echo "<td>{$cliente['nombre_empresa']}</td>";
                        echo "<td>{$cliente['direccion']}</td>";
                        echo "<td>{$cliente['telefono']}</td>";
                        echo "<td>{$cliente['correo']}</td>";
                        echo "<td>
                                <button onclick=\"mostrarFormularioEditar({$cliente['id']}, '{$cliente['nombre_empresa']}', '{$cliente['direccion']}', '{$cliente['telefono']}', '{$cliente['correo']}')\">Editar</button>
                                <button onclick=\"eliminarCliente({$cliente['id']})\">Eliminar</button></td>";
                                
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Panel de Edición -->
   

    <script>
        function mostrarFormularioEditar(id, nombreEmpresa, direccion, telefono, correo) {
            document.getElementById('idEditar').value = id;
            document.getElementById('nombreEmpresaEdit').value = nombreEmpresa;
            document.getElementById('direccionEdit').value = direccion;
            document.getElementById('telefonoEdit').value = telefono;
            document.getElementById('correoEdit').value = correo;

            document.getElementById('panel-edicion').style.display = 'block';
        }

        function ocultarFormularioEditar() {
            document.getElementById('panel-edicion').style.display = 'none';
        }

        function guardarCambiosCliente() {
            var id = document.getElementById('idEditar').value;
            var nombreEmpresa = document.getElementById('nombreEmpresaEdit').value;
            var direccion = document.getElementById('direccionEdit').value;
            var telefono = document.getElementById('telefonoEdit').value;
            var correo = document.getElementById('correoEdit').value;

            var url = 'http://localhost/ApiRestRider/update_cliente.php?id=' + id +
                      '&nombre_empresa=' + encodeURIComponent(nombreEmpresa) +
                      '&direccion=' + encodeURIComponent(direccion) +
                      '&telefono=' + encodeURIComponent(telefono) +
                      '&correo=' + encodeURIComponent(correo);

            fetch(url, {
                method: 'PUT'
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert("No se pudo editar el cliente.");
                }
            })
            .catch(error => {
                console.error('Error al enviar la solicitud:', error);
            });
        }
        
        function eliminarCliente(id) {
            if (confirm("¿Está seguro de que desea eliminar este cliente?")) {
                fetch('http://localhost/ApiRestRider/delete_cliente.php?id=' + id, {
                    method: 'DELETE'
                })
                .then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        alert("No se pudo eliminar el cliente.");
                    }
                })
                .catch(error => {
                    console.error('Error al enviar la solicitud:', error);
                });
            }
        }
        function agregarCliente() {
            var nombreEmpresa = document.getElementById("nombreEmpresaAdd").value;
            var direccion = document.getElementById("direccionAdd").value;
            var telefono = document.getElementById("telefonoAdd").value;
            var correo = document.getElementById("correoAdd").value;

            var url = 'http://localhost/ApiRestRider/create_cliente.php?nombre_empresa=' + encodeURIComponent(nombreEmpresa) + '&direccion=' + encodeURIComponent(direccion) + '&telefono=' + encodeURIComponent(telefono) + '&correo=' + encodeURIComponent(correo);

            fetch(url, {
                method: 'POST'
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert("No se pudo agregar el cliente.");
                }
            })
            .catch(error => {
                console.error('Error al enviar la solicitud:', error);
            });
        }
    </script>
</body>
</html>
