<?php
// Conectar a la base de datos
require_once '../conexion.php';

// Consultar todos los paquetes
$query = "SELECT * FROM paquete";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../vista/css/app.css">
    <title>Mostrar Paquetes</title>
</head>
<body>
    <div class="panel">
        <h1 class="text-center">Lista de Paquetes</h1>
        <div class="text-center">
            <!-- Botón para añadir un nuevo paquete -->
            <a href="Insercion.php" class="btn">Añadir Paquete</a>
        </div>
        <?php
        if ($result && $result->num_rows > 0) {
        ?>
        <table>
            <tr>
                <td>ID Paquete</td>
                <td>Tipo Contenido</td>
                <td>Peso</td>
                <td>Dimensiones</td>
                <td>Estado Paquete</td>
                <td>ID Envío</td>
                <td>Acción</td>
            </tr>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id_paquete']); ?></td>
                        <td><?php echo htmlspecialchars($row['tipo_contenido']); ?></td>
                        <td><?php echo htmlspecialchars($row['peso']); ?></td>
                        <td><?php echo htmlspecialchars($row['dimenciones']); ?></td>
                        <td><?php echo htmlspecialchars($row['estado_paquete']); ?></td>
                        <td><?php echo htmlspecialchars($row['id_envio']); ?></td>
                        <td>
                            <!-- Acción para actualizar -->
                            <a class="btn" href='Edicion.php?id=<?php echo urlencode($row['id_paquete']); ?>'>Actualizar</a>
                            <!-- Acción para eliminar -->
                            <a class="btn" href='Eliminacion.php?id=<?php echo urlencode($row['id_paquete']); ?>'>Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php
        } else {
            echo "<p class='text-center'>No hay paquetes registrados.</p>";
        }
        ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>