<?php
$host = 'localhost';
$dbname = 'Red_Electronicos';
$username = 'root';
$password = '';

// Crear conexión usando MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
