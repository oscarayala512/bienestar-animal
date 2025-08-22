<?php
include 'conexion.php';

$nombre = $_POST['nombreAnimal'] ?? '';
$descripcion = $_POST['descripcionAnimal'] ?? '';
$ubicacion = $_POST['ultimaUbicacion'] ?? '';
$foto = '';

if (isset($_FILES['fotoAnimal']) && $_FILES['fotoAnimal']['error'] === 0) {
    $directorio = '../uploads/extraviados/';
    if (!is_dir($directorio)) mkdir($directorio, 0777, true);

    $foto = basename($_FILES['fotoAnimal']['name']);
    $ruta = $directorio . $foto;

    if (!move_uploaded_file($_FILES['fotoAnimal']['tmp_name'], $ruta)) {
        echo "Error al subir la foto del animal extraviado.";
        exit;
    }
}

$sql = "INSERT INTO extraviados (nombre_animal, descripcion, ultima_ubicacion, foto) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nombre, $descripcion, $ubicacion, $foto);

if ($stmt->execute()) echo "Reporte de animal extraviado registrado exitosamente.";
else echo "Error al registrar el reporte: " . $stmt->error;

$stmt->close();
$conn->close();
?>


