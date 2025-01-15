<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Donaciones Activas</title>
    <style>
        /* Estilos para el modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Donaciones Activas</h1>
    <form method="POST" action="index.php?seccion=donativos" id="tipoDispositivoForm">
        <label for="tipo_dispositivo">Selecciona un tipo de dispositivo:</label>
        <select name="tipo_dispositivo" id="tipo_dispositivo" required onchange="document.getElementById('tipoDispositivoForm').submit();">
            <option value="todas">Todas</option>
            <?php foreach ($tipos_dispositivos as $tipo): ?>
                <option value="<?php echo $tipo['id_tipo']; ?>" <?php if ($tipo_dispositivo == $tipo['id_tipo']) echo 'selected'; ?>>
                    <?php echo $tipo['nombre']; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if (!empty($donaciones)): ?>
        <h2>Donaciones Activas</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donaciones as $donacion): ?>
                    <tr>
                        <td>
                            <?php if ($donacion['ruta_imagen']): ?>
                                <img src="imagenes/<?php echo htmlspecialchars($donacion['ruta_imagen']); ?>" alt="Imagen de la donación" width="100">
                            <?php else: ?>
                                No hay imagen
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($donacion['nombre'] . ' ' . $donacion['primer_apellido']); ?></td>
                        <td><?php echo htmlspecialchars($donacion['descripcion']); ?></td>
                        <td>
                            <button onclick="mostrarModalContactar(<?php echo $donacion['id_solicitud']; ?>, <?php echo $donacion['id_usuario']; ?>)">Contactar</button>
                            <button onclick="mostrarModalReportar(<?php echo $donacion['id_solicitud']; ?>)">Reportar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No se encontraron donaciones activas.</p>
    <?php endif; ?>

    <!-- Modal para reportar -->
    <div id="modalReporte" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal('modalReporte')">&times;</span>
            <h2>Reportar Solicitud</h2>
            <form id="formReporte" method="POST" action="index.php?seccion=reportar">
                <input type="hidden" name="id_solicitud" id="id_solicitud_reporte">
                <label for="motivo">Motivo:</label>
                <textarea name="motivo" id="motivo" required></textarea><br>
                <button type="submit">Reportar</button>
                <button type="button" onclick="cerrarModal('modalReporte')">Cancelar</button>
            </form>
        </div>
    </div>

    <!-- Modal para contactar -->
    <div id="modalContactar" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal('modalContactar')">&times;</span>
            <h2>Contactar Donante</h2>
            <form id="formContactar" method="POST" action="index.php?seccion=contactar">
                <input type="hidden" name="id_solicitud" id="id_solicitud_contactar">
                <input type="hidden" name="id_usuario_solicitante" id="id_usuario_solicitante">
                <label for="mensaje">Mensaje:</label>
                <textarea name="mensaje" id="mensaje" required></textarea><br>
                <button type="submit">Enviar</button>
                <button type="button" onclick="cerrarModal('modalContactar')">Cancelar</button>
            </form>
        </div>
    </div>

    <script>
    function mostrarModalReportar(id_solicitud) {
        document.getElementById('id_solicitud_reporte').value = id_solicitud;
        document.getElementById('modalReporte').style.display = "block";
    }

    function mostrarModalContactar(id_solicitud, id_usuario_solicitante) {
        <?php if (!isset($_SESSION['id_usuario'])): ?>
            alert('Debes iniciar sesión para contactar al donante.');
            window.location.href = 'index.php?seccion=iniciar_sesion';
            return;
        <?php endif; ?>

        var id_donante = <?php echo $_SESSION['id_usuario'] ?? 'null'; ?>;
        if (id_donante === id_usuario_solicitante) {
            alert('No puedes contactar tu propia solicitud.');
            return;
        }

        document.getElementById('id_solicitud_contactar').value = id_solicitud;
        document.getElementById('id_usuario_solicitante').value = id_usuario_solicitante;
        document.getElementById('modalContactar').style.display = "block";
    }

    function cerrarModal(modalId) {
        document.getElementById(modalId).style.display = "none";
    }

    // Cerrar el modal si se hace clic fuera de él
    window.onclick = function(event) {
        if (event.target == document.getElementById('modalReporte')) {
            cerrarModal('modalReporte');
        }
        if (event.target == document.getElementById('modalContactar')) {
            cerrarModal('modalContactar');
        }
    }
    </script>
</body>
</html>