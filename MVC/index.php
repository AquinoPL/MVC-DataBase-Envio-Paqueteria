<?php
// Incluir el archivo de conexión
require_once 'conexion.php';

// Verificar si se ha seleccionado una acción
if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];

    if ($accion === 'registrar_envio') {
        // Mostrar el formulario para registrar un nuevo envío
        ?>
        <h2 class="text-center">Registrar Nuevo Envío</h2>
        <form action="registrar_envio.php" method="post">
            <label for="direccion_destino">Dirección de Destino:</label>
            <input type="text" name="direccion_destino" id="direccion_destino" required> <br><br>

            <label for="telefono_destino">Teléfono de Destino:</label>
            <input type="text" name="telefono_destino" id="telefono_destino" required> <br><br>

            <label for="id_paquete">ID del Paquete:</label>
            <input type="text" name="id_paquete" id="id_paquete" required> <br><br>

            <label for="fecha_envio">Fecha de Envío (YYYY-MM-DD):</label>
            <input type="date" name="fecha_envio" id="fecha_envio" required> <br><br>

            <input type="submit" class="btn" name="btn_guardar_envio" value="Guardar Envío">
        </form>
        <?php
    } elseif ($accion === 'buscar_envio') {
        // Mostrar el formulario para buscar o rastrear un envío
        ?>
        <h2 class="text-center">Buscar/Rastrear Envío</h2>
        <form action="buscar_envio.php" method="get">
            <label for="id_orden">ID del Orden:</label>
            <input type="text" name="id_orden" id="id_orden" required> <br><br>

            <label for="clave_envio">Clave de Envío:</label>
            <input type="text" name="clave_envio" id="clave_envio" required> <br><br>

            <input type="submit" class="btn" name="btn_buscar_envio" value="Buscar/Rastrear">
        </form>
        <?php
    }
}

// Verificar si el formulario de acceso de administrador ha sido enviado
if (isset($_POST['btn_acceso_administrador'])) {
    $id_empleado = $_POST['id_empleado'];
    $clave = $_POST['clave'];

    // Consultar si las credenciales son correctas
    $query = "SELECT * FROM empleado WHERE id_empleado = ? AND clave = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $id_empleado, $clave);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        // Credenciales correctas, redirigir al archivo vistaadmi.php
        header("Location: vistaadmi.php");
        exit();
    } else {
        echo "<p class='text-center'>Credenciales incorrectas. Por favor, intente nuevamente.</p>";
    }

    $stmt->close();
}
?>

<!-- Formulario para acceso de administrador -->
<h2 class="text-center">Acceso Administrador</h2>
<form action="" method="post" class="text-center">
    <label for="id_empleado">ID Empleado:</label>
    <input type="text" name="id_empleado" id="id_empleado" required> <br><br>

    <label for="clave">Clave:</label>
    <input type="password" name="clave" id="clave" required> <br><br>

    <input type="submit" class="btn" name="btn_acceso_administrador" value="Acceder">
</form>
