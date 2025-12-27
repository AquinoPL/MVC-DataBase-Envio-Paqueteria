<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuario</title>
    <link rel="stylesheet" href="../vista/css/app.css">
</head>
<body>
    <h1>Usuarios</h1>

    <a href="UsuarioForm.php">Insertar Usuario</a>

    <hr>

    <?php
    require_once '../conexion.php';

    $sql = "SELECT * FROM usuario";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Lista de Usuarios</h2>";
        echo "<table>";
        echo "<tr><th>Documento</th><th>Tipo de Documento</th><th>Nombre</th><th>Teléfono</th><th>Acciones</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["num_documento"] . "</td>";
            echo "<td>" . $row["tipo_documento"] . "</td>";
            echo "<td>" . $row["nombre"] . "</td>";
            echo "<td>" . $row["telefono"] . "</td>";
            echo "<td>
                    <form action='Edicion.php' method='post' style='display:inline;'>
                        <input type='hidden' name='num_documento' value='" . $row["num_documento"] . "'>
                        <input type='submit' value='Editar'>
                    </form>
                    <form action='Eliminacion.php' method='post' style='display:inline;'>
                        <input type='hidden' name='num_documento' value='" . $row["num_documento"] . "'>
                        <input type='submit' value='Eliminar'>
                    </form>
                  </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No se encontraron usuarios.";
    }

    $conn->close();
    ?>

    <hr>
    <a href="../index.php">Volver al Menú Principal</a>
</body>
</html>
