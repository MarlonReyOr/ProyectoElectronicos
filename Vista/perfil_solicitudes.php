<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Solicitudes</title>
    <link rel="stylesheet" href="./Styles/perfil_solicitudes.css">
</head>
<body>
    <h1>Mis Solicitudes</h1>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    require_once "./Conexion/conn.php";

    $id_usuario = $_SESSION['id_usuario'];

    // Consulta SQL para obtener las solicitudes del usuario actual que no están finalizadas
    $sql_solicitudes = "SELECT s.id_solicitud, s.descripcion, t.nombre AS dispositivo
                        FROM solicitud s
                        JOIN tipo_dispositivo t ON s.id_tipo_dispositivo = t.id_tipo
                        WHERE s.id_usuario = ? AND s.finalizado = 0";
    
    $stmt_solicitudes = $conn->prepare($sql_solicitudes);
    if ($stmt_solicitudes === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt_solicitudes->bind_param("i", $id_usuario);
    $stmt_solicitudes->execute();
    $result_solicitudes = $stmt_solicitudes->get_result();

    $num_solicitudes = $result_solicitudes->num_rows;

    while ($solicitud = $result_solicitudes->fetch_assoc()) {
        $id_solicitud = $solicitud['id_solicitud'];
        $descripcion = $solicitud['descripcion'];
        $dispositivo = $solicitud['dispositivo'];

        echo "<h2>Solicitud: $dispositivo</h2>";
        echo "<p>Descripción: $descripcion</p>";

        // Botón para finalizar la solicitud
        echo "<form action='./Controlador/finalizar_solicitud.php' method='POST' enctype='multipart/form-data'>
                <input type='hidden' name='id_solicitud' value='$id_solicitud'>
                <input type='hidden' name='categoria' value='$dispositivo'>
                <input type='submit' value='Finalizar Solicitud' style='background-color: #cc0000; color: white;'>
              </form>";

        // Consulta SQL para obtener los mensajes agrupados por id_solicitud y id_donante
        $sql_mensajes = "SELECT m.id_donante, u.nombre AS donante, m.mensaje, m.fecha_mensaje
                         FROM mensaje m
                         JOIN usuario u ON m.id_donante = u.id_usuario
                         WHERE m.id_solicitud = ?
                         ORDER BY m.id_donante, m.fecha_mensaje ASC";
        
        $stmt_mensajes = $conn->prepare($sql_mensajes);
        if ($stmt_mensajes === false) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }
        $stmt_mensajes->bind_param("i", $id_solicitud);
        $stmt_mensajes->execute();
        $result_mensajes = $stmt_mensajes->get_result();

        $conversaciones = [];
        while ($mensaje = $result_mensajes->fetch_assoc()) {
            $conversaciones[$mensaje['id_donante']]['donante'] = $mensaje['donante'];
            $conversaciones[$mensaje['id_donante']]['mensajes'][] = $mensaje;
        }

        // Mostrar los mensajes agrupados por id_donante
        foreach ($conversaciones as $id_donante => $conversacion) {
            $nombre_donante = $conversacion['donante'];
            echo "<h3>Conversación con: $nombre_donante</h3>";
            foreach ($conversacion['mensajes'] as $mensaje) {
                echo "<p><strong>{$mensaje['fecha_mensaje']}:</strong> {$mensaje['mensaje']}</p>";
            }
            // Formulario para agregar un nuevo mensaje
            echo "<form action='./Controlador/agregar_msj.php' method='POST'>
                    <input type='hidden' name='id_solicitud' value='$id_solicitud'>
                    <input type='hidden' name='id_donante' value='$id_donante'>
                    <textarea name='mensaje' rows='3' cols='50' placeholder='Escribe tu mensaje aquí...'></textarea><br>
                    <input type='submit' value='Enviar'>
                  </form>";
        }

        $stmt_mensajes->close();
    }

    $stmt_solicitudes->close();

    // Formulario para realizar una nueva solicitud
    if ($num_solicitudes < 2) {
        echo "<h2>Realizar una nueva solicitud</h2>";

        // Consulta SQL para obtener los tipos de dispositivos
        $sql_tipos = "SELECT id_tipo, nombre FROM tipo_dispositivo";
        $result_tipos = $conn->query($sql_tipos);
        if ($result_tipos === false) {
            die("Error en la consulta de tipos de dispositivos: " . $conn->error);
        }

        echo "<form action='./Controlador/agregar_solicitud.php' method='POST' enctype='multipart/form-data'>
                <label for='tipo_dispositivo'>Tipo de dispositivo:</label>
                <select name='id_tipo_dispositivo' id='tipo_dispositivo'>";
        
        while ($tipo = $result_tipos->fetch_assoc()) {
            echo "<option value='{$tipo['id_tipo']}'>{$tipo['nombre']}</option>";
        }

        echo "</select><br>
                <label for='descripcion'>Descripción:</label><br>
                <textarea name='descripcion' id='descripcion' rows='4' cols='50'></textarea><br>
                <label for='imagen'>Subir imagen:</label><br>
                <input type='file' name='imagen' id='imagen'><br>
                <input type='submit' value='Enviar Solicitud'>
              </form>";
    } else {
        echo "<p>No puedes tener más de 2 solicitudes sin finalizar a la vez.</p>";
    }

    $conn->close();
    ?>
</body>
</html>