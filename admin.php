<?php
session_start();

// --- LOGIN SIMPLE ---
$usuario_admin = "admin";
$password_admin = "Dreiser1234!";

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

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Panel de Invitados</h1>
    <form method="POST">
        <button name="logout" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Cerrar sesión</button>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white shadow rounded-lg p-4 text-center">
        <p class="text-gray-500">Total Invitados</p>
        <p class="text-2xl font-bold" id="total">0</p>
    </div>
    <div class="bg-green-100 shadow rounded-lg p-4 text-center">
        <p class="text-gray-500">Confirmados</p>
        <p class="text-2xl font-bold" id="confirmados">0</p>
    </div>
    <div class="bg-blue-100 shadow rounded-lg p-4 text-center">
        <p class="text-gray-500">Asistirán</p>
        <p class="text-2xl font-bold" id="asistiran">0</p>
    </div>
    <div class="bg-red-100 shadow rounded-lg p-4 text-center">
        <p class="text-gray-500">No Asistirán</p>
        <p class="text-2xl font-bold" id="no_asistiran">0</p>
    </div>
</div>

<div class="bg-white p-4 rounded-lg shadow mb-6">
    <h2 class="text-xl font-semibold mb-2">Agregar Nuevo Invitado</h2>
    <form id="formNuevoInvitado" class="flex flex-col md:flex-row md:items-end gap-4">
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
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded">Agregar</button>
    </form>
</div>

<div class="bg-white shadow-lg rounded-lg p-4 overflow-x-auto">
    <table class="min-w-full border border-gray-200" id="tablaInvitados">
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
        <tbody></tbody>
    </table>
</div>

<div id="modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg p-6 w-96 relative">
        <form id="formEditar">
            <input type="hidden" name="editar_invitado" value="1">
            <input type="hidden" name="codigo" id="editCodigo">
            <h2 class="text-xl font-semibold mb-4">Editar Invitado</h2>
            <label class="block mb-1 text-sm text-gray-600">Nombres (coma separados)</label>
            <input type="text" name="nombres" id="editNombres" required class="w-full border rounded px-3 py-2 mb-3">
            <label class="block mb-1 text-sm text-gray-600">Asistencia</label>
            <select name="asistencia" id="editAsistencia" class="w-full border rounded px-3 py-2 mb-4">
                <option value="">Pendiente</option>
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
const formNuevo = document.getElementById('formNuevoInvitado');
const checkboxPareja = document.getElementById('agregarPareja');
const parejaDiv = document.getElementById('parejaDiv');
const tablaBody = document.querySelector('#tablaInvitados tbody');
let invitadosData = [];

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

formNuevo.addEventListener('submit', async function(e) {
    e.preventDefault();

    const nombres = Array.from(formNuevo.querySelectorAll('input[name="nombres[]"]'))
                        .map(input => input.value.trim())
                        .filter(n => n.length > 0);

    if (nombres.length === 0) {
        alert('Debes ingresar al menos un nombre.');
        return;
    }

    // Creamos un array de invitados
    const invitados = nombres.map(nombre => ({
        codigo: '',          // El backend puede generar el código
        nombre: nombre,
        confirmado: false,
        asistencia: ''
    }));

    try {
        const res = await fetch('post_invitado.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ invitados }) // enviamos un objeto con el array
        });

        const data = await res.json();

        if (data.success) {
            alert('✅ Invitado agregado correctamente con código: ' + data.codigo);
            formNuevo.reset();
            parejaDiv.classList.add('hidden');
            window.location.reload();
        } else {
            alert('⚠️ Error: ' + (data.error || 'No se pudo agregar el invitado'));
        }
    } catch (err) {
        console.error(err);
        alert('❌ Error al enviar el formulario.');
    }
});

function cerrarModal() {
    document.getElementById('modal').classList.add('hidden');
}

