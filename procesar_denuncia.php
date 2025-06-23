<?php
include 'conexion.php';

$nombre = $_POST['nombreDenunciante'];
$descripcion = $_POST['descripcionDenuncia'];
$ubicacion = $_POST['ubicacionDenuncia'];
$evidencia = '';

if (isset($_FILES['evidenciaDenuncia']) && $_FILES['evidenciaDenuncia']['error'] == 0) {
    $directorio = '../uploads/denuncias/';
    $evidencia = basename($_FILES['evidenciaDenuncia']['name']);
    $ruta = $directorio . $evidencia;
    move_uploaded_file($_FILES['evidenciaDenuncia']['tmp_name'], $ruta);
}

$sql = "INSERT INTO denuncias (nombre_denunciante, descripcion, ubicacion, evidencia) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nombre, $descripcion, $ubicacion, $evidencia);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Denuncia registrada exitosamente.";
} else {
    echo "Error al registrar la denuncia.";
}

$stmt->close();
$conn->close();
?>
