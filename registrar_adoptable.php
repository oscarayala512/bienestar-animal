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
    if (!is_dir($directorio)) mkdir($directorio, 0777, true);

    $extension = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $permitidas = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($extension, $permitidas)) {
        echo "Formato de imagen no permitido. Solo JPG, JPEG, PNG, GIF.";
        exit;
    }

    if ($_FILES['foto']['size'] > 5 * 1024 * 1024) { // 5 MB
        echo "La imagen es demasiado grande. Máximo 5 MB.";
        exit;
    }

    // Crear nombre único
    $foto = time() . '_' . bin2hex(random_bytes(5)) . '.' . $extension;
    $rutaDestino = $directorio . $foto;

    if (!move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
        echo "Error al subir la foto.";
        exit;
    }
}

$sql = "INSERT INTO adoptables (nombre, especie, raza, edad, descripcion, foto, adoptado, vacunas, nombre_contacto, telefono_contacto, es_de_ixtapaluca)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssss", $nombre, $especie, $raza, $edad, $descripcion, $foto, $adoptado, $vacunas, $nombre_contacto, $telefono_contacto, $es_de_ixtapaluca);

if ($stmt->execute()) echo "Registro exitoso";
else echo "Error al guardar: " . $stmt->error;

$stmt->close();
$conn->close();
?>
