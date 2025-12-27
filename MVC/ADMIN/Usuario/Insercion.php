<?php 

require_once 'conexion.php';

// Manejar el formulario de inserción
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $clave = $_POST['clave'];
    $telefono = $_POST['telefono'];
    $id_agencia = $_POST['id_agencia'];

    $query = "INSERT INTO empleado (nombre, clave, telefono, id_agencia) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $nombre, $clave, $telefono, $id_agencia);
    $stmt->execute();
    $stmt->close();

    echo "<p>Empleado insertado con éxito.</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="vista/css/app.css">
    <title>Insertar Empleado</title>
</head>
<body>
    <div class="panel">
        <h1 class="text-center">Insertar Nuevo Empleado</h1>
        <form action="Insercion.php" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required><br><br>
            <label for="clave">Clave:</label>
            <input type="text" name="clave" id="clave" required><br><br>
            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono"><br><br>
            <label for="id_agencia">ID Agencia:</label>
            <input type="number" name="id_agencia" id="id_agencia" required><br><br>
            <input type="submit" class="btn" value="Insertar Empleado">
        </form>
    </div>
</body>
</html>

<?php
// Cerrar la conexión
$conn->close();
?>