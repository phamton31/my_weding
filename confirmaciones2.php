<!-- <?php -->
// header('Content-Type: application/json');

// $jsonFile = 'invitados.json';

// if (!file_exists($jsonFile)) {
    // echo json_encode(["success" => false, "error" => "Archivo de invitados no encontrado."]);
    // exit;
// }

// $data = json_decode(file_get_contents($jsonFile), true);
// if (!is_array($data)) {
    // $data = [];
// }

// $codigo = trim($_POST['codigo'] ?? '');
// $nombre = trim($_POST['nombre'] ?? '');
// $asistencia = trim($_POST['asistencia'] ?? '');

// if (!$codigo || !$nombre || !$asistencia) {
    // echo json_encode(["success" => false, "error" => "Datos incompletos."]);
    // exit;
// }

// $found = false;
// foreach ($data as &$invitado) {
    // if ($invitado['codigo'] === $codigo && $invitado['nombre'] === $nombre) {
        // if (!empty($invitado['confirmado'])) {
            // echo json_encode(["success" => false, "error" => "Este invitado ya confirmó."]);
            // exit;
        // }

        // $invitado['asistencia'] = $asistencia;
        // $invitado['confirmado'] = true;
        // $found = true;
        // break;
    // }
// }

// if (!$found) {
    // echo json_encode(["success" => false, "error" => "Invitado no encontrado."]);
    // exit;
// }

// if (file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT))) {
    // echo json_encode(["success" => true]);
// } else {
    // echo json_encode(["success" => false, "error" => "No se pudo guardar el archivo."]);
// }
// >

<?php
header('Content-Type: application/json');

// Configuración de la conexión (reemplaza con los datos de tu base en Render)
$host = "dpg-d3nd9e9gv73c739v22f0-a";
$port = "5432";
$dbname = "weding";
$user = "admin";
$password = "lykC8jNpg625HsWWDtxu6GFkNNb2OJ6V";

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";
$conn = pg_connect($conn_string);

if (!$conn) {
    echo json_encode(["success" => false, "error" => "No se pudo conectar a la base de datos."]);
    exit;
}

// Lee datos desde POST
$codigo = trim($_POST['codigo'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$asistencia = trim($_POST['asistencia'] ?? '');

if (!$codigo || !$nombre || !$asistencia) {
    echo json_encode(["success" => false, "error" => "Datos incompletos."]);
    exit;
}

// Verificar si el invitado ya confirmó
$query = "SELECT confirmado FROM invitados WHERE codigo = $1 AND nombre = $2";
$result = pg_query_params($conn, $query, [$codigo, $nombre]);

if (!$result || pg_num_rows($result) === 0) {
    echo json_encode(["success" => false, "error" => "Invitado no encontrado."]);
    exit;
}

$row = pg_fetch_assoc($result);
if ($row['confirmado'] === 't') {
    echo json_encode(["success" => false, "error" => "Este invitado ya confirmó."]);
    exit;
}

// Actualizar la asistencia
$updateQuery = "UPDATE invitados SET asistencia = $1, confirmado = TRUE WHERE codigo = $2 AND nombre = $3";
$updateResult = pg_query_params($conn, $updateQuery, [$asistencia, $codigo, $nombre]);

if ($updateResult) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => "No se pudo actualizar la confirmación."]);
}
?>
