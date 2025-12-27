<?php
// Conectar a la base de datos
require_once '../conexion.php';
// Consultar todos los empleados
$query = "SELECT * FROM empleado";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../vista/css/app.css">
    <title>Mostrar Empleados</title>
</head>
<body>
    <div class="panel">
        <h1 class="text-center">Lista de Empleados</h1>
        <div class="text-center">
            <!-- Botón para añadir un nuevo empleado -->
            <a href="Insercion.php" class="btn">NUEVO</a>
        </div>
        <?php
        if ($result && $result->num_rows > 0) {
        ?>
        <table>
            <tr>
                <td>ID Empleado</td>
                <td>Nombre</td>
                <td>Clave</td>
                <td>Teléfono</td>
                <td>ID Agencia</td>
                <td>Acción</td>
            </tr>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id_empleado']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['clave']); ?></td>
                        <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                        <td><?php echo htmlspecialchars($row['id_agencia']); ?></td>
                        <td>
                            <!-- Acción para actualizar -->
                            <a class="btn" href='Edicion.php?id=<?php echo urlencode($row['id_empleado']); ?>'>Actualizar</a>
                            <!-- Acción para eliminar -->
                            <a class="btn" href='Eliminacion.php?id=<?php echo urlencode($row['id_empleado']); ?>'>Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php
        } else {
            echo "<p class='text-center'>No hay empleados registrados.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>