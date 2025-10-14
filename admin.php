<?php
session_start();

// 🔐 Contraseña de acceso (puedes cambiarla)
$PASSWORD = "Dreiser1234!";

// Si se está enviando el formulario de login
if (isset($_POST['password'])) {
    if ($_POST['password'] === $PASSWORD) {
        $_SESSION['autenticado'] = true;
    } else {
        $error = "Contraseña incorrecta.";
    }
}

// Si el usuario quiere salir
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit;
}

// Si no está autenticado, muestra el login
if (empty($_SESSION['autenticado'])):
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso al Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 to-blue-300 flex items-center justify-center h-screen">
    <form method="POST" class="bg-white p-6 rounded-lg shadow-lg w-80 text-center">
        <h2 class="text-xl font-bold text-[#5C3A21] mb-4">Panel de Administración</h2>
        <input type="password" name="password" placeholder="Contraseña" class="border border-gray-300 rounded px-3 py-2 w-full mb-3 focus:ring-2 focus:ring-[#5C3A21] focus:outline-none">
        <?php if (!empty($error)): ?>
            <p class="text-red-600 text-sm mb-2"><?= $error ?></p>
        <?php endif; ?>
        <button type="submit" class="bg-[#5C3A21] hover:bg-[#7A4C2B] text-white px-4 py-2 rounded w-full transition">Entrar</button>
    </form>
</body>
</html>
<?php
exit;
endif;

// Configuración del archivo JSON
$json_file = 'invitados.json';
$guest_message = null;
$guest_status = null;

// Manejo de mensajes después de la redirección (para agregar o eliminar)
if (isset($_GET['status']) && isset($_GET['msg'])) {
    $guest_status = $_GET['status'];
    $guest_message = htmlspecialchars($_GET['msg']);
}

// --- Lógica para ELIMINAR INVITADO ---
if (isset($_GET['delete_guest'])) {
    $guestToDelete = trim($_GET['delete_guest']);
    $data = json_decode(file_get_contents($json_file), true);
    $initialCount = count($data);
    
    // Filtramos para crear un nuevo array sin el invitado a eliminar
    $data = array_filter($data, function($inv) use ($guestToDelete) {
        // Compara el nombre de forma insensible a mayúsculas/minúsculas
        return mb_strtolower($inv['nombre']) !== mb_strtolower($guestToDelete);
    });

    // Reindexar el array para asegurar que el JSON no tenga índices dispersos
    $data = array_values($data);
    $finalCount = count($data);

    if ($finalCount < $initialCount) {
        // Se encontró y se eliminó al menos uno
        if (file_put_contents($json_file, json_encode($data, JSON_PRETTY_PRINT))) {
            $guest_status = 'success';
            $guest_message = "Invitado '{$guestToDelete}' eliminado exitosamente.";
        } else {
            $guest_status = 'error';
            $guest_message = "Error: No se pudo escribir en el archivo invitados.json. Verifica permisos.";
        }
    } else {
        $guest_status = 'error';
        $guest_message = "Error: Invitado '{$guestToDelete}' no encontrado o ya eliminado.";
    }

    // Redireccionar para limpiar los parámetros GET
    header("Location: admin.php?status={$guest_status}&msg=" . urlencode($guest_message));
    exit;
}

// --- Lógica para AGREGAR INVITADO ---
if (isset($_POST['new_guest_name'])) {
    $newGuestName = trim($_POST['new_guest_name']);

    if (!empty($newGuestName)) {
        $data = json_decode(file_get_contents($json_file), true);

        // Crear el nuevo invitado con estado inicial
        $newGuest = [
            'nombre' => $newGuestName,
            'confirmado' => false,
            'asistencia' => null
        ];

        // Verificar si el invitado ya existe (comparación insensible a mayúsculas/minúsculas)
        $exists = false;
        foreach ($data as $guest) {
            if (mb_strtolower($guest['nombre']) === mb_strtolower($newGuestName)) {
                $exists = true;
                break;
            }
        }

        if (!$exists) {
            $data[] = $newGuest; // Agrega el nuevo invitado al array

            // Guarda el array actualizado en el archivo JSON
            if (file_put_contents($json_file, json_encode($data, JSON_PRETTY_PRINT))) {
                $guest_message = "Invitado '{$newGuestName}' agregado exitosamente. La lista de RSVP ha sido actualizada.";
                $guest_status = 'success';
                // Para evitar el reenvío del formulario al recargar, se redirige.
                header("Location: admin.php?status={$guest_status}&msg=" . urlencode($guest_message));
                exit;
            } else {
                $guest_message = "Error: No se pudo escribir en el archivo invitados.json. Verifica permisos.";
                $guest_status = 'error';
            }
        } else {
            $guest_message = "El invitado '{$newGuestName}' ya existe en la lista.";
            $guest_status = 'warning';
        }
    } else {
        $guest_message = "El nombre del invitado no puede estar vacío.";
        $guest_status = 'error';
    }
}
// ----------------------------------------------------------------------


