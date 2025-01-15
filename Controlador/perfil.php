<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "./Conexion/conn.php";
require_once "funciones_perfil.php";

function cargarSeccionPerfil($conn) {
    $accion = $_GET['accion'] ?? 'informacion'; // Acción por defecto

    switch ($accion) {
        case 'informacion':
            if (isset($_SESSION['id_usuario'])) {
                $id_usuario = $_SESSION['id_usuario'];
                $datos_usuario = obtenerDatosUsuario($conn, $id_usuario);
                extract($datos_usuario);
                include('./Vista/perfil.php');
            } else {
                header('Location: ./index.php?seccion=iniciar_sesion'); // Redirige si no está logueado
            }
            break;
        case 'actualizar':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id_usuario = $_SESSION['id_usuario'];
                $nombre = $_POST['nombre'];
                $primer_apellido = $_POST['primer_apellido'];
                $segundo_apellido = $_POST['segundo_apellido'];
                $contraseña = $_POST['contraseña'];
                if (actualizarPerfil($conn, $id_usuario, $nombre, $primer_apellido, $segundo_apellido, $contraseña)) {
                    echo "<script>alert('Perfil actualizado correctamente.'); window.location.href='./index.php?seccion=perfil';</script>";
                } else {
                    echo "<script>alert('Error al actualizar el perfil.'); window.location.href='./index.php?seccion=perfil';</script>";
                }
            } else {
                if (isset($_SESSION['id_usuario'])) {
                    $id_usuario = $_SESSION['id_usuario'];
                    $datos_usuario = obtenerDatosUsuario($conn, $id_usuario);
                    extract($datos_usuario);
                    include('./Vista/perfil.php');
                } else {
                    header('Location: ./index.php?seccion=iniciar_sesion'); // Redirige si no está logueado
                }
            }
            break;
        case 'donaciones':
            include('./Vista/perfil.php');
            break;
        case 'solicitudes':
            include('./Vista/perfil.php');
            break;
        case 'borrar_cuenta':
            if (isset($_SESSION['id_usuario'])) {
                $id_usuario = $_SESSION['id_usuario'];
                if (borrarCuenta($conn, $id_usuario)) {
                    session_destroy();
                    echo "<script>alert('Cuenta borrada correctamente.'); window.location.href='./index.php?seccion=iniciar_sesion';</script>";
                } else {
                    echo "<script>alert('Error al borrar la cuenta.'); window.location.href='./index.php?seccion=perfil';</script>";
                }
            }
            break;
        case 'logout':
            session_destroy();
            header('Location: ./index.php?seccion=iniciar_sesion');
            break;
        default:
            echo "<p>Acción no encontrada.</p>";
    }
}

cargarSeccionPerfil($conn);

?>