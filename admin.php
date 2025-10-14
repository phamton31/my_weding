<?php
session_start();


// --- LOGIN SIMPLE ---
$usuario_admin = "admin";
$password_admin = "Dreiser1234!"; // cámbialo si deseas


if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}


if (isset($_POST['usuario']) && isset($_POST['password'])) {
    if ($_POST['usuario'] === $usuario_admin && $_POST['password'] === $password_admin) {
        $_SESSION['admin'] = true;
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}


if (!isset($_SESSION['admin'])):
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Acceso Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
  <form method="POST" class="bg-white p-8 rounded-2xl shadow-lg w-80 space-y-4">
    <h1 class="text-2xl font-bold text-center">Acceso Admin</h1>
    <?php if (!empty($error)): ?>
      <p class="text-red-500 text-sm text-center"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <input type="text" name="usuario" placeholder="Usuario" class="w-full border rounded px-3 py-2">
    <input type="password" name="password" placeholder="Contraseña" class="w-full border rounded px-3 py-2">
    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">Ingresar</button>
  </form>
</body>
</html>
<?php
exit;
endif;


// --- LÓGICA DEL ADMIN ---
$jsonFile = 'invitados.json';


if (!file_exists($jsonFile)) {
    file_put_contents($jsonFile, '[]');
    chmod($jsonFile, 0666);
}


$data = json_decode(file_get_contents($jsonFile), true);
if (!is_array($data)) {
    $data = [];
}


// Función para generar código aleatorio
function generarCodigo($longitud = 6) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    return substr(str_shuffle($caracteres), 0, $longitud);
}


// Crear nuevo invitado
if (isset($_POST['nuevo_invitado'])) {
    $nombres = array_map('trim', $_POST['nombres']); // Array de nombres (1 o 2)
    $codigo = generarCodigo();


    foreach ($nombres as $nombre) {
        if (!empty($nombre)) {
            $data[] = [
                "codigo" => $codigo,
                "nombre" => $nombre,
                "confirmado" => false,
                "asistencia" => ""
            ];
        }
    }


    file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));
    header("Location: admin.php");
    exit;
}


// Editar invitado existente
if (isset($_POST['editar_invitado'])) {
    $codigo = $_POST['codigo'];
    $nombres = array_map('trim', explode(',', $_POST['nombres']));
    $asistencia = $_POST['asistencia'];


    $count = 0;
    foreach ($data as &$inv) {
        if ($inv['codigo'] === $codigo && isset($nombres[$count])) {
            $inv['nombre'] = $nombres[$count];
            $inv['asistencia'] = $asistencia;
            $count++;
        }
    }
    file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));
    header("Location: admin.php");
    exit;
}


// Eliminar invitado
if (isset($_GET['eliminar'])) {
    $codigo = $_GET['eliminar'];
    $data = array_filter($data, fn($inv) => $inv['codigo'] !== $codigo);
    file_put_contents($jsonFile, json_encode(array_values($data), JSON_PRETTY_PRINT));
    header("Location: admin.php");
    exit;
}


// Estadísticas
$total = count($data);
$confirmados = count(array_filter($data, fn($i) => !empty($i['confirmado'])));
$asistiran = count(array_filter($data, fn($i) => isset($i['asistencia']) && strtolower($i['asistencia']) === 'si'));
$no_asistiran = count(array_filter($data, fn($i) => isset($i['asistencia']) && strtolower($i['asistencia']) === 'no'));


$base_url = "https://my-weding.onrender.com";
?>


<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel de Administración</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">


<!-- Header -->
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Panel de Invitados</h1>
    <form method="POST">
        <button name="logout" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Cerrar sesión</button>
    </form>
</div>


<!-- Estadísticas -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white shadow rounded-lg p-4 text-center">
        <p class="text-gray-500">Total Invitados</p>
        <p class="text-2xl font-bold"><?= $total ?></p>
    </div>
    <div class="bg-green-100 shadow rounded-lg p-4 text-center">
        <p class="text-gray-500">Confirmados</p>
        <p class="text-2xl font-bold"><?= $confirmados ?></p>
    </div>
    <div class="bg-blue-100 shadow rounded-lg p-4 text-center">
        <p class="text-gray-500">Asistirán</p>
        <p class="text-2xl font-bold"><?= $asistiran ?></p>
    </div>
    <div class="bg-red-100 shadow rounded-lg p-4 text-center">
        <p class="text-gray-500">No Asistirán</p>
        <p class="text-2xl font-bold"><?= $no_asistiran ?></p>
    </div>
</div>


<!-- Formulario nuevo invitado con opción de pareja -->
<div class="bg-white p-4 rounded-lg shadow mb-6">
    <h2 class="text-xl font-semibold mb-2">Agregar Nuevo Invitado</h2>
    <form method="POST" class="flex flex-col md:flex-row md:items-end gap-4">
        <input type="hidden" name="nuevo_invitado" value="1">
        <div class="flex-1">
            <label class="block text-sm text-gray-600 mb-1">Nombre principal</label>
            <input type="text" name="nombres[]" required class="w-full border rounded px-3 py-2">
        </div>
        <div class="flex-1 hidden" id="parejaDiv">
            <label class="block text-sm text-gray-600 mb-1">Nombre de la pareja</label>
            <input type="text" name="nombres[]" class="w-full border rounded px-3 py-2">
        </div>
        <div class="flex items-center gap-2">
            <input type="checkbox" id="agregarPareja" class="h-4 w-4">
            <label for="agregarPareja" class="text-sm text-gray-600">Agregar pareja</label>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded">
            Agregar
        </button>
    </form>
