<?php
$carpetas = [
    'uploads',
    'uploads/adoptables',
    'uploads/extraviados',
    'uploads/denuncias'
];

foreach ($carpetas as $carpeta) {
    if (!is_dir($carpeta)) {
        if (mkdir($carpeta, 0777, true)) {
            echo "Carpeta creada: $carpeta <br>";
        } else {
            echo "Error al crear la carpeta: $carpeta <br>";
        }
    } else {
        echo "La carpeta ya existe: $carpeta <br>";
    }
}
?>