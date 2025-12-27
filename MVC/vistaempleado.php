<?php
// Conectar a la base de datos
require_once 'conexion.php';

// Manejar la acción de actualización
if (isset($_GET['m']) && $_GET['m'] === 'actualizar_paquete') {
    $id_paquete = $_GET['id'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nuevo_estado = $_POST['estado_paquete'];
        $query = "UPDATE paquete SET estado_paquete = ? WHERE id_paquete = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $nuevo_estado, $id_paquete);
        $stmt->execute();
        $stmt->close();
        echo "<p>Estado del paquete actualizado con éxito.</p>";
    }

    // Formulario para actualizar el estado del paquete
    $query = "SELECT * FROM paquete WHERE id_paquete = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_paquete);
    $stmt->execute();
    $result = $stmt->get_result();
    $paquete = $result->fetch_assoc();
    $stmt->close();
    ?>
    <h1 class="text-center">Actualizar Estado del Paquete</h1>
    <form action="vistaempleado.php?m=actualizar_paquete&id=<?php echo urlencode($id_paquete); ?>" method="post">
        <label for="estado_paquete">Nuevo Estado:</label>
        <input type="text" name="estado_paquete" id="estado_paquete" value="<?php echo htmlspecialchars($paquete['estado_paquete']); ?>" required> <br><br>
        <input type="submit" class="btn" value="Actualizar Estado">
    </form>
    <?php
    exit;
}

// Manejar la acción de eliminación
if (isset($_GET['m']) && $_GET['m'] === 'rechazar_paquete') {
    $id_paquete = $_GET['id'];
    $query = "DELETE FROM paquete WHERE id_paquete = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_paquete);
    $stmt->execute();
    $stmt->close();
    echo "<p>Paquete rechazado con éxito.</p>";
}

// Consultar paquetes en estado 'en espera'
$query = "
    SELECT p.id_paquete, p.tipo_contenido, p.peso, p.dimenciones, p.estado_paquete, 
    e.clave, e.u_remitente, u.num_documento, e.origen, a.id_agencia, a.provincia
    FROM paquete p
    INNER JOIN envio e ON p.id_envio = e.id_envio
    INNER JOIN usuario u ON e.u_remitente = u.num_documento
    INNER JOIN agencia a ON e.origen = a.id_agencia
    WHERE p.estado_paquete = 'en espera';
";
$result = $conn->query($query);
?>

<?php require_once("vista/layout/header.php"); ?>
<h1 class="text-center">Gestión de Paquetes</h1>
<hr>
        <?php
        if ($result && $result->num_rows > 0) {
        ?>
        <table>
            <tr>
                <td>ID Paquete</td>
                <td>Remitente</td>
                <td>Tipo de Contenido</td>
                <td>Peso(Kg)</td>
                <td>Dimensiones</td>
                <td>Estado del Paquete</td>
                <td>Acción</td>
            </tr>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id_paquete']); ?></td>
                        <td><?php echo htmlspecialchars($row['num_documento']); ?></td>
                        <td><?php echo htmlspecialchars($row['tipo_contenido']); ?></td>
                        <td><?php echo htmlspecialchars($row['peso']); ?></td>
                        <td><?php echo htmlspecialchars($row['dimenciones']); ?></td>
                        <td><?php echo htmlspecialchars($row['estado_paquete']); ?></td>
                        <td>
                            <!-- Acción para actualizar estado -->
                            <a class="btn" href='vistaempleado.php?m=actualizar_paquete&id=<?php echo urlencode($row['id_paquete']); ?>'>Actualizar</a>
                            <!-- Acción para rechazar paquete -->
                            <a class="btn" href='vistaempleado.php?m=rechazar_paquete&id=<?php echo urlencode($row['id_paquete']); ?>'>Rechazar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php
        } else {
            echo "<p class='text-center'>No hay paquetes en espera.</p>";
        }
        $conn->close();
        ?>
        
<?php require_once("vista/layout/footer.php"); ?>