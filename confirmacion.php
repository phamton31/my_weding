<?php
header('Content-Type: application/json');

// CONFIGURACIÓN DE CONEXIÓN
$host = "dpg-d3nd9e9gv73c739v22f0-a.oregon-postgres.render.com";
$port = "5432";
$dbname = "weding";
$user = "admin";
$password = "lykC8jNpg625HsWWDtxu6GFkNNb2OJ6V";

try {
    $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => "No se pudo conectar a la base de datos"]);
    exit;
}

// Recibir datos
$codigo = $_POST['codigo'] ?? null;
$nombre = $_POST['nombre'] ?? null;
$asistencia = $_POST['asistencia'] ?? null;

if (!$codigo || !$nombre || !$asistencia) {
    echo json_encode(["success" => false, "error" => "Faltan datos obligatorios"]);
    exit;
}

// Buscar invitado
$stmt = $pdo->prepare("SELECT * FROM invitados WHERE codigo = :codigo AND nombre = :nombre LIMIT 1");
$stmt->bindValue(':codigo', $codigo, PDO::PARAM_STR);
$stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
$stmt->execute();
$invitado = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$invitado) {
    echo json_encode(["success" => false, "error" => "Invitado no encontrado"]);
    exit;
}

if ($invitado['confirmado']) {
    echo json_encode(["success" => false, "error" => "Ya has respondido a la invitación"]);
    exit;
}

// Actualizar asistencia
$stmt = $pdo->prepare("UPDATE invitados SET confirmado = TRUE, asistencia = :asistencia WHERE id = :id");
$stmt->bindValue(':asistencia', $asistencia === 'si' ? 'Sí' : 'No', PDO::PARAM_STR);
$stmt->bindValue(':id', $invitado['id'], PDO::PARAM_INT);
$stmt->execute();

echo json_encode(["success" => true]);
