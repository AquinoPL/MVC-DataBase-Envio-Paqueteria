<?php
require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $direccion_destino = $_POST['direccion_destino'];
    $telefono_destino = $_POST['telefono_destino'];
    $id_paquete = $_POST['id_paquete'];
    $fecha_envio = $_POST['fecha_envio'];

    $query = "INSERT INTO envio (direccion_destino, telefono_destino, id_paquete, fecha_envio) 
              VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssis", $direccion_destino, $telefono_destino, $id_paquete, $fecha_envio);

    if ($stmt->execute()) {
        echo "Envío registrado exitosamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
