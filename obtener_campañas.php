<?php
header("Content-Type: application/json");
include 'conexion.php';

$sql = "SELECT colonia, fecha, horario, ubicacion, vacunas FROM campañas";
$resultado = $conn->query($sql);

$campañas = [];

while ($fila = $resultado->fetch_assoc()) {
    $campañas[] = [
        "colonia" => $fila["colonia"],
        "fecha" => date("d/m/Y", strtotime($fila["fecha"])),
        "horario" => $fila["horario"],
        "ubicacion" => $fila["ubicacion"],
        "vacunas" => $fila["vacunas"]
    ];
}

echo json_encode($campañas);
$conn->close();
?>
