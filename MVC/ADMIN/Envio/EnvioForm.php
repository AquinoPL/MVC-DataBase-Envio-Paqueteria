<?php
require_once '../conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura de datos del formulario
    $id_remitente = $_POST['id_remitente'];
    $id_destinatario = $_POST['id_destinatario'];
    $id_agencia = $_POST['id_agencia'];
    $transporte_asignado = $_POST['transporte_asignado'];
    $peso1 = $_POST['peso1'];
    $dimensiones1 = $_POST['dimensiones1'];
    $peso2 = $_POST['peso2'];
    $dimensiones2 = $_POST['dimensiones2'];
    $peso3 = $_POST['peso3'];
    $dimensiones3 = $_POST['dimensiones3'];
    
    // Inserción del envío
    $sql_envio = "INSERT INTO envio (id_remitente, id_destinatario, id_agencia, transporte_asignado) VALUES (?, ?, ?, ?)";
    $stmt_envio = $conn->prepare($sql_envio);
    $stmt_envio->bind_param("iiis", $id_remitente, $id_destinatario, $id_agencia, $transporte_asignado);
    
    if ($stmt_envio->execute()) {
        $id_envio = $stmt_envio->insert_id; // Obtener el ID del envío insertado
        
        // Insertar detalles del paquete
        $sql_paquete = "INSERT INTO paquete (id_envio, peso, dimensiones) VALUES (?, ?, ?)";
        $stmt_paquete = $conn->prepare($sql_paquete);

        $stmt_paquete->bind_param("iss", $id_envio, $peso1, $dimensiones1);
        $stmt_paquete->execute();

        $stmt_paquete->bind_param("iss", $id_envio, $peso2, $dimensiones2);
        $stmt_paquete->execute();

        $stmt_paquete->bind_param("iss", $id_envio, $peso3, $dimensiones3);
        $stmt_paquete->execute();

        if ($stmt_paquete->affected_rows > 0) {
            echo "<p>Envío y paquetes registrados exitosamente.</p>";
        } else {
            echo "<p>Error al registrar los paquetes.</p>";
        }

        $stmt_paquete->close();
    } else {
        echo "<p>Error al registrar el envío: " . $conn->error . "</p>";
    }

    $stmt_envio->close();
    $conn->close();
}

// Obtener usuarios, agencias y transportes para el menú desplegable
$sql_usuarios = "SELECT id_usuario, nombre FROM usuario";
$result_usuarios = $conn->query($sql_usuarios);

$sql_agencias = "SELECT id_agencia, provincia FROM agencia";
$result_agencias = $conn->query($sql_agencias);

$sql_transportes = "SELECT numero_placa FROM transporte";
$result_transportes = $conn->query($sql_transportes);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../vista/css/app.css">
    <title>Insertar Envío</title>
</head>
<body>
    <div class="panel">
        <h1 class="text-center">Agregar Nuevo Envío</h1>
        <form action="Insercion.php" method="post">
            <label for="id_remitente">Remitente:</label>
            <select name="id_remitente" id="id_remitente" required>
                <?php
                if ($result_usuarios->num_rows > 0) {
                    while ($row = $result_usuarios->fetch_assoc()) {
                        echo "<option value='" . $row["id_usuario"] . "'>" . $row["nombre"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay remitentes disponibles</option>";
                }
                ?>
            </select> <br><br>

            <label for="id_destinatario">Destinatario:</label>
            <select name="id_destinatario" id="id_destinatario" required>
                <?php
                if ($result_usuarios->num_rows > 0) {
                    while ($row = $result_usuarios->fetch_assoc()) {
                        echo "<option value='" . $row["id_usuario"] . "'>" . $row["nombre"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay destinatarios disponibles</option>";
                }
                ?>
            </select> <br><br>

            <label for="id_agencia">Agencia:</label>
            <select name="id_agencia" id="id_agencia" required>
                <?php
                if ($result_agencias->num_rows > 0) {
                    while ($row = $result_agencias->fetch_assoc()) {
                        echo "<option value='" . $row["id_agencia"] . "'>" . $row["provincia"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay agencias disponibles</option>";
                }
                ?>
            </select> <br><br>

            <label for="transporte_asignado">Transporte Asignado:</label>
            <select name="transporte_asignado" id="transporte_asignado" required>
                <?php
                if ($result_transportes->num_rows > 0) {
                    while ($row = $result_transportes->fetch_assoc()) {
                        echo "<option value='" . $row["numero_placa"] . "'>" . $row["numero_placa"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay transportes disponibles</option>";
                }
                ?>
            </select> <br><br>

            <label for="peso1">Peso Paquete 1:</label>
            <input type="text" name="peso1" id="peso1" required> <br><br>

            <label for="dimensiones1">Dimensiones Paquete 1:</label>
            <input type="text" name="dimensiones1" id="dimensiones1" required> <br><br>

            <label for="peso2">Peso Paquete 2:</label>
            <input type="text" name="peso2" id="peso2"> <br><br>

            <label for="dimensiones2">Dimensiones Paquete 2:</label>
            <input type="text" name="dimensiones2" id="dimensiones2"> <br><br>

            <label for="peso3">Peso Paquete 3:</label>
            <input type="text" name="peso3" id="peso3"> <br><br>

            <label for="dimensiones3">Dimensiones Paquete 3:</label>
            <input type="text" name="dimensiones3" id="dimensiones3"> <br><br>

            <input type="submit" class="btn" value="Agregar Envío">
        </form>

        <hr>
        <a href="TransporteForm.php" class="btn">Volver a la lista de envíos</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
