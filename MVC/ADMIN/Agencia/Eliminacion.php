<?php
require_once '../conexion.php';

// Verificar si se recibió un ID para eliminar
if (isset($_POST['id_agencia'])) {
    $id_agencia = $_POST['id_agencia'];

    // Preparar la sentencia para eliminar el registro
    $sql = "DELETE FROM agencia WHERE id_agencia = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_agencia);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $message = "Agencia eliminada exitosamente.";
    } else {
        $message = "Error al eliminar la agencia o la agencia no existe.";
    }

    $stmt->close();
    $conn->close();
} else {
    $message = "ID de agencia no proporcionado.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Agencia</title>
</head>
<body>
    <h1>Eliminar Agencia</h1>

    <p><?php echo isset($message) ? $message : ''; ?></p>

    <hr>
    <a href="AgenciaForm.php">Volver a la lista de agencias</a>
</body>
</html>
