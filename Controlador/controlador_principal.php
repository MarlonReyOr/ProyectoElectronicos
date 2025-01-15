<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "Conexion/conn.php";
require_once "funciones_perfil.php";

function obtenerTiposDispositivos($conn) {
    $sql = "SELECT id_tipo, nombre FROM tipo_dispositivo";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function obtenerDonacionesActivas($conn, $tipo_dispositivo) {
    $sql = "SELECT s.id_solicitud, s.descripcion, s.ruta_imagen, u.nombre, u.primer_apellido, u.id_usuario 
            FROM solicitud s 
            JOIN usuario u ON s.id_usuario = u.id_usuario 
            WHERE s.finalizado = 0";
    if ($tipo_dispositivo !== 'todas') {
        $sql .= " AND s.id_tipo_dispositivo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $tipo_dispositivo);
    } else {
        $stmt = $conn->prepare($sql);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function guardarReporte($conn, $id_solicitud, $motivo) {
    $sql = "INSERT INTO reporte (id_usuario_reportado, motivo) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id_solicitud, $motivo);
    return $stmt->execute();
}

function guardarMensaje($conn, $id_solicitud, $id_donante, $mensaje) {
    // Verificar si ya existe un mensaje con id_solicitud e id_donante
    $sql = "SELECT id_mensaje FROM mensaje WHERE id_solicitud = ? AND id_donante = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_solicitud, $id_donante);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        return false; // Ya existe un mensaje
    }

    // Insertar nuevo mensaje
    $sql = "INSERT INTO mensaje (id_solicitud, id_donante, mensaje) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $id_solicitud, $id_donante, $mensaje);
    return $stmt->execute();
}

function cargarSeccion() {
    global $conn;
    $seccion = $_GET['seccion'] ?? 'donativos'; // Sección por defecto

    switch ($seccion) {
        case 'iniciar_sesion':
            include('Vista/iniciar_sesion.php');
            break;
        case 'perfil':
            include('Controlador/perfil.php');
            break;
        case 'registrarse':
            include('Vista/registrarse.php');
            break;
        case 'donativos':
            $tipo_dispositivo = $_POST['tipo_dispositivo'] ?? 'todas';
            $tipos_dispositivos = obtenerTiposDispositivos($conn);
            $donaciones = obtenerDonacionesActivas($conn, $tipo_dispositivo);
            include('Vista/donativos.php');
            break;
        case 'reportar':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id_solicitud = $_POST['id_solicitud'];
                $motivo = $_POST['motivo'];
                if (guardarReporte($conn, $id_solicitud, $motivo)) {
                    echo "<script>alert('Reporte enviado correctamente.'); window.location.href='index.php?seccion=donativos';</script>";
                } else {
                    echo "<script>alert('Error al enviar el reporte.'); window.location.href='index.php?seccion=donativos';</script>";
                }
            }
            break;
        case 'contactar':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id_solicitud = $_POST['id_solicitud'];
                $id_donante = $_SESSION['id_usuario'];
                $mensaje = $_POST['mensaje'];
                if (guardarMensaje($conn, $id_solicitud, $id_donante, $mensaje)) {
                    echo "<script>alert('Mensaje enviado correctamente.'); window.location.href='index.php?seccion=donativos';</script>";
                } else {
                    echo "<script>alert('Ya se inició una conversación.'); window.location.href='index.php?seccion=perfil&accion=donaciones';</script>";
                }
            }
            break;
        case 'centros_reciclaje':
            include('Vista/centros_reciclaje.php');
            break;
        default:
            echo "<p>Sección no encontrada.</p>";
    }
}
?>