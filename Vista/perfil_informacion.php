<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Información del Perfil</title>
    <link rel="stylesheet" href="./Styles/perfil_informacion.css">
</head>
<body>
    <h1>Información del Perfil</h1>
    <p><strong>Nombre:</strong> <?php echo htmlspecialchars($nombre); ?></p>
    <p><strong>Primer Apellido:</strong> <?php echo htmlspecialchars($primer_apellido); ?></p>
    <p><strong>Segundo Apellido:</strong> <?php echo htmlspecialchars($segundo_apellido); ?></p>
    <p><strong>Correo:</strong> <?php echo htmlspecialchars($correo); ?></p>

    <form method="POST" action="index.php?seccion=perfil&accion=borrar_cuenta" onsubmit="return confirm('¿Estás seguro de que deseas borrar tu cuenta? Esta acción no se puede deshacer.');">
        <button type="submit">Borrar Cuenta</button>
    </form>
</body>
</html>