document.getElementById('formEditar').addEventListener('submit', async function(e){
    e.preventDefault();
    const codigo = document.getElementById('editCodigo').value;
    const nombres = document.getElementById('editNombres').value.split(',').map(n=>n.trim());
    const asistencia = document.getElementById('editAsistencia').value;

    const formData = new FormData();
    formData.append('action', 'editar');
    formData.append('codigo', codigo);
    nombres.forEach(n => formData.append('nombres[]', n));
    formData.append('asistencia', asistencia);

    const res = await fetch('post_invitado.php', { method:'POST', body: formData });
    const data = await res.json();
    if(data.success) {
        alert('✅ Invitado editado correctamente');
        cargarInvitados();
        cerrarModal();
    } else {
        alert('⚠️ Error: '+ (data.error || 'No se pudo editar'));
    }
});

async function eliminarInvitado(codigo){
    if(!confirm('¿Seguro que deseas eliminar este grupo de invitados?')) return;
    const formData = new FormData();
    formData.append('action', 'eliminar');
    formData.append('codigo', codigo);
    const res = await fetch('post_invitado.php', { method:'POST', body: formData });
    const data = await res.json();
    if(data.success){
        alert('✅ Invitado eliminado');
        cargarInvitados();
    } else {
        alert('⚠️ Error: '+ (data.error || 'No se pudo eliminar'));
    }
}

function editarInvitadoModal(codigo, nombres, asistencia){
    document.getElementById('modal').classList.remove('hidden');
    document.getElementById('editCodigo').value = codigo;
    document.getElementById('editNombres').value = nombres;
    document.getElementById('editAsistencia').value = asistencia;
}

function renderTabla(data){
    invitadosData = data;
    tablaBody.innerHTML = '';
    let grupos = {};
    data.forEach(inv => {
        if(!grupos[inv.codigo]){
            grupos[inv.codigo] = { codigo: inv.codigo, nombres: [], asistencia: inv.asistencia || '' };
        }
        grupos[inv.codigo].nombres.push(inv.nombre);
    });

    let total=0, confirmados=0, asistiran=0, no_asistiran=0;
    for(let g of Object.values(grupos)){
        total++;
        if(g.asistencia) confirmados++;
        if(g.asistencia.toLowerCase() === 'si') asistiran++;
        if(g.asistencia.toLowerCase() === 'no') no_asistiran++;

        const asistenciaDisplay = g.asistencia ? g.asistencia.charAt(0).toUpperCase() + g.asistencia.slice(1) : 'Pendiente';
        const link = "<?= $base_url ?>/?codigo=" + encodeURIComponent(g.codigo);

        const tr = document.createElement('tr');
        tr.classList.add('hover:bg-gray-50','text-center');
        tr.innerHTML = `
            <td class="py-2 px-4 border font-mono">${g.codigo}</td>
            <td class="py-2 px-4 border">${g.nombres.join(', ')}</td>
            <td class="py-2 px-4 border">${asistenciaDisplay}</td>
            <td class="py-2 px-4 border">${g.asistencia ? '✅':'❌'}</td>
            <td class="py-2 px-4 border">
                <div class="flex flex-col items-center">
                    <input type="text" readonly value="${link}" class="border border-gray-300 rounded px-2 py-1 w-48 text-sm text-center bg-gray-50 cursor-pointer select-all mb-1" onclick="navigator.clipboard.writeText(this.value).then(()=>alert('Enlace copiado ✅'))">
                    <a href="${link}" target="_blank" class="text-blue-600 hover:underline text-sm">Abrir</a>
                </div>
            </td>
            <td class="py-2 px-4 border space-x-2">
                <button onclick="editarInvitadoModal('${g.codigo}','${g.nombres.join(', ')}','${g.asistencia}')" class="text-blue-600 hover:text-blue-800 font-semibold">Editar</button>
                <button onclick="eliminarInvitado('${g.codigo}')" class="text-red-600 hover:text-red-800 font-semibold">Eliminar</button>
            </td>`;
        tablaBody.appendChild(tr);
    }

    document.getElementById('total').innerText = total;
    document.getElementById('confirmados').innerText = confirmados;
    document.getElementById('asistiran').innerText = asistiran;
    document.getElementById('no_asistiran').innerText = no_asistiran;
}

async function cargarInvitados(){
    const res = await fetch('get_invitados.php');
    const data = await res.json();
    if(data.success){
        renderTabla(data.data);
    } else {
        alert('Error al cargar invitados: ' + data.error);
    }
}

window.addEventListener('load', cargarInvitados);
</script>

</body>
</html>
