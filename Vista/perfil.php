<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
</head>
<body>
    <h1>Perfil de Usuario</h1>
    <nav>
        <ul>
            <li><a href="index.php?seccion=perfil&accion=informacion">Información del Perfil</a></li>
            <li><a href="index.php?seccion=perfil&accion=actualizar">Actualizar Perfil</a></li>
            <li><a href="index.php?seccion=perfil&accion=donaciones">Mis Donaciones</a></li>
            <li><a href="index.php?seccion=perfil&accion=solicitudes">Mis Solicitudes</a></li>
            <li><a href="index.php?seccion=perfil&accion=logout">Cerrar Sesión</a></li>
        </ul>
    </nav>

    <div>
        <?php
        if (isset($accion)) {
            switch ($accion) {
                case 'informacion':
                    include('perfil_informacion.php');
                    break;
                case 'actualizar':
                    include('perfil_actualizar.php');
                    break;
                case 'donaciones':
                    include('perfil_donaciones.php');
                    break;
                case 'solicitudes':
                    include('perfil_solicitudes.php');
                    break;
                default:
                    echo "<p>Acción no encontrada.</p>";
            }
        }
        ?>
    </div>
</body>
</html>