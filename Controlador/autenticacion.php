<?php
session_start();
require_once "../Conexion/conn.php";

$usuario = $_POST['usuario'];
$password = $_POST['password'];

// Consulta para verificar las credenciales
$sql = "SELECT id_usuario, contraseña FROM usuario WHERE correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($id_usuario, $hashed_password);
    $stmt->fetch();
    
    if (password_verify($password, $hashed_password)) {
        $_SESSION['id_usuario'] = $id_usuario;
        header('Location: ../index.php?seccion=perfil');
        exit();
    } else {
        echo "<script>alert('Contraseña incorrecta.'); window.location.href='../index.php?seccion=iniciar_sesion';</script>";
    }
} else {
    echo "<script>alert('El correo no está registrado. Revisa la entrada o regístrate por primera vez.'); window.location.href='../index.php?seccion=iniciar_sesion';</script>";
}

$stmt->close();
$conn->close();
?>