<?php
// registro_envio.php
include 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir datos del formulario
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $u_remitente = $_POST['u_remitente'];
    $u_destinatario = $_POST['u_destinatario'];
    $id_transporte = $_POST['id_transporte'];
    $modalidad_envio = $_POST['modalidad_envio'];
    $modalidad_entrega = $_POST['modalidad_entrega'];
    $paquetes = $_POST['paquete']; // Array de paquetes con detalles

    // Datos del remitente
    $tipo_documento_remitente = $_POST['tipo_documento_remitente'];
    $nombre_remitente = $_POST['nombre_remitente'];
    $telefono_remitente = $_POST['telefono_remitente'];

    // Datos del destinatario
    $tipo_documento_destinatario = $_POST['tipo_documento_destinatario'];
    $nombre_destinatario = $_POST['nombre_destinatario'];
    $telefono_destinatario = $_POST['telefono_destinatario'];

    try {
        // Iniciar una transacción
        $pdo->beginTransaction();

        // Verificar y/o registrar el remitente
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuario WHERE num_documento = ?");
        $stmt->execute([$u_remitente]);
        $remitente_existe = $stmt->fetchColumn();

        if (!$remitente_existe) {
            $stmt = $pdo->prepare("INSERT INTO usuario (num_documento, tipo_documento, nombre, telefono) VALUES (?, ?, ?, ?)");
            $stmt->execute([$u_remitente, $tipo_documento_remitente, $nombre_remitente, $telefono_remitente]);
        }

        // Verificar y/o registrar el destinatario
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuario WHERE num_documento = ?");
        $stmt->execute([$u_destinatario]);
        $destinatario_existe = $stmt->fetchColumn();

        if (!$destinatario_existe) {
            $stmt = $pdo->prepare("INSERT INTO usuario (num_documento, tipo_documento, nombre, telefono) VALUES (?, ?, ?, ?)");
            $stmt->execute([$u_destinatario, $tipo_documento_destinatario, $nombre_destinatario, $telefono_destinatario]);
        }

        // Registrar el envío
        $stmt = $pdo->prepare("INSERT INTO envio (clave, origen, destino, u_remitente, u_destinatario, modalidad_envio, modalidad_entrega, id_transporte) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $clave = $_POST['clave']; // Usar la clave proporcionada
        $stmt->execute([$clave, $origen, $destino, $u_remitente, $u_destinatario, $modalidad_envio, $modalidad_entrega, $id_transporte]);

        $id_envio = $pdo->lastInsertId(); // Obtener el ID del último envío registrado

        // Registrar los paquetes
        $stmt = $pdo->prepare("INSERT INTO paquete (id_envio, tipo_contenido, peso, dimenciones) VALUES (?, ?, ?, ?)");
        foreach ($paquetes as $paquete) {
            $stmt->execute([$id_envio, $paquete['tipo_contenido'], $paquete['peso'], $paquete['dimenciones']]);
        }

        // Confirmar la transacción
        $pdo->commit();
        
        // Redirigir a la página para registrar detalles del envío
        header("Location: registro_detalle.php?id_envio=" . urlencode($id_envio));
        exit;
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $pdo->rollBack();
        echo "Error al registrar el envío: " . htmlspecialchars($e->getMessage());
    }
}
?>
