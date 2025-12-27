<?php require_once("vista/layout/header.php")?>

<h1 class="text-center">ADMINISTRADOR</h1>
<hr>
        <!-- Formulario para seleccionar la tabla -->
        <form action="" method="get" class="text-center">
            <label for="tabla">Seleccionar Tabla:</label>
            <select name="tabla" id="tabla">
                <option value="agencia">Agencia</option>
                <option value="empleado">Empleado</option>
                <option value="usuario">Usuario</option>
                <option value="transporte">Transporte</option>
                <option value="envio">Envío</option>
                <option value="paquete">Paquete</option>
                <option value="detalle">Detalle</option>
                <option value="pago">Pago</option>
                <option value="estado">Estado</option>
                <option value="rastrea">Rastrea</option>
            </select>
            <input type="submit" class="btn" value="Mostrar">
        </form>

        <!-- Botón para agregar nuevo registro -->
        <?php if (isset($_GET['tabla'])): ?>
            <a href="index.php?m=nuevo&tabla=<?php echo urlencode($_GET['tabla']); ?>" class="btn">NUEVO</a>
        <?php endif; ?>

        <?php
        // Conectar a la base de datos
        // Asegúrate de reemplazar los valores de conexión por los adecuados
        require_once 'conexion.php';

        // Verificar la conexión
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Obtener la tabla seleccionada
        $tabla = isset($_GET['tabla']) ? $_GET['tabla'] : 'agencia';

        // Consultar datos de la tabla seleccionada
        $query = "SELECT * FROM " . $conn->real_escape_string($tabla);
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0){
        ?>
        <table>
            <tr>
                <?php
                // Mostrar encabezados de columna según la tabla
                $fields = $result->fetch_fields();
                foreach ($fields as $field):
                ?>
                    <td><?php echo htmlspecialchars($field->name); ?></td>
                <?php endforeach; ?>
                <td>Acción</td>
            </tr>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <?php foreach ($fields as $field): ?>
                            <td><?php echo htmlspecialchars($row[$field->name]); ?></td>
                        <?php endforeach; ?>
                        <td>
                            <!-- Adaptar enlaces para edición y eliminación según la tabla -->
                            <a class="btn" href='index.php?m=editar&tabla=<?php echo urlencode($tabla); ?>&id=<?php echo urlencode($row[$fields[0]->name]); ?>'>Actualizar</a>
                            <a class="btn" href='index.php?m=eliminar&tabla=<?php echo urlencode($tabla); ?>&id=<?php echo urlencode($row[$fields[0]->name]); ?>'>Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php
        } else {
            echo "<p class='text-center'>No hay registros en la tabla seleccionada.</p>";
        }

        // Cerrar la conexión
        $conn->close();
        ?>
<?php require_once("vista/layout/footer.php")?>

