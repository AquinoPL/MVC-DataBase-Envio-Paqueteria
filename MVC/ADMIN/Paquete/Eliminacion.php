<?php
// Conectar a la base de datos
require_once '../conexion.php';

// Obtener ID del paquete a eliminar
$id_paquete = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_paquete > 0) {
    // Eliminar el paquete
    $stmt = $conn->prepare("DELETE FROM paquete WHERE id_paquete = ?");
    $stmt->bind_param("i", $id_paquete);

    if ($stmt->execute()) {
        echo "<p class='text-center'>Paquete eliminado correctamente.</p>";
    } else {
        echo "<p class='text-center'>Error al eliminar el paquete: " . $conn->error . "</p>";
    }

    $stmt->close();
} else {
    echo "<p class='text-center'>ID de paquete inválido.</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="vista/css/app.css">
    <title>Eliminar Paquete</title>
</head>
<body>
    <div class="panel text-center">
        <a href="PaqueteForm.php" class="btn">Volver a la lista de paquetes</a>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
