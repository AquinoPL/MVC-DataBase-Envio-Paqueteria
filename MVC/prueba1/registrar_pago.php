<?php
// registrar_pago.php
include 'includes/config.php'; // Incluye la configuración de la base de datos

// Obtener datos del formulario
$id_orden = $_POST['id_orden'];
$modalidad_pago = $_POST['modalidad_pago'];
$metodo_pago = $_POST['metodo_pago'];
$responsable_pago = $_POST['responsable_pago'];
$estado = 'pendiente'; // O puedes ajustar según sea necesario
$costo_total = $_POST['costo_total']; // Asegúrate de calcular el costo total correctamente

// Insertar el pago en la base de datos
$sql_pago = "INSERT INTO pago (id_orden, modalidad_pago, metodo_pago, responsable_pago, estado, costo_total) 
             VALUES (:id_orden, :modalidad_pago, :metodo_pago, :responsable_pago, :estado, :costo_total)";
$stmt_pago = $pdo->prepare($sql_pago);

$params_pago = [
    ':id_orden' => $id_orden,
    ':modalidad_pago' => $modalidad_pago,
    ':metodo_pago' => $metodo_pago,
    ':responsable_pago' => $responsable_pago,
    ':estado' => $estado,
    ':costo_total' => $costo_total,
];

if ($stmt_pago->execute($params_pago)) {
    echo "Pago registrado exitosamente.";
} else {
    echo "Error al registrar el pago: " . $stmt_pago->errorInfo()[2];
}
?>
