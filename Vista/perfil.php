<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: index.php?seccion=iniciar_sesion');
    exit();
}
?>

<h1>Bienvenido al Perfil</h1>
<p>¡Hola, tu sesión está activa!</p>
<a href="Controlador/logout.php">Cerrar Sesión</a>

<nav>
    <ul>
        <li><a href="?seccion=perfil&subseccion=solicitudes">Solicitudes</a></li>
        <li><a href="?seccion=perfil&subseccion=donaciones">Donaciones</a></li>
        <li><a href="?seccion=perfil&subseccion=informacion">Información del Perfil</a></li>
    </ul>
</nav>

<div>
    <?php
    $subseccion = $_GET['subseccion'] ?? 'solicitudes'; // Subsección por defecto

    switch ($subseccion) {
        case 'solicitudes':
            include('Vista/perfil_solicitudes.php');
            break;
        case 'donaciones':
            include('Vista/perfil_donaciones.php');
            break;
        case 'informacion':
            include('Vista/perfil_informacion.php');
            break;
        default:
            echo "<p>Subsección no encontrada.</p>";
    }
    ?>
</div>