<?php
function cargarSeccion() {
    $seccion = $_GET['seccion'] ?? 'donativos'; // Sección por defecto

    switch ($seccion) {
        case 'iniciar_sesion':
            include('Vista/iniciar_sesion.php');
            break;
        case 'perfil':
            if (isset($_SESSION['id_usuario'])) {
                include('Vista/perfil.php');
            } else {
                header('Location: index.php?seccion=iniciar_sesion'); // Redirige si no está logueado
            }
            break;
        case 'donativos':
            include('Vista/donativos.php');
            break;
        case 'centros_reciclaje':
            include('Vista/centros_reciclaje.php');
            break;
        default:
            echo "<p>Sección no encontrada.</p>";
    }
}
?>
