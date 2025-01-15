<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "../Conexion/conn.php"; // Ajusta la ruta aquí

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_solicitud = $_POST['id_solicitud'];
    $id_donante = $_POST['id_donante'];
    $mensaje = $_POST['mensaje'];

    // Consulta SQL para insertar el nuevo mensaje
    $sql = "INSERT INTO mensaje (id_solicitud, id_donante, mensaje) VALUES (?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("iis", $id_solicitud, $id_donante, $mensaje);
    if ($stmt->execute()) {
        echo "<script>alert('Mensaje enviado correctamente.'); window.location.href='../index.php?seccion=perfil&accion=donaciones';</script>";
    } else {
        echo "<script>alert('Error al enviar el mensaje.'); window.location.href='../index.php?seccion=perfil&accion=donaciones';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>