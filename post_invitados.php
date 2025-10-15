<?php
// Database connection using PDO
$host = "dpg-d3nd9e9gv73c739v22f0-a.oregon-postgres.render.com";
$port = "5432";
$dbname = "weding";
$user = "admin";
$password = "lykC8jNpg625HsWWDtxu6GFkNNb2OJ6V";
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

try {
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => 'No se pudo conectar a la base de datos']);
    exit;
}

// Function to generate code
function generarCodigo($longitud = 6) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $codigo = '';
    for ($i = 0; $i < $longitud; $i++) {
        $codigo .= $caracteres[random_int(0, strlen($caracteres) - 1)];
    }
    return $codigo;
}

// Get JSON body
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['invitados']) || !is_array($input['invitados'])) {
    echo json_encode(['success' => false, 'error' => 'Datos de invitados inválidos']);
    exit;
}

$invitados = $input['invitados'];
$lastCodigo = null;

$pdo->beginTransaction();

try {
    $sql = "INSERT INTO invitados2 (codigo, nombre, confirmado, asistencia) VALUES (:codigo, :nombre, :confirmado, :asistencia)";
    $stmt = $pdo->prepare($sql);

    foreach ($invitados as $invitado) {
        $codigo = generarCodigo();
        $nombre = isset($invitado['nombre']) ? $invitado['nombre'] : '';
        $confirmado = isset($invitado['confirmado']) ? filter_var($invitado['confirmado'], FILTER_VALIDATE_BOOLEAN) : false;
        $asistencia = isset($invitado['asistencia']) && $invitado['asistencia'] !== '' ? $invitado['asistencia'] : null;

        $stmt->bindValue(':codigo', $codigo, PDO::PARAM_STR);
        $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindValue(':confirmado', $confirmado, PDO::PARAM_BOOL);
        $stmt->bindValue(':asistencia', $asistencia, $asistencia === null ? PDO::PARAM_NULL : PDO::PARAM_STR);

        $stmt->execute();
        $lastCodigo = $codigo;
    }

    $pdo->commit();

    echo json_encode(['success' => true, 'codigo' => $lastCodigo]);
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'error' => 'Error al insertar invitados: ' . $e->getMessage()]);
}
