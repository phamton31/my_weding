<?php
header('Content-Type: application/json');

// Ruta del archivo JSON
$jsonFile = 'invitados.json';

// Lee los datos del JSON
if (!file_exists($jsonFile)) {
    echo json_encode(["success" => false, "error" => "Archivo de invitados no encontrado."]);
    exit;
}

$data = json_decode(file_get_contents($jsonFile), true);
if (!is_array($data)) {
    $data = [];
}

// Lee datos desde $_POST (compatible con FormData enviado desde frontend)
$codigo = trim($_POST['codigo'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$asistencia = trim($_POST['asistencia'] ?? '');

if (!$codigo || !$nombre || !$asistencia) {
    echo json_encode(["success" => false, "error" => "Datos incompletos."]);
    exit;
}

// Busca al invitado en la lista por código y nombre
$found = false;
foreach ($data as &$invitado) {
    if ($invitado['codigo'] === $codigo && $invitado['nombre'] === $nombre) {
        if (!empty($invitado['confirmado'])) {
            echo json_encode(["success" => false, "error" => "Este invitado ya confirmó."]);
            exit;
        }

        // Marca como confirmado
        $invitado['asistencia'] = $asistencia;
        $invitado['confirmado'] = true;
        $found = true;
        break;
    }
}

if (!$found) {
    echo json_encode(["success" => false, "error" => "Invitado no encontrado."]);
    exit;
}

// Guarda los cambios
if (file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT))) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "No se pudo guardar el archivo."]);
}
?>
