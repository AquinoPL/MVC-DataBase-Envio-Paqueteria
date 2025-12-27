<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../vista/css/app.css">
    <title>Insertar Transporte</title>
</head>
<body>
    <h1>Insertar Transporte</h1>

    <?php
    require_once '../conexion.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $tipo_transporte = $_POST['tipo_transporte'];
        $numero_placa = $_POST['numero_placa'];
        $id_agencia = $_POST['id_agencia'];

        // Insertar el nuevo transporte en la base de datos
        $sql = "INSERT INTO transporte (tipo_transporte, numero_placa, id_agencia) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $tipo_transporte, $numero_placa, $id_agencia);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<p>Transporte insertado exitosamente.</p>";
        } else {
            echo "<p>Error al insertar el transporte.</p>";
        }

        $stmt->close();
    }

    // Obtener las agencias para el menú desplegable
    $sql = "SELECT id_agencia, provincia FROM agencia";
    $result = $conn->query($sql);
    ?>
    
    <form action="Insercion.php" method="post">
        <label for="tipo_transporte">Tipo de Transporte:</label>
        <input type="text" id="tipo_transporte" name="tipo_transporte" required><br><br>

        <label for="numero_placa">Número de Placa:</label>
        <input type="text" id="numero_placa" name="numero_placa"><br><br>

        <label for="id_agencia">ID Agencia:</label>
        <select id="id_agencia" name="id_agencia" required>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["id_agencia"] . "'>" . $row["provincia"] . "</option>";
                }
            } else {
                echo "<option value=''>No hay agencias disponibles</option>";
            }
            ?>
        </select><br><br>

        <input type="submit" value="Insertar">
    </form>

    <hr>
    <a href="TransporteForm.php">Volver a la lista de transportes</a>
</body>
</html>
