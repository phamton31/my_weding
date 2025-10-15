<?php
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
    die("No se pudo conectar a la base de datos: " . $e->getMessage());
}

// Obtener código desde URL
$codigo = $_GET['codigo'] ?? null;
if (!$codigo) {
    die("Código de invitación no válido.");
}

// Buscar invitado
$stmt = $pdo->prepare("SELECT * FROM invitados WHERE codigo = :codigo LIMIT 1");
$stmt->bindValue(':codigo', $codigo, PDO::PARAM_STR);
$stmt->execute();
$invitado = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$invitado) {
    die("Invitado no encontrado.");
}

// Manejar respuesta POST
$mensaje = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($invitado['confirmado']) {
        $mensaje = "Ya has respondido a la invitación. No se puede cambiar la respuesta.";
    } else {
        $asistencia = $_POST['asistencia'] ?? '';
        if ($asistencia === 'si' || $asistencia === 'no') {
            $stmt = $pdo->prepare("UPDATE invitados SET confirmado = TRUE, asistencia = :asistencia WHERE id = :id");
            $stmt->bindValue(':asistencia', $asistencia === 'si' ? 'Sí' : 'No', PDO::PARAM_STR);
            $stmt->bindValue(':id', $invitado['id'], PDO::PARAM_INT);
            $stmt->execute();
            $mensaje = "¡Gracias! Tu respuesta ha sido registrada.";
            $invitado['confirmado'] = true;
            $invitado['asistencia'] = $asistencia === 'si' ? 'Asistirá' : 'No asistirá';
        } else {
            $mensaje = "Por favor selecciona una opción válida.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Invitación - <?= htmlspecialchars($invitado['nombre']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #f0f4f7, #d9e2ec);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h2 { color: #1b3a57; margin-bottom: 20px; }
        p { font-size: 18px; margin-bottom: 30px; }
        input[type="radio"] {
            margin-right: 10px;
        }
        button {
            background: #28a745;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover { background: #218838; }
        .mensaje { margin-top: 20px; font-weight: bold; color: #333; }
    </style>
</head>
<body>

<div class="container">
    <h2>Hola, <?= htmlspecialchars($invitado['nombre']) ?></h2>

    <?php if ($invitado['confirmado']): ?>
        <p>Ya has respondido: <strong><?= htmlspecialchars($invitado['asistencia']) ?></strong></p>
    <?php else: ?>
        <form method="POST">
            <p>¿Asistirás a la boda?</p>
            <label><input type="radio" name="asistencia" value="si" required> Sí, asistiré</label><br><br>
            <label><input type="radio" name="asistencia" value="no" required> No podré asistir</label><br><br>
            <button type="submit">Enviar Respuesta</button>
        </form>
    <?php endif; ?>

    <?php if ($mensaje): ?>
        <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
</div>

</body>
</html>
