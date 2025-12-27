<?php
require_once '../conexion.php';

// Verificar si se recibió un ID para editar
if (isset($_POST['id_transporte'])) {
    $id_transporte = $_POST['id_transporte'];

    // Recuperar los datos actuales del transporte
    $sql = "SELECT * FROM transporte WHERE id_transporte = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_transporte);
    $stmt->execute();
    $result = $stmt->get_result();
    $transporte = $result->fetch_assoc();

    // Verificar si se enviaron los datos del formulario para actualizar
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tipo_transporte'])) {
        $tipo_transporte = $_POST['tipo_transporte'];
        $numero_placa = $_POST['numero_placa'];
        $id_agencia = $_POST['id_agencia'];

        // Actualizar el transporte en la base de datos
        $sql = "UPDATE transporte SET tipo_transporte = ?, numero_placa = ?, id_agencia = ? WHERE id_transporte = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $tipo_transporte, $numero_placa, $id_agencia, $id_transporte);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $message = "Transporte actualizado exitosamente.";
        } else {
            $message = "Error al actualizar el transporte o no se realizaron cambios.";
        }

        $stmt->close();
        $conn->close();
    }
} else {
    $message = "ID de transporte no proporcionado.";
    $transporte = null;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Transporte</title>
</head>
<body>
    <h1>Editar Transporte</h1>

    <?php if ($transporte): ?>
    <form action="Edicion.php" method="post">
        <input type="hidden" name="id_transporte" value="<?php echo htmlspecialchars($transporte['id_transporte']); ?>">

        <label for="tipo_transporte">Tipo de Transporte:</label>
        <input type="text" id="tipo_transporte" name="tipo_transporte" value="<?php echo htmlspecialchars($transporte['tipo_transporte']); ?>" required><br><br>

        <label for="numero_placa">Número de Placa:</label>
        <input type="text" id="numero_placa" name="numero_placa" value="<?php echo htmlspecialchars($transporte['numero_placa']); ?>"><br><br>

        <label for="id_agencia">ID Agencia:</label>
        <input type="number" id="id_agencia" name="id_agencia" value="<?php echo htmlspecialchars($transporte['id_agencia']); ?>" required><br><br>

        <input type="submit" value="Actualizar">
    </form>
    <?php else: ?>
    <p><?php echo isset($message) ? $message : ''; ?></p>
    <?php endif; ?>

    <hr>
    <a href="TransporteForm.php">Volver a la lista de transportes</a>
</body>
</html>
