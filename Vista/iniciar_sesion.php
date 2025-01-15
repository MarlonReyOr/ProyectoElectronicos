<h1>Iniciar Sesión</h1>
<form action="Controlador/autenticacion.php" method="POST">
    <label>Correo: <input type="email" name="usuario" required></label><br>
    <label>Contraseña: <input type="password" name="password" required></label><br>
    <button type="submit">Iniciar Sesión</button>
</form>
<p>¿No tienes una cuenta? <a href="index.php?seccion=registrarse">Regístrate aquí</a></p>