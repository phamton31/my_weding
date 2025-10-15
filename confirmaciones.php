<?php
header('Content-Type: application/json');

// Configuración de la conexión (reemplaza con los datos de tu base en Render)
$host = "dpg-d3nd9e9gv73c739v22f0-a.oregon-postgres.render.com";
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
