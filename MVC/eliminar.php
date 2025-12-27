<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="vista/css/app.css">
    <title>Eliminar Registro</title>
</head>
<body>
    <div class="panel">
        <h1 class="text-center">Eliminar Registro</h1>
        <hr>

        <?php
        require_once 'conexion.php';

        // Obtener la tabla seleccionada y el ID del registro
        $tabla = isset($_GET['tabla']) ? $_GET['tabla'] : 'agencia';
        $id = isset($_GET['id']) ? $_GET['id'] : '';

        // Consultar los datos del registro
        $query = "SELECT * FROM " . $conn->real_escape_string($tabla) . " WHERE id_agencia = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $registro = $result->fetch_assoc();
        ?>

        <p>¿Está seguro de que desea eliminar el registro con ID <?php echo htmlspecialchars($id); ?>?</p>
        <form action="guardar.php" method="post">
            <input type="hidden" name="tabla" value="<?php echo htmlspecialchars($tabla); ?>">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            <input type="hidden" name="accion" value="eliminar">
            <input type="submit" class="btn" value="Eliminar">
            <a href="index.php" class="btn">Cancelar</a>
        </form>
        <?php $conn->close(); ?>
<?php require_once("vista/layout/footer.php")?>


