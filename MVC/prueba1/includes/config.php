<?php
// config.php

$host = 'localhost'; // Cambia esto si tu base de datos está en otro servidor
$dbname = 'PROJECTDB';
$username = 'root'; // Cambia esto según tu configuración
$password = ''; // Cambia esto según tu configuración

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Establecer el modo de error de PDO a excepción
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Conexión fallida: ' . $e->getMessage();
}
?>