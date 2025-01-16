<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Styles/registrarse.css">
    <title>Registrarse</title>
</head>
<body>
    <div class="container">
        <form action="Controlador/registro.php" method="POST">
            <h1>Registrarse</h1>
            <label>Nombre: <input type="text" name="nombre" required></label><br>
            <label>Primer Apellido: <input type="text" name="primer_apellido" required></label><br>
            <label>Segundo Apellido: <input type="text" name="segundo_apellido" required></label><br>
            <label>Correo: <input type="email" name="correo" required></label><br>
            <label>Contraseña: <input type="password" name="contraseña" required></label><br>
            <button type="submit">Registrarse</button>
        </form>
    </div>
</body>
</html>