<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Asistencia con Cuenta Regresiva</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Allura&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Playfair Display', serif;
        }

        .linea-pulsante {
            width: 80%;
            height: 6px;
            background-color: #5C3A21;
            border-radius: 3px;
            animation: pulso 1.5s infinite;
            margin: 0 auto;
        }

        @keyframes pulso {
            0%, 100% { opacity: 1; transform: scaleX(1); }
            50% { opacity: 0.5; transform: scaleX(1.05); }
        }

        .countdown {
            font-size: 2.5rem;
            color: #5C3A21;
            margin-top: -4px;
            text-align: center;
        }

        @media (min-width: 768px) {
            .countdown { font-size: 3rem; }
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-100 to-blue-300 min-h-screen flex flex-col md:flex-row">

    <!-- Izquierda: cuenta regresiva + formulario -->
    <div class="w-full md:w-2/3 p-6 md:p-12 flex flex-col items-center relative">

        <img src="img/juntos.png" alt="Imagen de fondo" class="absolute inset-0 w-full h-full object-cover opacity-70">

        <div class="absolute inset-0 bg-gradient-to-b from-blue-500/30 via-transparent to-blue-500/50"></div>

        <div class="z-10 relative text-center mt-2 md:mt-0">

            <div class="text-3xl md:text-4xl font-bold text-[#5C3A21]"
                 style="font-family: 'Allura', cursive; text-shadow: 2px 2px 6px rgba(0,0,0,0.3);">
                 ¡Falta poco!
                 <div class="linea-pulsante -mt-2"></div>  
            </div>  

            <div id="countdown" class="countdown"></div>   

            <h2 class="text-2xl md:text-3xl mt-64 font-bold text-[#5C3A21]
                       drop-shadow-lg hover:scale-105 transition-transform duration-300"
                style="font-family: 'Allura', cursive; text-shadow: 2px 2px 8px rgba(0,0,0,0.4);">
                Su presencia es el testimonio más valioso de nuestro amor
            </h2>

            <div class="w-full max-w-md m-auto">
                <div class="form-container border border-white/30 rounded-2xl p-4 shadow-lg">
                    <form id="rsvpForm" class="flex flex-col space-y-4">
                        <label for="nombre" class="text-2xl md:text-3xl font-semibold text-[#5C3A21]"
                               style="font-family: 'Allura', cursive; font-style: italic;">Queridos invitados</label>
                        <p class="text-base md:text-lg text-[#5C3A21]">
                            Con el fin de que todos podamos disfrutar plenamente de la velada, hemos decidido que esta ocasión será exclusivamente para adultos
                        </p>
                        <select id="nombre" name="nombre"
                                class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#5C3A21]">
                            <option value="">Seleccione su nombre</option>
                        </select>

                        <label for="asistencia" class="font-semibold text-[#5C3A21]">Confirme su asistencia:</label>
                        <select id="asistencia" name="asistencia" class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#5C3A21]">
                            <option value="">Seleccione una opción</option>
                            <option value="si">Sí, asistiré</option>
                            <option value="no">No podré asistir</option>
                        </select>

                        <button type="submit" class="bg-[#5C3A21] hover:bg-[#7A4C2B] text-white font-bold py-2 px-4 rounded transition duration-300">
                            Confirmar
                        </button>
                        <div id="mensaje" class="mt-4 text-center text-lg font-semibold"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Derecha: información del evento -->
    <div class="w-full md:w-1/3 p-6 md:p-8 flex flex-col relative">
        <img src="img/maye.png" alt="Imagen" class="absolute inset-0 w-full h-full object-cover opacity-70">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/30 via-transparent to-blue-500/30"></div>
        <div class="relative z-10 flex flex-col justify-start">
            <div class="bg-white/70 p-6 rounded-lg shadow-lg">
                <h1 class="text-2xl md:text-3xl mb-3 text-[#5C3A21] text-center" style="font-family: 'Allura', cursive; font-style: italic;">
                    Queridos amigos y seres queridos:
                </h1>
                <p class="mb-4 text-[#5C3A21] text-base md:text-lg" style="font-family: 'Playfair Display', serif;">
                    <span style="font-family: 'Allura', cursive; font-size: 1.5rem; color: #8B3E2F;">El amor</span> 
                    que nos une ha encontrado su día para ser perpetuado. Con inmensa alegría, hemos decidido unir nuestras vidas en matrimonio.
                </p>
                <p class="mb-4 text-base md:text-lg text-[#5C3A21]">
                    Nos encantaría que nos acompañen para ser testigos de nuestros votos y celebrar el inicio de nuestra vida juntos.
                </p>
                <h2 class="text-2xl md:text-3xl mb-3 text-[#5C3A21] text-center" style="font-family: 'Allura', cursive; font-style: italic;">
                    Programa del Evento
                </h2>
                <ul class="list-disc list-inside mb-4 text-center text-base md:text-lg">
                    <li class="hover:text-[#8B3E2F] hover:scale-105 transition-all duration-300">Ceremonia matrimonial</li>
                    <li class="hover:text-[#8B3E2F] hover:scale-105 transition-all duration-300">Sesión fotográfica con los novios</li>
                    <li class="hover:text-[#8B3E2F] hover:scale-105 transition-all duration-300">Brindis de honor</li>
                    <li class="hover:text-[#8B3E2F] hover:scale-105 transition-all duration-300">Baile inaugural de los novios</li>
                    <li class="hover:text-[#8B3E2F] hover:scale-105 transition-all duration-300">Palabras y buenos deseos de los invitados</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        let invitados = [];
        fetch('invitados.json')
            .then(response => response.json())
            .then(data => { invitados = data; actualizarSelect(); })
            .catch(err => console.error("Error al cargar invitados:", err));

        const nombreInput = document.getElementById("nombre");
        const form = document.getElementById("rsvpForm");
        const mensaje = document.getElementById("mensaje");

        function actualizarSelect() {
            nombreInput.innerHTML = '<option value="">Seleccione su nombre</option>';
            invitados.forEach(inv => {
                const option = document.createElement("option");
                option.value = inv.nombre;
                option.textContent = inv.nombre + (inv.confirmado ? " (Ya confirmado)" : "");
                option.disabled = inv.confirmado;
                nombreInput.appendChild(option);
            });
        }
        form.addEventListener("submit", async function (e) {
            e.preventDefault();
                
            const nombre = nombreInput.value;
            const asistencia = document.getElementById("asistencia").value.trim();
                
            if (!nombre || !asistencia) {
                mensaje.textContent = "Por favor complete todos los campos.";
                mensaje.classList.remove("text-green-700");
                mensaje.classList.add("text-red-700");
                return;
            }
        
            // Verificar si ya estaba confirmado en el JSON
            const invitado = invitados.find(inv => inv.nombre === nombre);
            if (invitado && invitado.confirmado) {
                mensaje.textContent = "Ya registraste tu respuesta. No es posible cambiarla.";
                mensaje.classList.remove("text-green-700");
                mensaje.classList.add("text-red-700");
                return;
            }
        
            try {
                const res = await fetch("confirmaciones.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ nombre, asistencia })
                });
            
                const data = await res.json();
            
                if (data.success) {
                    mensaje.textContent = `¡Gracias, ${nombre}! Tu asistencia ha sido registrada como "${asistencia}".`;
                    mensaje.classList.remove("text-red-700");
                    mensaje.classList.add("text-green-700");
                    await fetch('invitados.json')
                        .then(response => response.json())
                        .then(updated => { invitados = updated; actualizarSelect(); });
                } else {
                    mensaje.textContent = data.error || "Error al guardar la confirmación.";
                    mensaje.classList.remove("text-green-700");
                    mensaje.classList.add("text-red-700");
                }
            } catch (err) {
                console.error(err);
                mensaje.textContent = "Error de conexión con el servidor.";
                mensaje.classList.remove("text-green-700");
                mensaje.classList.add("text-red-700");
            }
        });

        const targetDate = new Date("November 7, 2025 18:30:00").getTime();
        const countdownElement = document.getElementById("countdown");

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate - now;
            if (distance < 0) {
                countdownElement.innerHTML = "¡Es hora de celebrar!";
                clearInterval(interval);
                return;
            }
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            countdownElement.innerHTML = `${days}d : ${hours}h : ${minutes}m : ${seconds}s`;
        }
        updateCountdown();
        const interval = setInterval(updateCountdown, 1000);
        
    </script>

</body>
</html>
