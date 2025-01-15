<?php
session_start();
session_destroy();
header('Location: ../index.php?seccion=iniciar_sesion');
?>
