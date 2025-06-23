<?php
include 'conexion.php';

$nombre = $_POST['nombre'];
$especie = $_POST['especie'];
$raza = $_POST['raza'];
$edad = $_POST['edad'];
$descripcion = $_POST['descripcion'];
$adoptado = $_POST['adoptado'] ?? 'No';
$vacunas = isset($_POST['vacunas']) ? implode(", ", $_POST['vacunas']) : '';
$nombre_contacto = $_POST['nombre_contacto'];
$telefono_contacto = $_POST['telefono_contacto'];
$es_de_ixtapaluca = isset($_POST['es_de_ixtapaluca']) ? 'Sí' : 'No';

$foto = '';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $directorio = '../uploads/adoptables/';
    $foto = basename($_FILES['foto']['name']);
    move_uploaded_file($_FILES['foto']['tmp_name'], $directorio . $foto);
}

$sql = "INSERT INTO adoptables (nombre, especie, raza, edad, descripcion, foto, adoptado, vacunas, nombre_contacto, telefono_contacto, es_de_ixtapaluca)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssssss", $nombre, $especie, $raza, $edad, $descripcion, $foto, $adoptado, $vacunas, $nombre_contacto, $telefono_contacto, $es_de_ixtapaluca);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Registro exitoso";
} else {
    echo "Error al guardar";
}

$stmt->close();
$conn->close();
?>
