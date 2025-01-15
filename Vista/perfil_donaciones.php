<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Donaciones</title>
</head>
<body>
    <h1>Mis Donaciones</h1>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require_once "./Conexion/conn.php";

    $id_donante = $_SESSION['id_usuario'];

    // Consulta SQL para obtener los mensajes
    $sql = "SELECT m.id_solicitud, m.mensaje, m.fecha_mensaje, u.nombre 
            FROM mensaje m
            JOIN solicitud s ON m.id_solicitud = s.id_solicitud
            JOIN usuario u ON s.id_usuario = u.id_usuario
            WHERE m.id_donante = ? 
            AND s.finalizado = 0
            ORDER BY m.id_solicitud, m.fecha_mensaje ASC";
    
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("i", $id_donante);
    $stmt->execute();
    $result = $stmt->get_result();

    $chats = [];
    while ($row = $result->fetch_assoc()) {
        $chats[$row['id_solicitud']][] = $row;
    }

    // Mostrar los mensajes agrupados por id_solicitud
    foreach ($chats as $id_solicitud => $mensajes) {
        $nombre_usuario = $mensajes[0]['nombre'];
        echo "<h2>Conversación con: $nombre_usuario</h2>";
        foreach ($mensajes as $mensaje) {
            echo "<p><strong>{$mensaje['fecha_mensaje']}:</strong> {$mensaje['mensaje']}</p>";
        }
        // Formulario para agregar un nuevo mensaje
        echo "<form action='./Controlador/agregar_mensaje.php' method='POST'>
                <input type='hidden' name='id_solicitud' value='$id_solicitud'>
                <input type='hidden' name='id_donante' value='$id_donante'>
                <textarea name='mensaje' rows='3' cols='50' placeholder='Escribe tu mensaje aquí...'></textarea><br>
                <input type='submit' value='Enviar'>
              </form>";
    }

    $stmt->close();
    $conn->close();
    ?>
</body>
</html>