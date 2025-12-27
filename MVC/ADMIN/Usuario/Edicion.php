<?php
// Conectar a la base de datos
require_once 'conexion.php';

// Manejar la acción de actualización
if (isset($_GET['id'])) {
    $id_empleado = $_GET['id'];

    // Obtener datos actuales del empleado
    $query = "SELECT * FROM empleado WHERE id_empleado = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_empleado);
    $stmt->execute();
    $result = $stmt->get_result();
    $empleado = $result->fetch_assoc();
    $stmt->close();

    // Manejar el formulario de actualización
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $clave = $_POST['clave'];
        $telefono = $_POST['telefono'];
        $id_agencia = $_POST['id_agencia'];

        $query = "UPDATE empleado SET nombre = ?, clave = ?, telefono = ?, id_agencia = ? WHERE id_empleado = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssii", $nombre, $clave, $telefono, $id_agencia, $id_empleado);
        $stmt->execute();
        $stmt->close();

        echo "<p>Empleado actualizado con éxito.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="vista/css/app.css">
    <title>Actualizar Empleado</title>
</head>
<body>
    <div class="panel">
        <h1 class="text-center">Actualizar Empleado</h1>
        <form action="Edicion.php?id=<?php echo urlencode($id_empleado); ?>" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($empleado['nombre']); ?>" required><br><br>
            <label for="clave">Clave:</label>
            <input type="text" name="clave" id="clave" value="<?php echo htmlspecialchars($empleado['clave']); ?>" required><br><br>
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" value="<?php echo htmlspecialchars($empleado['telefono']); ?>"><br><br>
            <label for="id_agencia">ID Agencia:</label>
            <input type="number" name="id_agencia" id="id_agencia" value="<?php echo htmlspecialchars($empleado['id_agencia']); ?>" required><br><br>
            <input type="submit" class="btn" value="Actualizar Empleado">
        </form>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
