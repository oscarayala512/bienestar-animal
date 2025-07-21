<?php
include 'conexion.php';

$nombre = $_POST['nombreDenunciante'] ?? '';
$descripcion = $_POST['descripcionDenuncia'] ?? '';
$ubicacion = $_POST['ubicacionDenuncia'] ?? '';
$evidencia = '';

if (isset($_FILES['evidenciaDenuncia']) && $_FILES['evidenciaDenuncia']['error'] === 0) {
    $directorio = '../uploads/denuncias/';

    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    $evidencia = basename($_FILES['evidenciaDenuncia']['name']);
    $ruta = $directorio . $evidencia;

    if (!move_uploaded_file($_FILES['evidenciaDenuncia']['tmp_name'], $ruta)) {
        echo "Error al subir el archivo de evidencia.";
        exit;
    }
}

$sql = "INSERT INTO denuncias (nombre_denunciante, descripcion, ubicacion, evidencia) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Error en la preparación de la consulta: " . $conn->error;
    exit;
}

$stmt->bind_param("ssss", $nombre, $descripcion, $ubicacion, $evidencia);

if ($stmt->execute()) {
    echo "Denuncia registrada exitosamente.";
} else {
    echo "Error al registrar la denuncia: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
