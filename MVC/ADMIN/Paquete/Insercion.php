<?php
// Conectar a la base de datos
require_once '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $tipo_contenido = $_POST['tipo_contenido'];
    $peso = $_POST['peso'];
    $dimenciones = $_POST['dimenciones'];
    $estado_paquete = $_POST['estado_paquete'];
    $id_envio = $_POST['id_envio'];

    // Insertar el nuevo paquete
    $stmt = $conn->prepare("INSERT INTO paquete (tipo_contenido, peso, dimenciones, estado_paquete, id_envio) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsdi", $tipo_contenido, $peso, $dimenciones, $estado_paquete, $id_envio);

    if ($stmt->execute()) {
        echo "<p class='text-center'>Paquete añadido correctamente.</p>";
    } else {
        echo "<p class='text-center'>Error al añadir el paquete: " . $conn->error . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../vista/css/app.css">
    <title>Insertar Paquete</title>
</head>
<body>
    <div class="panel">
        <h1 class="text-center">Añadir Nuevo Paquete</h1>
        <form action="" method="post">
            <label for="tipo_contenido">Tipo de Contenido:</label>
            <input type="text" id="tipo_contenido" name="tipo_contenido" required><br><br>
            <label for="peso">Peso:</label>
            <input type="number" id="peso" name="peso" step="0.01" required><br><br>
            <label for="dimenciones">Dimensiones:</label>
            <input type="text" id="dimenciones" name="dimenciones" required><br><br>
            <label for="estado_paquete">Estado del Paquete:</label>
            <input type="text" id="estado_paquete" name="estado_paquete" required><br><br>
            <label for="id_envio">ID Envío:</label>
            <input type="number" id="id_envio" name="id_envio" required><br><br>
            <input type="submit" class="btn" value="Añadir Paquete">
        </form>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>
