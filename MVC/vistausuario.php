<?php require_once("vista/layout/header.php"); ?>
<?php require_once 'conexion.php'; // Conexión a la base de datos ?>

<h1 class="text-center">Gestión de Envíos</h1>
<hr>

<!-- Formulario para seleccionar la acción -->
<form action="" method="get" class="text-center">
    <label for="accion">Seleccionar Acción:</label>
    <select name="accion" id="accion">
        <option value="registrar_envio">Registrar Envío</option>
        <option value="buscar_envio">Buscar/Rastrear Envío</option>
    </select>
    <input type="submit" class="btn" value="Seleccionar">
</form>

<?php
if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];

    if ($accion === 'registrar_envio') {
        // Formulario para registrar un nuevo envío
        ?>
        <h2 class="text-center">Registrar Nuevo Envío</h2>
        <form action="" method="post">
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

        // Procesar el formulario de registro de envío
        if (isset($_POST['btn_guardar_envio'])) {
            $direccion_destino = $_POST['direccion_destino'];
            $telefono_destino = $_POST['telefono_destino'];
            $id_paquete = $_POST['id_paquete'];
            $fecha_envio = $_POST['fecha_envio'];

            // Insertar en la tabla de envíos (puedes ajustar según tu estructura de base de datos)
            $query = "INSERT INTO envio (direccion_destino, telefono_destino, id_paquete, fecha_envio) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", $direccion_destino, $telefono_destino, $id_paquete, $fecha_envio);

            if ($stmt->execute()) {
                echo "<p class='text-center'>Envío registrado exitosamente.</p>";
            } else {
                echo "<p class='text-center'>Error al registrar el envío: " . $stmt->error . "</p>";
            }

            $stmt->close();
        }
    } elseif ($accion === 'buscar_envio') {
        // Formulario para buscar o rastrear un envío
        ?>
        <h2 class="text-center">Buscar/Rastrear Envío</h2>
        <form action="" method="get">
            <label for="id_orden">ID del Orden:</label>
            <input type="text" name="id_orden" id="id_orden" required> <br><br>

            <label for="clave_envio">Clave de Envío:</label>
            <input type="text" name="clave_envio" id="clave_envio" required> <br><br>

            <input type="submit" class="btn" name="btn_buscar_envio" value="Buscar/Rastrear">
        </form>

        <?php
        if (isset($_GET['btn_buscar_envio'])) {
            $id_orden = $_GET['id_orden'];
            $clave_envio = $_GET['clave_envio'];

            // Consultar detalles del envío basados en id_orden y clave_envio
            $query = "SELECT * FROM detalle WHERE id_orden = ? AND clave_envio = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $id_orden, $clave_envio);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                ?>
                <h3 class="text-center">Detalles del Envío</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>ID Orden</th>
                        <th>Clave de Envío</th>
                        <th>Estado</th>
                        <th>Otros Detalles</th>
                    </tr>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id_orden']); ?></td>
                                <td><?php echo htmlspecialchars($row['clave_envio']); ?></td>
                                <td><?php echo htmlspecialchars($row['estado']); ?></td>
                                <td><?php echo htmlspecialchars($row['otros_detalles']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo "<p class='text-center'>No se encontró información para la combinación de ID de orden y clave de envío proporcionada.</p>";
            }

            $stmt->close();
        }
    }
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

<?php
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

<?php require_once("vista/layout/footer.php"); ?>
