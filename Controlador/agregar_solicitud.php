<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "../Conexion/conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario = $_SESSION['id_usuario'];
    $id_tipo_dispositivo = $_POST['id_tipo_dispositivo'];
    $descripcion = $_POST['descripcion'];

    // Consulta para obtener el nombre de la categoría
    $sql_categoria = "SELECT nombre FROM tipo_dispositivo WHERE id_tipo = ?";
    $stmt_categoria = $conn->prepare($sql_categoria);
    if ($stmt_categoria === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt_categoria->bind_param("i", $id_tipo_dispositivo);
    $stmt_categoria->execute();
    $result_categoria = $stmt_categoria->get_result();
    $categoria = $result_categoria->fetch_assoc()['nombre'];
    $stmt_categoria->close();

    // Verificar si se subió una imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
        $imagen = $_FILES['imagen']['name'];
        $ruta_imagen = "../imagenes/" . basename($imagen);
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen);
    } else {
        // Si no se subió una imagen, usar la ruta predeterminada
        $ruta_imagen = "../imagenes/" . $categoria . ".png";
    }

    // Insertar la nueva solicitud en la base de datos
    $sql = "INSERT INTO solicitud (id_usuario, id_tipo_dispositivo, descripcion, ruta_imagen, finalizado) VALUES (?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("iiss", $id_usuario, $id_tipo_dispositivo, $descripcion, $ruta_imagen);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Solicitud creada con éxito.'); window.location.href='../index.php?seccion=perfil&accion=solicitudes';</script>";
    } else {
        echo "<script>alert('Error al crear la solicitud.'); window.location.href='../index.php?seccion=perfil&accion=solicitudes';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>