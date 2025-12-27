<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Transporte</title>
    <link rel="stylesheet" href="../vista/css/app.css">
</head>
<body>
    <h1>Transportes</h1>

    <a href="Insercion.php">Insertar Transporte</a>

    <hr>

    <?php
    require_once '../conexion.php';

    $sql = "SELECT * FROM transporte";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Lista de Transportes</h2>";
        echo "<table>";
        echo "<tr><th>ID Transporte</th><th>Tipo de Transporte</th><th>Número de Placa</th><th>ID Agencia</th><th>Acciones</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id_transporte"] . "</td>";
            echo "<td>" . $row["tipo_transporte"] . "</td>";
            echo "<td>" . $row["numero_placa"] . "</td>";
            echo "<td>" . $row["id_agencia"] . "</td>";
            echo "<td>
                    <form action='Edicion.php' method='post' style='display:inline;'>
                        <input type='hidden' name='id_transporte' value='" . $row["id_transporte"] . "'>
                        <input type='submit' value='Editar'>
                    </form>
                    <form action='Eliminacion.php' method='post' style='display:inline;'>
                        <input type='hidden' name='id_transporte' value='" . $row["id_transporte"] . "'>
                        <input type='submit' value='Eliminar'>
                    </form>
                  </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No se encontraron transportes.";
    }

    $conn->close();
    ?>

    <hr>
    <a href="../index.php">Volver al Menú Principal</a>
</body>
</html>
