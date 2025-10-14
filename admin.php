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

// 🔍 Si está autenticado, mostramos el dashboard
$data = json_decode(file_get_contents('invitados.json'), true);
$total = count($data);
$confirmados = count(array_filter($data, fn($inv) => !empty($inv['confirmado']) && $inv['confirmado']));
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

        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-[#5C3A21] text-white">
                    <th class="py-2 px-4 border">Nombre</th>
                    <th class="py-2 px-4 border">Asistencia</th>
                    <th class="py-2 px-4 border">Confirmado</th>
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
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
