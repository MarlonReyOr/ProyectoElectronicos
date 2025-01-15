<h1>Registrarse</h1>
<form action="Controlador/registro.php" method="POST">
    <label>Nombre: <input type="text" name="nombre" required></label><br>
    <label>Primer Apellido: <input type="text" name="primer_apellido" required></label><br>
    <label>Segundo Apellido: <input type="text" name="segundo_apellido" required></label><br>
    <label>Correo: <input type="email" name="correo" required></label><br>
    <label>Contraseña: <input type="password" name="contraseña" required></label><br>
    <button type="submit">Registrarse</button>
</form>