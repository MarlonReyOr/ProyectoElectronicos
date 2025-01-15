<?php
require_once "../Conexion/conn.php";

$nombre = $_POST['nombre'];
$primer_apellido = $_POST['primer_apellido'];
$segundo_apellido = $_POST['segundo_apellido'];
$correo = $_POST['correo'];
$contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT); // Encriptar la contraseña

// Verificar si el correo ya está registrado
$sql = "SELECT id_usuario FROM usuario WHERE correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "<script>alert('El correo ya está registrado.'); window.location.href='../index.php?seccion=registrarse';</script>";
} else {
    // Insertar nuevo usuario en la base de datos
    $sql = "INSERT INTO usuario (nombre, primer_apellido, segundo_apellido, correo, contraseña) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $primer_apellido, $segundo_apellido, $correo, $contraseña);

    if ($stmt->execute()) {
        // Iniciar sesión automáticamente
        session_start();
        $_SESSION['id_usuario'] = $stmt->insert_id;
        header('Location: ../index.php?seccion=perfil'); // Redirigir al perfil
        exit();
    } else {
        echo "Error en el registro: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>