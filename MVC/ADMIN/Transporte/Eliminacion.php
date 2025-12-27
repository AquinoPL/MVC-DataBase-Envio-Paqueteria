<?php
require_once '../conexion.php';

// Verificar si se recibió un ID para eliminar
if (isset($_POST['id_transporte'])) {
    $id_transporte = $_POST['id_transporte'];

    // Preparar la sentencia para eliminar el registro
    $sql = "DELETE FROM transporte WHERE id_transporte = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_transporte);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $message = "Transporte eliminado exitosamente.";
    } else {
        $message = "Error al eliminar el transporte o el transporte no existe.";
    }

    $stmt->close();
    $conn->close();
} else {
    $message = "ID de transporte no proporcionado.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Transporte</title>
</head>
<body>
    <h1>Eliminar Transporte</h1>

    <p><?php echo isset($message) ? $message : ''; ?></p>

    <hr>
    <a href="TransporteForm.php">Volver a la lista de transportes</a>
</body>
</html>
