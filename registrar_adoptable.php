<?php
include 'conexion.php';

$nombre = $_POST['nombre'] ?? '';
$especie = $_POST['especie'] ?? '';
$raza = $_POST['raza'] ?? '';
$edad = $_POST['edad'] ?? '';
$descripcion = $_POST['descripcion'] ?? '';
$adoptado = $_POST['adoptado'] ?? 'No';
$vacunas = isset($_POST['vacunas']) ? implode(", ", $_POST['vacunas']) : '';
$nombre_contacto = $_POST['nombre_contacto'] ?? '';
$telefono_contacto = $_POST['telefono_contacto'] ?? '';
$es_de_ixtapaluca = isset($_POST['es_de_ixtapaluca']) ? 'Sí' : 'No';

$foto = '';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
    $directorio = '../uploads/adoptables/';
    
    // Crear carpeta si no existe
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }

    $foto = basename($_FILES['foto']['name']);
    $rutaDestino = $directorio . $foto;

    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
        echo "Error al subir la foto";
        exit;
    }
}

$sql = "INSERT INTO adoptables (nombre, especie, raza, edad, descripcion, foto, adoptado, vacunas, nombre_contacto, telefono_contacto, es_de_ixtapaluca)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Error en la preparación de la consulta: " . $conn->error;
    exit;
}

$stmt->bind_param("sssssssssss", $nombre, $especie, $raza, $edad, $descripcion, $foto, $adoptado, $vacunas, $nombre_contacto, $telefono_contacto, $es_de_ixtapaluca);

if ($stmt->execute()) {
    echo "Registro exitoso";
} else {
    echo "Error al guardar: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
