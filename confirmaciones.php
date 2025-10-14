<?php
header('Content-Type: application/json');
$jsonFile = 'invitados.json';

if (!file_exists($jsonFile)) {
    echo json_encode(["success" => false, "error" => "Archivo de invitados no encontrado."]);
    exit;
}

$data = json_decode(file_get_contents($jsonFile), true);
$input = json_decode(file_get_contents('php://input'), true);

$codigo = trim($input['codigo'] ?? '');
$nombre = trim($input['nombre'] ?? '');
$asistencia = trim($input['asistencia'] ?? '');

if (!$codigo || !$nombre || !$asistencia) {
    echo json_encode(["success" => false, "error" => "Datos incompletos."]);
    exit;
}

$found = false;
foreach ($data as &$invitado) {
    if ($invitado['codigo'] === $codigo) {
        if (!empty($invitado['confirmado'])) {
            echo json_encode(["success" => false, "error" => "Este código ya confirmó asistencia."]);
            exit;
        }

        $invitado['asistencia'] = $asistencia;
        $invitado['confirmado'] = true;
        $found = true;
        break;
    }
}

if (!$found) {
    echo json_encode(["success" => false, "error" => "Código no encontrado."]);
    exit;
}

if (file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT))) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "No se pudo guardar la confirmación."]);
}
?>