</div>


<script>
const checkboxPareja = document.getElementById('agregarPareja');
const parejaDiv = document.getElementById('parejaDiv');


checkboxPareja.addEventListener('change', function() {
    if (this.checked) {
        parejaDiv.classList.remove('hidden');
        parejaDiv.querySelector('input').required = true;
    } else {
        parejaDiv.classList.add('hidden');
        parejaDiv.querySelector('input').required = false;
        parejaDiv.querySelector('input').value = '';
    }
});
</script>


<!-- Tabla de invitados -->
<div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
    <table class="min-w-full border border-gray-200">
        <thead class="bg-gray-50">
        <tr>
            <th class="py-2 px-4 border">Código</th>
            <th class="py-2 px-4 border">Nombres</th>
            <th class="py-2 px-4 border">Asistencia</th>
            <th class="py-2 px-4 border">Confirmado</th>
            <th class="py-2 px-4 border">Enlace</th>
            <th class="py-2 px-4 border">Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Agrupar nombres por código
        $grupos = [];
        foreach ($data as $inv) {
            $codigo = $inv['codigo'];
            if (!isset($grupos[$codigo])) {
                $grupos[$codigo] = [
                    "codigo" => $codigo,
                    "nombres" => [],
                    "asistencia" => $inv['asistencia'] ?? '',
                    "confirmado" => $inv['confirmado'] ?? false
                ];
            }
            $grupos[$codigo]["nombres"][] = $inv['nombre'];
        }


        foreach ($grupos as $grupo):
        ?>
        <tr class="hover:bg-gray-50 text-center">
            <td class="py-2 px-4 border font-mono"><?= htmlspecialchars($grupo['codigo']) ?></td>
            <td class="py-2 px-4 border"><?= htmlspecialchars(implode(', ', $grupo['nombres'])) ?></td>
            <td class="py-2 px-4 border"><?= htmlspecialchars($grupo['asistencia'] ?? '-') ?></td>
            <td class="py-2 px-4 border"><?= !empty($grupo['confirmado']) ? '✅' : '❌' ?></td>
            <td class="py-2 px-4 border">
                <?php $link = "{$base_url}/?codigo=" . urlencode($grupo['codigo']); ?>
                <div class="flex flex-col items-center">
                    <input 
                        type="text"
                        readonly
                        value="<?= htmlspecialchars($link) ?>"
                        class="border border-gray-300 rounded px-2 py-1 w-48 text-sm text-center bg-gray-50 cursor-pointer select-all mb-1"
                        onclick="navigator.clipboard.writeText(this.value).then(() => alert('Enlace copiado ✅'))"
                    >
                    <a href="<?= htmlspecialchars($link) ?>" target="_blank" class="text-blue-600 hover:underline text-sm">Abrir</a>
                </div>
            </td>
            <td class="py-2 px-4 border space-x-2">
                <button 
                  onclick="editarInvitado('<?= htmlspecialchars($grupo['codigo']) ?>', '<?= htmlspecialchars(implode(', ', $grupo['nombres'])) ?>', '<?= htmlspecialchars($grupo['asistencia'] ?? '') ?>')"
                  class="text-blue-600 hover:text-blue-800 font-semibold">Editar</button>
                <a href="?eliminar=<?= urlencode($grupo['codigo']) ?>" 
                   class="text-red-600 hover:text-red-800 font-semibold"
                   onclick="return confirm('¿Seguro que deseas eliminar este grupo de invitados?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>


<!-- Modal de edición -->
<div id="modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96 relative">
        <form method="POST" id="formEditar">
            <input type="hidden" name="editar_invitado" value="1">
            <input type="hidden" name="codigo" id="editCodigo">
            <h2 class="text-xl font-semibold mb-4">Editar Invitado</h2>
            <label class="block mb-1 text-sm text-gray-600">Nombres (coma separados)</label>
            <input type="text" name="nombres" id="editNombres" required class="w-full border rounded px-3 py-2 mb-3">
            <label class="block mb-1 text-sm text-gray-600">Asistencia</label>
            <select name="asistencia" id="editAsistencia" class="w-full border rounded px-3 py-2 mb-4">
                <option value="">Sin confirmar</option>
                <option value="si">Sí asistirá</option>
                <option value="no">No asistirá</option>
            </select>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="cerrarModal()" class="bg-gray-300 px-3 py-2 rounded">Cancelar</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Guardar</button>
            </div>
        </form>
    </div>
</div>


<script>
function editarInvitado(codigo, nombres, asistencia) {
    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('editCodigo').value = codigo;
    document.getElementById('editNombres').value = nombres;
    document.getElementById('editAsistencia').value = asistencia;
}
function cerrarModal() {
    document.getElementById('modal').classList.add('hidden');
}
</script>


</body>
</html>
