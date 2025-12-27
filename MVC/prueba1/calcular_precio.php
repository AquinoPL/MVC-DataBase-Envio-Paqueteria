<?php
// calcular_precio.php
include 'includes/config.php'; // Incluye la configuración de la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $tipo_contenido = $_POST['tipo_contenido'];
    $peso = $_POST['peso'];
    $dimenciones = $_POST['dimenciones'];
    $modalidad_envio = $_POST['modalidad_envio'];
    $modalidad_entrega = $_POST['modalidad_entrega'];

    // Validar datos
    if (empty($origen) || empty($destino) || empty($tipo_contenido) || empty($peso) || empty($dimenciones) || empty($modalidad_envio) || empty($modalidad_entrega)) {
        die('Todos los campos son requeridos.');
    }

    // Calcular el precio del envío
    // Aquí deberías incluir la lógica para calcular el precio basado en la ruta y las dimensiones de los paquetes.
    // Para fines de demostración, vamos a usar un costo fijo por ahora.
    $precio_base = 50; // Precio base ficticio
    $precio_total = $precio_base; // Aquí debes calcular el precio total basándote en los paquetes y la ruta

    // Generar un código de envío
    $codigo_envio = strtoupper(bin2hex(random_bytes(4))); // Genera un código de 8 caracteres

    // Registrar el envío en la base de datos
    try {
        $stmt = $pdo->prepare("INSERT INTO envio (clave, origen, destino, u_remitente, u_destinatario, modalidad_envio, modalidad_entrega, id_transporte) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$codigo_envio, $origen, $destino, 'REM001', 'DEST001', $modalidad_envio, $modalidad_entrega, 1]); // Cambia 'REM001', 'DEST001' y 1 por los valores correctos

        // Obtener el ID del envío recién creado
        $id_envio = $pdo->lastInsertId();

        // Insertar los paquetes en la base de datos
        foreach ($tipo_contenido as $index => $contenido) {
            $peso_paquete = $peso[$index];
            $dimensiones_paquete = $dimenciones[$index];
            $stmt = $pdo->prepare("INSERT INTO paquete (tipo_contenido, peso, dimenciones, id_envio) VALUES (?, ?, ?, ?)");
            $stmt->execute([$contenido, $peso_paquete, $dimensiones_paquete, $id_envio]);
        }

        // Redirigir al usuario a la página de pago con el código de envío
        header("Location: pago.php?codigo_envio=$codigo_envio&precio_total=$precio_total");
        exit();
    } catch (PDOException $e) {
        echo 'Error al registrar el envío: ' . $e->getMessage();
    }
} else {
    echo 'Método no permitido.';
}
?>
