<?php
include 'includes/config.php';

// Obtener sedes de origen y destino
$sql_sedes = "SELECT * FROM agencia";
$stmt_sedes = $pdo->prepare($sql_sedes);
$stmt_sedes->execute();
$sedes = $stmt_sedes->fetchAll();

// Obtener transportes
$sql_transportes = "SELECT * FROM transporte";
$stmt_transportes = $pdo->prepare($sql_transportes);
$stmt_transportes->execute();
$transportes = $stmt_transportes->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registro de Envío</title>
</head>
<body>
    <h1>Registro de Envío</h1>
    <form action="registro_envio.php" method="post">
        <label for="origen">Sede de Origen:</label>
        <select name="origen" id="origen" required>
            <?php foreach ($sedes as $sede): ?>
                <option value="<?= $sede['id_agencia'] ?>"><?= $sede['direccion'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="destino">Sede de Destino:</label>
        <select name="destino" id="destino" required>
            <?php foreach ($sedes as $sede): ?>
                <option value="<?= $sede['id_agencia'] ?>"><?= $sede['direccion'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="u_remitente">Documento del Remitente:</label>
        <input type="text" name="u_remitente" id="u_remitente" required><br><br>

        <label for="tipo_documento_remitente">Tipo de Documento del Remitente:</label>
        <input type="text" name="tipo_documento_remitente" id="tipo_documento_remitente" required><br><br>

        <label for="nombre_remitente">Nombre del Remitente:</label>
        <input type="text" name="nombre_remitente" id="nombre_remitente" required><br><br>

        <label for="telefono_remitente">Teléfono del Remitente:</label>
        <input type="text" name="telefono_remitente" id="telefono_remitente"><br><br>

        <label for="u_destinatario">Documento del Destinatario:</label>
        <input type="text" name="u_destinatario" id="u_destinatario" required><br><br>

        <label for="tipo_documento_destinatario">Tipo de Documento del Destinatario:</label>
        <input type="text" name="tipo_documento_destinatario" id="tipo_documento_destinatario" required><br><br>

        <label for="nombre_destinatario">Nombre del Destinatario:</label>
        <input type="text" name="nombre_destinatario" id="nombre_destinatario" required><br><br>

        <label for="telefono_destinatario">Teléfono del Destinatario:</label>
        <input type="text" name="telefono_destinatario" id="telefono_destinatario"><br><br>

        <label for="modalidad_envio">Modalidad de Envío:</label>
        <input type="text" name="modalidad_envio" id="modalidad_envio" required><br><br>

        <label for="modalidad_entrega">Modalidad de Entrega:</label>
        <input type="text" name="modalidad_entrega" id="modalidad_entrega" required><br><br>

        <label for="id_transporte">Transporte:</label>
        <select name="id_transporte" id="id_transporte" required>
            <?php foreach ($transportes as $transporte): ?>
                <option value="<?= $transporte['id_transporte'] ?>"><?= $transporte['tipo_transporte'] ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="clave">Código de Envío:</label>
        <input type="text" name="clave" id="clave" required><br><br>

        <label for="clave_verificacion">Código de Verificación:</label>
        <input type="text" name="clave_verificacion" id="clave_verificacion" required><br><br>

        <h2>Detalles del Paquete</h2>
        <div id="paquetes">
            <div class="paquete">
                <label for="tipo_contenido">Tipo de Contenido:</label>
                <input type="text" name="paquete[0][tipo_contenido]" required><br><br>

                <label for="peso">Peso (kg):</label>
                <input type="number" step="0.01" name="paquete[0][peso]" required><br><br>

                <label for="dimenciones">Dimensiones (LxAxH):</label>
                <input type="text" name="paquete[0][dimenciones]" required><br><br>
            </div>
        </div>

        <h2>Opciones de Pago</h2>
        <label for="metodo_pago">Método de Pago:</label>
        <select name="metodo_pago" id="metodo_pago" required>
            <option value="Visa">Visa</option>
            <option value="MasterCard">MasterCard</option>
            <option value="American Express">American Express</option>
            <!-- Agrega más métodos si es necesario -->
        </select><br><br>

        <label for="responsable_pago">Responsable del Pago:</label>
        <select name="responsable_pago" id="responsable_pago" required>
            <option value="remitente">Remitente</option>
            <option value="destinatario">Destinatario</option>
        </select><br><br>

        <label for="modalidad_pago">Modalidad de Pago:</label>
        <select name="modalidad_pago" id="modalidad_pago" required>
            <option value="efectivo">Efectivo</option>
            <option value="tarjeta">Tarjeta</option>
        </select><br><br>

        <input type="submit" value="Registrar Envío">
    </form>
</body>
</html>
