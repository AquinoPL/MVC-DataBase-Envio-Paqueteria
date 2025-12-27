<?php
require_once '../conexion.php';

if (isset($_GET['id'])) {
    $id_empleado = $_GET['id'];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $clave = $_POST['clave'];
        $provincia = $_POST['provincia'];

        $query = "UPDATE empleado SET nombre = ?, apellido = ?, clave = ?, provincia = ? WHERE id_empleado = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $nombre, $apellido, $clave, $provincia, $id_empleado);

        if ($stmt->execute()) {
            echo "<p>Empleado actualizado exitosamente.</p>";
        } else {
            echo "<p>Error al actualizar empleado: " . $conn->error . "</p>";
        }

        $stmt->close();
    }

    $query = "SELECT * FROM empleado WHERE id_empleado = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_empleado);
    $stmt->execute();
    $result = $stmt->get_result();
    $empleado = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "<p>ID de empleado no proporcionado.</p>";
    exit;
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
            <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($empleado['nombre']); ?>" required> <br><br>
            <label for="apellido">Apellido:</label>
            <input type="text" name="apellido" id="apellido" value="<?php echo htmlspecialchars($empleado['apellido']); ?>" required> <br><br>
            <label for="clave">Clave:</label>
            <input type="text" name="clave" id="clave" value="<?php echo htmlspecialchars($empleado['clave']); ?>" required> <br><br>
            <label for="provincia">Provincia:</label>
            <input type="text" name="provincia" id="provincia" value="<?php echo htmlspecialchars($empleado['provincia']); ?>" required> <br><br>
            <input type="submit" class="btn" value="Actualizar Empleado">
        </form>
        </div>
</body>
</html>