// 🔍 Si está autenticado, mostramos el dashboard y cargamos los datos
$data = json_decode(file_get_contents('invitados.json'), true);
$total = count($data);
// Recálculo de estadísticas
$confirmados = count(array_filter($data, fn($inv) => !empty($inv['asistencia'])));
$asistiran = count(array_filter($data, fn($inv) => $inv['asistencia'] === 'si'));
$noasistiran = count(array_filter($data, fn($inv) => $inv['asistencia'] === 'no'));
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Confirmaciones</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-2xl p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-[#5C3A21]">📊 Panel de Confirmaciones</h1>
            <a href="?logout=true" class="text-red-600 font-semibold hover:underline">Cerrar sesión</a>
        </div>

        <!-- FORMULARIO PARA AGREGAR INVITADO -->
        <div class="bg-yellow-50 border-l-4 border-[#5C3A21] p-4 mb-8 rounded-lg">
            <h2 class="text-2xl font-bold text-[#5C3A21] mb-4">➕ Agregar Nuevo Invitado</h2>
            
            <?php if (!empty($guest_message)): ?>
                <div class="p-3 mb-4 rounded-lg 
                    <?= $guest_status === 'success' ? 'bg-green-100 text-green-700' : 
                       ($guest_status === 'warning' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') ?>">
                    <?= $guest_message ?>
                </div>
            <?php endif; ?>

            <form method="POST" id="addGuestForm" class="flex flex-col sm:flex-row gap-3">
                <input type="text" name="new_guest_name" placeholder="Nombre completo del invitado" required
                       class="border border-gray-300 rounded px-3 py-2 flex-grow focus:ring-2 focus:ring-[#5C3A21] focus:outline-none">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded transition">
                    Guardar Invitado
                </button>
            </form>
        </div>
        
        <!-- ESTADÍSTICAS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center mb-6">
            <div class="bg-green-100 p-4 rounded-lg">
                <p class="text-2xl font-bold text-green-800"><?= $asistiran ?></p>
                <p class="text-green-700">Asistirán</p>
            </div>
            <div class="bg-red-100 p-4 rounded-lg">
                <p class="text-2xl font-bold text-red-800"><?= $noasistiran ?></p>
                <p class="text-red-700">No asistirán</p>
            </div>
            <div class="bg-blue-100 p-4 rounded-lg">
                <p class="text-2xl font-bold text-blue-800"><?= $confirmados ?> / <?= $total ?></p>
                <p class="text-blue-700">Confirmados / Total</p>
            </div>
        </div>

        <!-- LISTA DE INVITADOS -->
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-[#5C3A21] text-white">
                    <th class="py-2 px-4 border">Nombre</th>
                    <th class="py-2 px-4 border">Asistencia</th>
                    <th class="py-2 px-4 border">Confirmado</th>
                    <th class="py-2 px-4 border">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $inv): ?>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-4"><?= htmlspecialchars($inv['nombre']) ?></td>
                        <td class="py-2 px-4 text-center">
                            <?php if (!empty($inv['asistencia'])): ?>
                                <span class="<?= $inv['asistencia'] === 'si' ? 'text-green-700 font-semibold' : 'text-red-700 font-semibold' ?>">
                                    <?= strtoupper($inv['asistencia']) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-gray-400 italic">Sin respuesta</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-2 px-4 text-center">
                            <?= !empty($inv['confirmado']) && $inv['confirmado'] ? '✅' : '❌' ?>
                        </td>
                        <td class="py-2 px-4 text-center">
                            <!-- Botón de eliminación. Se usa un formulario GET para simplicidad. -->
                            <form method="GET" onsubmit="return confirm('¿Estás seguro de que quieres eliminar a <?= htmlspecialchars($inv['nombre']) ?> de la lista? Esta acción es irreversible.');">
                                <input type="hidden" name="delete_guest" value="<?= htmlspecialchars($inv['nombre']) ?>">
                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded transition duration-150 shadow-md">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>