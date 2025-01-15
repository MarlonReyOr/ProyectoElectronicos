<?php
$estados = [
    "Aguascalientes", "Baja California", "Baja California Sur", "Campeche", "Chiapas", "Chihuahua", 
    "Ciudad de México", "Coahuila de Zaragoza", "Colima", "Durango", "Estado de México", "Guanajuato", 
    "Guerrero", "Hidalgo", "Jalisco", "Michoacán de Ocampo", "Morelos", "Nayarit", "Nuevo León", 
    "Oaxaca", "Puebla", "Querétaro", "Quintana Roo", "San Luis Potosí", "Sinaloa", "Sonora", 
    "Tabasco", "Tamaulipas", "Tlaxcala", "Veracruz de Ignacio de la Llave", "Yucatán", "Zacatecas"
];

$centros = [];
if (isset($_POST['estado'])) {
    $estadoSeleccionado = $_POST['estado'];
    if (($handle = fopen("./Centros de reciclaje.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($data[5] == $estadoSeleccionado) {
                $centros[] = $data;
            }
        }
        fclose($handle);
    }
}
?>

<h1>Centros de Reciclaje</h1>
<form method="POST" action="" id="estadoForm">
    <label for="estado">Selecciona un estado:</label>
    <select name="estado" id="estado" required onchange="document.getElementById('estadoForm').submit();">
        <option value="">--Selecciona un estado--</option>
        <?php foreach ($estados as $estado): ?>
            <option value="<?php echo $estado; ?>" <?php if (isset($estadoSeleccionado) && $estadoSeleccionado == $estado) echo 'selected'; ?>><?php echo $estado; ?></option>
        <?php endforeach; ?>
    </select>
</form>

<?php if (!empty($centros)): ?>
    <h2>Centros de Reciclaje en <?php echo htmlspecialchars($estadoSeleccionado); ?></h2>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Contacto</th>
                <th>Horario</th>
                <th>Google Maps Ubicación</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($centros as $centro): ?>
                <tr>
                    <td><?php echo htmlspecialchars($centro[0]); ?></td>
                    <td><?php echo htmlspecialchars($centro[1]); ?></td>
                    <td><?php echo htmlspecialchars($centro[2]); ?></td>
                    <td><?php echo htmlspecialchars($centro[3]); ?></td>
                    <td><a href="<?php echo htmlspecialchars($centro[4]); ?>" target="_blank">Ver en Google Maps</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif (isset($estadoSeleccionado)): ?>
    <p>No se encontraron centros de reciclaje en <?php echo htmlspecialchars($estadoSeleccionado); ?>.</p>
<?php endif; ?>