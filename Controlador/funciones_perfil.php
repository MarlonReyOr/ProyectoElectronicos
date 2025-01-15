<?php
function obtenerDatosUsuario($conn, $id_usuario) {
    $sql = "SELECT nombre, primer_apellido, segundo_apellido, correo FROM usuario WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $nombre = $primer_apellido = $segundo_apellido = $correo = null;
    $stmt->bind_result($nombre, $primer_apellido, $segundo_apellido, $correo);
    $stmt->fetch();
    $stmt->close();
    return compact('nombre', 'primer_apellido', 'segundo_apellido', 'correo');
}

function actualizarPerfil($conn, $id_usuario, $nombre, $primer_apellido, $segundo_apellido, $contraseña) {
    if (empty($contraseña)) {
        $sql = "UPDATE usuario SET nombre = ?, primer_apellido = ?, segundo_apellido = ? WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $nombre, $primer_apellido, $segundo_apellido, $id_usuario);
    } else {
        $contraseña_hashed = password_hash($contraseña, PASSWORD_DEFAULT);
        $sql = "UPDATE usuario SET nombre = ?, primer_apellido = ?, segundo_apellido = ?, contraseña = ? WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nombre, $primer_apellido, $segundo_apellido, $contraseña_hashed, $id_usuario);
    }
    return $stmt->execute();
}

function borrarCuenta($conn, $id_usuario) {
    $sql = "DELETE FROM usuario WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    return $stmt->execute();
}
?>