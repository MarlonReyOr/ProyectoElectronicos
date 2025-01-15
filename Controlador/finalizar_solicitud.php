<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "../Conexion/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_solicitud = $_POST['id_solicitud'];

    // Consulta SQL para finalizar la solicitud
    $sql = "UPDATE solicitud SET finalizado = 1 WHERE id_solicitud = ?";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("i", $id_solicitud);
    if ($stmt->execute()) {
        echo "<script>alert('Solicitud finalizada correctamente.'); window.location.href='../index.php?seccion=perfil&accion=solicitudes';</script>";
    } else {
        echo "<script>alert('Error al finalizar la solicitud.'); window.location.href='../index.php?seccion=perfil&accion=solicitudes';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>