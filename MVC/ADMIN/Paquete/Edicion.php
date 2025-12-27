<?php
// Conectar a la base de datos
require_once '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $id_paquete = $_POST['id_paquete'];
    $tipo_contenido = $_POST['tipo_contenido'];
    $peso = $_POST['peso'];
    $dimenciones = $_POST['dimenciones'];
    $estado_paquete = $_POST['estado_paquete'];
    $id_envio = $_POST['id_envio'];

    // Actualizar el paquete
    $stmt = $conn->prepare("UPDATE paquete SET tipo_contenido = ?, peso = ?, dimenciones = ?, estado_paquete = ?, id_envio = ? WHERE id_paquete = ?");
    $stmt->bind_param("sdsdii", $tipo_contenido, $peso, $dimenciones, $estado_paquete, $id_envio, $id_paquete);

    if ($stmt->execute()) {
        echo "<p class='text-center'>Paquete actualizado correctamente.</p>";
    } else {
        echo "<p class='text-center'>Error al actualizar el paquete: " . $conn->error . "</p>";
    }

    $stmt->close();
} else {
    // Obtener datos del paquete para mostrar en el formulario
    $id_paquete = isset($_GET['id']) ? intval($_GET['id']) : 0;
    $query = "SELECT * FROM paquete WHERE id_paquete = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_paquete);
    $stmt->execute();
    $result = $stmt->get_result();
    $paquete = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="vista/css/app.css">
    <title>Actualizar Paquete</title>
</head>
<body>
    <div class="panel">
        <h1 class="text-center">Actualizar Paquete</h1>
        <form action="" method="post">
            <input type="hidden" name="id_paquete" value="<?php echo htmlspecialchars($paquete['id_paquete']); ?>">
            <label for="tipo_contenido">Tipo de Contenido:</label>
            <input type="text" id="tipo_contenido" name="tipo_contenido" value="<?php echo htmlspecialchars($paquete['tipo_contenido']); ?>" required><br><br>
            <label for="peso">Peso:</label>
            <input type="number" id="peso" name="peso" step="0.01" value="<?php echo htmlspecialchars($paquete['peso']); ?>" required><br><br>
            <label for="dimenciones">Dimensiones:</label>
            <input type="text" id="dimenciones" name="dimenciones" value="<?php echo htmlspecialchars($paquete['dimenciones']); ?>" required><br><br>
            <label for="estado_paquete">Estado del Paquete:</label>
            <input type="text" id="estado_paquete" name="estado_paquete" value="<?php echo htmlspecialchars($paquete['estado_paquete']); ?>" required><br><br>
            <label for="id_envio">ID Envío:</label>
            <input type="number" id="id_envio" name="id_envio" value="<?php echo htmlspecialchars($paquete['id_envio']); ?>" required><br><br>
            <input type="submit" class="btn" value="Actualizar Paquete">
        </form>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
