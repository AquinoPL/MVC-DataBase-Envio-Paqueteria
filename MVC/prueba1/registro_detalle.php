<?php
include 'includes/config.php'; // Incluye la configuración de la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_envio = $_POST['id_envio'];
    $modalidad_envio = $_POST['modalidad_envio'];
    $modalidad_entrega = $_POST['modalidad_entrega'];
    $fecha_entrega = $_POST['fecha_entrega'] ?? null; // Puedes agregar un campo de fecha de entrega opcional

    try {
        // Verificar que el envío exista
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM envio WHERE id_envio = ?");
        $stmt->execute([$id_envio]);
        if ($stmt->fetchColumn() == 0) {
            throw new Exception("El envío con ID $id_envio no existe.");
        }

        // Registrar los detalles del envío
        $stmt = $pdo->prepare("INSERT INTO detalle (modalidad_envio, modalidad_entrega, id_envio, fecha_entrega) VALUES (?, ?, ?, ?)");
        $stmt->execute([$modalidad_envio, $modalidad_entrega, $id_envio, $fecha_entrega]);

        echo "Detalles del envío registrados exitosamente.";
    } catch (Exception $e) {
        echo "Error al registrar los detalles: " . htmlspecialchars($e->getMessage());
    }
}
?>
