<?php
require_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $clave = $_POST['clave'];
    $telefono = $_POST['telefono'];
    $id_agencia = $_POST['id_agencia'];

    $query = "INSERT INTO empleado (nombre, clave, telefono, id_agencia) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $nombre, $clave, $telefono, $id_agencia);

    if ($stmt->execute()) {
        echo "<p>Empleado agregado exitosamente.</p>";
    } else {
        echo "<p>Error al agregar empleado: " . $conn->error . "</p>";
    }

    $stmt->close();
}

// Obtener las agencias para el menú desplegable
$sql = "SELECT id_agencia, provincia FROM agencia";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../vista/css/app.css">
    <title>Insertar Empleado</title>
</head>
<body>
    <div class="panel">
        <h1 class="text-center">Agregar Nuevo Empleado</h1>
        <form action="Insercion.php" method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required> <br><br>

            <label for="clave">Clave:</label>
            <input type="text" name="clave" id="clave" required> <br><br>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono"> <br><br>

            <label for="id_agencia">Agencia:</label>
            <select name="id_agencia" id="id_agencia" required>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["id_agencia"] . "'>" . $row["provincia"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay agencias disponibles</option>";
                }
                ?>
            </select> <br><br>

            <input type="submit" class="btn" value="Agregar Empleado">
        </form>

        <hr>
        <a href="EmpleadoForm.php" class="btn">Volver a la lista de empleados</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
