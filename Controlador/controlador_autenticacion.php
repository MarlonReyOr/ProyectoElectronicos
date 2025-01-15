<?php
session_start();
require_once "../Conexion/conn.php";

// Validar credenciales de ejemplo (puedes mejorar esto)
if ($_POST['usuario'] === 'admin' && $_POST['password'] === '1234') {
    $_SESSION['id_usuario'] = 1;
    header('Location: ../index.php?seccion=perfil');
} else {
    echo "Credenciales incorrectas";
}
?>
