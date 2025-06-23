<?php
include 'conexion.php';

$nombre = $_POST['nombreAnimal'];
$descripcion = $_POST['descripcionAnimal'];
$ubicacion = $_POST['ultimaUbicacion'];
$foto = '';

if (isset($_FILES['fotoAnimal']) && $_FILES['fotoAnimal']['error'] == 0) {
    $directorio = '../uploads/extraviados/';
    $foto = basename($_FILES['fotoAnimal']['name']);
    $ruta = $directorio . $foto;
    move_uploaded_file($_FILES['fotoAnimal']['tmp_name'], $ruta);
}

$sql = "INSERT INTO extraviados (nombre_animal, descripcion, ultima_ubicacion, foto) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nombre, $descripcion, $ubicacion, $foto);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Reporte de animal extraviado registrado exitosamente.";
} else {
    echo "Error al registrar el reporte.";
}

$stmt->close();
$conn->close();
?>
