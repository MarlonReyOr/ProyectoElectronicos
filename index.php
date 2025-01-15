<?php
session_start(); // Iniciar sesión para gestionar al usuario

require_once "Conexion/conn.php";
require_once "Controlador/controlador_principal.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Styles/principal.css">
    <title>Página Principal</title>
</head>
<body>

<div class="menu">
    <?php if (isset($_SESSION['id_usuario'])): ?>
        <!-- Si hay un usuario logueado -->
        <a href="?seccion=perfil" class="<?= (isset($_GET['seccion']) && $_GET['seccion'] == 'perfil') ? 'active' : '' ?>">Perfil</a>
    <?php else: ?>
        <!-- Si no hay usuario logueado -->
        <a href="?seccion=iniciar_sesion" class="<?= (isset($_GET['seccion']) && $_GET['seccion'] == 'iniciar_sesion') ? 'active' : '' ?>">Iniciar Sesión</a>
    <?php endif; ?>
    
    <a href="?seccion=donativos" class="<?= (isset($_GET['seccion']) && $_GET['seccion'] == 'donativos') ? 'active' : '' ?>">Donativos</a>
    <a href="?seccion=centros_reciclaje" class="<?= (isset($_GET['seccion']) && $_GET['seccion'] == 'centros_reciclaje') ? 'active' : '' ?>">Centros de reciclaje</a>
</div>

<div class="content">
    <?php
        cargarSeccion(); // Función del controlador que maneja las secciones
    ?>
</div>

</body>
</html>
