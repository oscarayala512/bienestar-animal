<?php
header("Content-Type: application/json");
include 'conexion.php';

$sql = "SELECT nombre, especie, raza, edad, descripcion, foto FROM adoptables";
$resultado = $conn->query($sql);

$adoptables = [];
//info de animales
while ($fila = $resultado->fetch_assoc()) {
    $adoptables[] = [
        "nombre" => $fila["nombre"],
        "especie" => $fila["especie"],
        "raza" => $fila["raza"],
        "edad" => $fila["edad"],
        "descripcion" => $fila["descripcion"],
        "foto" => $fila["foto"]
    ];
}

echo json_encode($adoptables);
$conn->close();
?>
