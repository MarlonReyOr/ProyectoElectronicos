<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Perfil</title>
    <link rel="stylesheet" href="./Styles/perfil_actualizar.css">
</head>
<body>
    <h1>Actualizar Perfil</h1>
    <form method="POST" action="index.php?seccion=perfil&accion=actualizar">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required><br>

        <label for="primer_apellido">Primer Apellido:</label>
        <input type="text" name="primer_apellido" id="primer_apellido" value="<?php echo htmlspecialchars($primer_apellido); ?>" required><br>

        <label for="segundo_apellido">Segundo Apellido:</label>
        <input type="text" name="segundo_apellido" id="segundo_apellido" value="<?php echo htmlspecialchars($segundo_apellido); ?>" required><br>

        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" value="<?php echo htmlspecialchars($correo); ?>" disabled><br>

        <label for="contraseña">Nueva Contraseña (dejar en blanco si no desea cambiarla):</label>
        <input type="password" name="contraseña" id="contraseña"><br>

        <button type="submit">Actualizar</button>
    </form>
</body>
</html>