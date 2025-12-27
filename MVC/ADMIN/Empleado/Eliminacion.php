<?php
// Conectar a la base de datos
require_once '../conexion.php';

// Manejar la acción de eliminación
if (isset($_GET['id'])) {
    $id_empleado = $_GET['id'];
    $query = "DELETE FROM empleado WHERE id_empleado = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_empleado);
    $stmt->execute();
    $stmt->close();

    echo "<p>Empleado eliminado con éxito.</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="vista/css/app.css">
    <title>Eliminar Empleado</title>
</head>
<body>
    <div class="panel">
        <h1 class="text-center">Eliminar Empleado</h1>
        <p>Empleado eliminado con éxito.</p>
        <a href="empleado_mostrar.php" class="btn">Volver a la lista</a>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
