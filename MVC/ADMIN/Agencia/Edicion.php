<?php
require_once '../conexion.php';

// Verificar si se recibió un ID para editar
if (isset($_POST['id_agencia'])) {
    $id_agencia = $_POST['id_agencia'];

    // Recuperar los datos actuales de la agencia
    $sql = "SELECT * FROM agencia WHERE id_agencia = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_agencia);
    $stmt->execute();
    $result = $stmt->get_result();
    $agencia = $result->fetch_assoc();

    // Verificar si se enviaron los datos del formulario para actualizar
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['provincia'])) {
        $provincia = $_POST['provincia'];
        $numero_sede = $_POST['numero_sede'];
        $direccion = $_POST['direccion'];
        $telefono = $_POST['telefono'];

        // Actualizar la agencia en la base de datos
        $sql = "UPDATE agencia SET provincia = ?, numero_sede = ?, direccion = ?, telefono = ? WHERE id_agencia = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $provincia, $numero_sede, $direccion, $telefono, $id_agencia);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $message = "Agencia actualizada exitosamente.";
        } else {
            $message = "Error al actualizar la agencia o no se realizaron cambios.";
        }

        $stmt->close();
        $conn->close();
    }
} else {
    $message = "ID de agencia no proporcionado.";
    $agencia = null;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Agencia</title>
</head>
<body>
    <h1>Editar Agencia</h1>

    <?php if ($agencia): ?>
    <form action="Edicion.php" method="post">
        <input type="hidden" name="id_agencia" value="<?php echo htmlspecialchars($agencia['id_agencia']); ?>">

        <label for="provincia">Provincia:</label>
        <input type="text" id="provincia" name="provincia" value="<?php echo htmlspecialchars($agencia['provincia']); ?>" required><br><br>

        <label for="numero_sede">Número de Sede:</label>
        <input type="text" id="numero_sede" name="numero_sede" value="<?php echo htmlspecialchars($agencia['numero_sede']); ?>" required><br><br>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" value="<?php echo htmlspecialchars($agencia['direccion']); ?>" required><br><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($agencia['telefono']); ?>"><br><br>

        <input type="submit" value="Actualizar">
    </form>
    <?php else: ?>
    <p><?php echo isset($message) ? $message : ''; ?></p>
    <?php endif; ?>

    <hr>
    <a href="AgenciaForm.php">Volver a la lista de agencias</a>
</body>
</html>
