<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../vista/css/app.css">
</head>
<body>
    <h1>Agencias</h1>

    <a href="Insercion.php">Insertar Agencia</a>

    <hr>

    <?php
    require_once '../conexion.php';

    $sql = "SELECT * FROM agencia";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Lista de Agencias</h2>";
        echo "<table>";
        echo "<tr><th>ID Agencia</th><th>Provincia</th><th>Número de Sede</th><th>Dirección</th><th>Teléfono</th><th>Acciones</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id_agencia"] . "</td>";
            echo "<td>" . $row["provincia"] . "</td>";
            echo "<td>" . $row["numero_sede"] . "</td>";
            echo "<td>" . $row["direccion"] . "</td>";
            echo "<td>" . $row["telefono"] . "</td>";
            echo "<td>
                    <form action='Edicion.php' method='post' style='display:inline;'>
                        <input type='hidden' name='id_agencia' value='" . $row["id_agencia"] . "'>
                        <input type='submit' value='Editar'>
                    </form>
                    <form action='Eliminacion.php' method='post' style='display:inline;'>
                        <input type='hidden' name='id_agencia' value='" . $row["id_agencia"] . "'>
                        <input type='submit' value='Eliminar'>
                    </form>
                  </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No se encontraron agencias.";
    }

    $conn->close();
    ?>

    <hr>
    <a href="../index.php">Volver al Menú Principal</a>
</body>
</html>
