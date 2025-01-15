<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "../Conexion/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_usuario = $_SESSION['id_usuario'];
    $id_tipo_dispositivo = $_POST['id_tipo_dispositivo'];
    $descripcion = $_POST['descripcion'];
    $ruta_imagen = null;

    // Manejo de la subida de la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $nombre_imagen = basename($_FILES['imagen']['name']);
        $ruta_imagen = "../imagenes/" . $nombre_imagen;
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen)) {
            die("Error al subir la imagen.");
        }
    }

    // Consulta SQL para agregar una nueva solicitud
    $sql = "INSERT INTO solicitud (id_usuario, id_tipo_dispositivo, descripcion, ruta_imagen) VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("iiss", $id_usuario, $id_tipo_dispositivo, $descripcion, $ruta_imagen);
    if ($stmt->execute()) {
        echo "<script>alert('Solicitud enviada correctamente.'); window.location.href='../index.php?seccion=perfil&accion=solicitudes';</script>";
    } else {
        echo "<script>alert('Error al enviar la solicitud.'); window.location.href='../index.php?seccion=perfil&accion=solicitudes';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>