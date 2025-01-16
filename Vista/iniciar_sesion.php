<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Styles/login.css">
    <title>Iniciar Sesión</title>
</head>
<body>
    <div class="container-login">
        <form action="Controlador/autenticacion.php" method="POST">
            <h1>Iniciar Sesión</h1>
            <label>Correo: <input type="email" name="usuario" required></label><br>
            <label>Contraseña: <input type="password" name="password" required></label><br>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <p>¿No tienes una cuenta? <a href="index.php?seccion=registrarse">Regístrate aquí</a></p>
    </div>
</body>
</html>