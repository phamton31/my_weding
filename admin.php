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

// Función para generar código único
function generarCodigo($longitud = 6) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $codigo = '';
    for ($i = 0; $i < $longitud; $i++) {
        $codigo .= $caracteres[random_int(0, strlen($caracteres) - 1)];
    }
    return $codigo;
}

// Crear o editar invitado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $duplicar = isset($_POST["duplicar"]);
    $editar_id = $_POST["editar_id"] ?? null;

    if ($editar_id) {
        // Editar invitado existente
        $sql = "UPDATE invitados SET nombre = :nombre WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindValue(':id', $editar_id, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $codigo = generarCodigo();
        $confirmado = false;
        $asistencia = null;

        // Insertar nuevo invitado
        $sql = "INSERT INTO invitados (codigo, nombre, confirmado, asistencia)
                VALUES (:codigo, :nombre, :confirmado, :asistencia)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':codigo', $codigo, PDO::PARAM_STR);
        $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindValue(':confirmado', $confirmado, PDO::PARAM_BOOL);
        $stmt->bindValue(':asistencia', $asistencia, PDO::PARAM_NULL);
        $stmt->execute();

        // Duplicar invitado si checkbox está marcado
        if ($duplicar) {
            $stmt = $pdo->prepare("INSERT INTO invitados (codigo, nombre, confirmado, asistencia) VALUES (:codigo, :nombre, :confirmado, :asistencia)");
            $stmt->bindValue(':codigo', $codigo, PDO::PARAM_STR);
            $stmt->bindValue(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindValue(':confirmado', $confirmado, PDO::PARAM_BOOL);
            $stmt->bindValue(':asistencia', $asistencia, PDO::PARAM_NULL);
            $stmt->execute();
        }
    }
}

// Eliminar invitado
if (isset($_GET['eliminar'])) {
    $idEliminar = intval($_GET['eliminar']);
    $stmt = $pdo->prepare("DELETE FROM invitados WHERE id = :id");
    $stmt->bindValue(':id', $idEliminar, PDO::PARAM_INT);
    $stmt->execute();
    header("Location: admin.php");
    exit;
}

// Obtener lista de invitados
$stmt = $pdo->query("SELECT * FROM invitados ORDER BY id DESC");
$invitados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Estadísticas
$total = count($invitados);
$confirmados = count(array_filter($invitados, fn($i) => $i['confirmado']));
$no_confirmados = $total - $confirmados;

// URL base de la invitación
$baseURL = "https://my-weding.onrender.com?codigo=";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Invitados</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 40px;
            background: linear-gradient(to right, #f0f4f7, #d9e2ec);
        }
        h2 { color: #1b3a57; }
        .panel {
            background: #fff;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        input[type="text"], button {
            padding: 10px;
            font-size: 16px;
        }
        button {
            cursor: pointer;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            transition: background 0.3s;
        }
        button:hover { background: #218838; }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            background: #fff;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th { background: #007bff; color: #fff; }
        tr:hover { background: #f1f1f1; }
        .stats { display: flex; gap: 20px; margin-bottom: 20px; }
        .stat {
            padding: 20px;
            border-radius: 10px;
            flex: 1;
            text-align: center;
            color: #fff;
            font-weight: bold;
            font-size: 18px;
        }
        .stat.total { background: #17a2b8; }
        .stat.confirmados { background: #28a745; }
        .stat.no-confirmados { background: #dc3545; }
        .link { color: #007bff; text-decoration: none; }
        .link:hover { text-decoration: underline; }
        .actions a {
            margin-right: 10px;
            text-decoration: none;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
        }
        .edit { background: #ffc107; }
        .edit:hover { background: #e0a800; }
        .delete { background: #dc3545; }
        .delete:hover { background: #c82333; }
        .checkbox-label { display: flex; align-items: center; gap: 5px; margin-top: 10px; }
    </style>
</head>
<body>

<div class="panel">
    <h2>Agregar Invitado</h2>
    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre del invitado" required>
        <div class="checkbox-label">
            <input type="checkbox" name="duplicar" id="duplicar">
            <label for="duplicar">Crear otro invitado con el mismo código</label>
        </div>
        <button type="submit">Agregar</button>
    </form>
</div>

<div class="panel stats">
    <div class="stat total">
        <h3>Total Invitados</h3>
        <p><?= $total ?></p>
    </div>
    <div class="stat confirmados">
        <h3>Confirmados</h3>
        <p><?= $confirmados ?></p>
    </div>
    <div class="stat no-confirmados">
        <h3>No Confirmados</h3>
        <p><?= $no_confirmados ?></p>
    </div>
</div>

<div class="panel">
    <h2>Lista de Invitados</h2>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Confirmado</th>
                <th>Asistencia</th>
                <th>Link de Invitación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($invitados as $inv): ?>
                <tr>
                    <td><?= htmlspecialchars($inv['codigo']) ?></td>
                    <td><?= htmlspecialchars($inv['nombre']) ?></td>
                    <td><?= $inv['confirmado'] ? 'Sí' : 'No' ?></td>
                    <td><?= htmlspecialchars($inv['asistencia'] ?? '-') ?></td>
                    <td><a class="link" href="<?= $baseURL . urlencode($inv['codigo']) ?>" target="_blank">Ver Invitación</a></td>
                    <td class="actions">
                        <a class="edit" href="admin.php?editar=<?= $inv['id'] ?>">Editar</a>
                        <a class="delete" href="admin.php?eliminar=<?= $inv['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar este invitado?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
