<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <title>Invitación de Boda - Dreiser & Mayerly</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&family=Great+Vibes&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Windsong&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&family=UnifrakturCook:wght@700&family=WindSong:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Allura&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Playfair Display', serif;
            /* El degradado de fondo principal del body ahora se encarga de la consistencia */
            background-attachment: fixed; /* Esto hace que el degradado del body se mueva suavemente */
        }

        /* La animación de rotación para la flecha de scroll */
        @keyframes rotate-arrow {
            0% { transform: translateY(0); opacity: 1; }
            50% { transform: translateY(10px); opacity: 0.5; }
            100% { transform: translateY(0); opacity: 1; }
        }

        .scroll-indicator {
            animation: rotate-arrow 1.5s infinite;
        }
        
        @keyframes pulso-contador {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.02); opacity: 0.95; } /* Pulso sutil en el reloj */
            }

            /* Aplicamos la animación de pulso al elemento del contador */
            .countdown-pulsante {
                animation: pulso-contador 2s infinite ease-in-out;
            }

            /* Estilo para la línea separadora */
            .linea-pulsante {
                width: 80%;
                height: 6px;
                background-color: #5C3A21;
                border-radius: 3px;
                margin: 0 auto;
                /* Quitamos la animación de pulso de aquí */
            }

    </style>
</head>

<body class="bg-gradient-to-br from-blue-100 to-blue-300 min-h-screen">

    <section id="invitacion" class="relative w-full max-w-5xl h-screen mx-auto p-10 flex items-center justify-center">

        <div class="absolute inset-0 flex items-center justify-center z-10 pointer-events-none">
            <img src="img/marco.jpg" alt="Marco de invitación"
                 class="w-auto h-full max-w-full max-h-full opacity-70"
                 style="mask-image: linear-gradient(to right, transparent 0%, black 20%, black 80%, transparent 100%);
                         -webkit-mask-image: linear-gradient(to right, transparent 0%, black 20%, black 80%, transparent 100%);
                         mask-repeat: no-repeat;
                         mask-position: center;
                         mask-size: cover;">
        </div>
        
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center pointer-events-auto z-20 space-y-6 bg-blue-300/35 p-4 rounded-lg">

            <h1 class="text-7xl md:text-8xl text-yellow-700/80" style="font-family: 'Windsong', cursive; color: #5C3A21;">
                Nos Casamos
            </h1>
            <div class="flex flex-col items-center justify-center space-y-4">
                <div class="flex flex-col items-center justify-center">
                    <div>
                        <p class="text-5xl md:text-6xl mb-2" style="font-family: 'Playfair Display', serif; color: #5C3A21;">Dreiser</p>
                        <p class="text-6xl md:text-7xl" style="font-family: 'Windsong', cursive; color: #5C3A21;">Morales</p>
                    </div>

                    <div class="-mt-12">
                        <img src="img/anillos.png" alt="Anillos" class="w-24 md:w-24 mx-auto">
                    </div>

                    <div class="-mt-8">
                        <p class="text-5xl md:text-6xl mb-2" style="font-family: 'Playfair Display', serif; color: #5C3A21;">Mayerly</p>
                        <p class="text-6xl md:text-7xl" style="font-family: 'Windsong', cursive; color: #5C3A21;">Florez</p>
                    </div>
                </div>
            </div>

            <div class="text-center mt-6 flex flex-col items-center justify-center">
                <p class="text-2xl md:text-3xl mb-2 border-b-4 border-[#5C3A21]/70 pb-2" style="font-family: 'Playfair Display', serif; color: #5C3A21;">
                    Viernes 
                    <span class="inline-block text-5xl md:text-6xl font-bold rounded-full bg-white/0 px-6 py-6 mx-2" style="color: #5C3A21;">
                        7
                    </span> 
                    6:00 PM
                </p>

                <p class="text-2xl md:text-3xl -mt-2" style="font-family: 'Playfair Display', serif; color: #5C3A21;">
                    Noviembre
                </p>
            </div>

            <div class="mt-4 flex flex-col items-center space-y-3">
                <p class="text-xl md:text-2xl" style="font-family: 'Playfair Display', serif; color: #5C3A21;">
                    Barrio Aeropuerto: <span class="">Calle 15 # 4 - 10 </span>
                </p>
                <a href="#programa"
                   class="scroll-indicator bg-[#5C3A21]/80 hover:bg-[#5C3A21] text-white font-bold py-2 px-6 rounded-lg shadow-lg transition duration-300 mt-4 flex items-center justify-center space-x-2"
                   style="font-family: 'Playfair Display', cursive;">
                    <span>VER DETALLES</span>
                    <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </a>
            </div>
        </div>
    </section>

    <section id="programa" class="w-full min-h-screen p-6 md:p-12 flex items-center justify-center bg-blue-100/50">
        <div class="relative w-full max-w-5xl flex flex-col md:flex-row items-center justify-center">

            <div class="w-full md:w-2/3 h-full flex items-center justify-center relative p-4 md:p-0">
                <img src="img/propuesta.jpg" alt="propuesta"
                    class="w-full h-auto max-h-[80vh] object-contain opacity-80 rounded-lg shadow-xl"
                    style="mask-image: linear-gradient(to top, transparent 0%, black 10%, black 90%, transparent 100%);
                           -webkit-mask-image: linear-gradient(to top, transparent 0%, black 10%, black 90%, transparent 100%);
                           mask-repeat: no-repeat;
                           mask-position: center;
                           mask-size: cover;">
            </div>

            <div class="relative z-10 w-full md:w-1/3 flex flex-col items-center justify-center mt-8 md:mt-0 md:ml-6">
                <div class="bg-white/95 p-6 rounded-xl shadow-2xl w-full max-w-sm">

                    <h1 class="text-3xl md:text-4xl mb-4 text-[#5C3A21] text-center border-b-2 border-[#5C3A21]/50 pb-2" 
                        style="font-family: 'Allura', cursive; font-style: italic;">
                        Queridos amigos y seres queridos:
                    </h1>

                    <p class="mb-4 text-[#5C3A21] text-base md:text-lg text-center" style="font-family: 'Playfair Display', serif;">
                        <span class="bg-yellow-200/60 rounded-full p-0.5" style="font-family: 'Allura', cursive; font-size: 1.8rem; color: #8B3E2F;">El amor</span>
                        que nos une ha encontrado su día para ser perpetuado. Con inmensa alegría, hemos decidido unir nuestras vidas en matrimonio. Nos encantaría que nos acompañen para ser testigos de nuestros votos y celebrar el inicio de nuestra vida juntos.
                    </p>

                    <h2 class="text-3xl md:text-4xl mt-6 mb-3 text-[#5C3A21] text-center" 
                        style="font-family: 'Allura', cursive; font-style: italic;">
                        Programa del Evento
                    </h2>

                    <ul class="list-none mb-4 text-center text-base md:text-lg space-y-2">
                        <li class="hover:text-[#8B3E2F] hover:scale-105 transition-all duration-300 py-1 border-b border-gray-200">Ceremonia matrimonial</li>
                        <li class="hover:text-[#8B3E2F] hover:scale-105 transition-all duration-300 py-1 border-b border-gray-200">Sesión fotográfica con los novios</li>
                        <li class="hover:text-[#8B3E2F] hover:scale-105 transition-all duration-300 py-1 border-b border-gray-200">Brindis de honor</li>
                        <li class="hover:text-[#8B3E2F] hover:scale-105 transition-all duration-300 py-1 border-b border-gray-200">Baile inaugural de los novios</li>
                        <li class="hover:text-[#8B3E2F] hover:scale-105 transition-all duration-300 py-1">Palabras y buenos deseos de los invitados</li>
                    </ul>

                    <div class="text-center mt-6">
                        <a href="#confirmacion"
                            class="scroll-indicator text-[#5C3A21] hover:text-[#7A4C2B] font-bold text-3xl transition duration-300">
                            <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="confirmacion" class="w-full min-h-screen p-6 md:p-12 flex flex-col items-center justify-center relative bg-blue-300/50">
        <img src="img/juntos.png" alt="Imagen de fondo sutil" 
         class="absolute inset-0 w-full h-full object-cover opacity-30"> 
        <div class="absolute inset-0 bg-gradient-to-b from-blue-500/10 via-transparent to-blue-500/20"></div>

        <div class="z-10 relative w-full max-w-7xl flex flex-col md:flex-row items-stretch justify-center gap-4">

            <div class="hidden md:flex md:w-1/5 items-center justify-center p-4">
                <img src="img/solodreiser.png" alt="Dreiser" 
                     class="h-full w-full object-cover rounded-2xl shadow-xl opacity-80"
                     style="mask-image: linear-gradient(to bottom, transparent 0%, black 20%, black 80%, transparent 100%);
                            -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 20%, black 80%, transparent 100%);">
            </div>

            <div class="w-full md:w-3/5 flex flex-col items-center justify-center space-y-8 bg-white/0 p-8 rounded-2xl shadow-2xl">

                <div class="text-center w-full">
                    <div class="text-3xl md:text-4xl font-bold text-[#5C3A21]"
                         style="font-family: 'Allura', cursive; text-shadow: 2px 2px 6px rgba(255,255,255,0.7);">
                        ¡Falta poco!
                        <div class="linea-pulsante mx-auto -mt-2 mb-4"></div> 
                    </div> 

                    <div id="countdown" 
                         class="countdown-pulsante w-full text-4xl md:text-5xl bg-white/50 p-4 rounded-xl shadow-xl transition-transform duration-200"
                         style="font-family: 'WindSong', cursive; font-weight: 500;">
                    </div> 
                </div>

                <div class="w-full h-8 md:h-12 border-b-2 border-[#5C3A21]/20"></div>

                <div class="w-full">
                                        
                    <div class="grid grid-cols-3 gap-1 relative overflow-hidden rounded-lg  w-full h-32 md:h-48 opacity-0">

                        <div class="absolute inset-0 z-10 pointer-events-none" 
                             style="background: linear-gradient(to right, rgba(255, 255, 255, 0.7) 0%, transparent 20%, transparent 80%, rgba(255, 255, 255, 0.7) 100%);">
                        </div>

                    </div>
                </div>

                <div class="w-full max-w-md mt-8">
                    <div class="w-full">
                        <form id="rsvpForm" class="flex flex-col space-y-4">
                            <label for="nombre" class="text-3xl md:text-4xl font-semibold text-[#5C3A21] border-b pb-2 text-center"
                                   style="font-family: 'Allura', cursive; font-style: italic;">Confirma tu Asistencia</label>

                            <p class="text-base md:text-lg text-[#5C3A21] text-center">
                                Con el fin de que todos podamos disfrutar plenamente de la velada, hemos decidido que esta ocasión será exclusivamente para adultos.
                            </p>

                            <select id="nombre" name="nombre"
                                    class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#5C3A21]">
                                <option value="">Seleccione su nombre</option>
                                </select>

                            <label for="asistencia" class="font-semibold text-[#5C3A21] mt-2">¿Podrás asistir?</label>
                            <select id="asistencia" name="asistencia" class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#5C3A21]">
                                <option value="">Seleccione una opción</option>
                                <option value="si">Sí, asistiré 🎉</option>
                                <option value="no">No podré asistir 😔</option>
                            </select>

                            <button type="submit" class="bg-[#5C3A21] hover:bg-[#7A4C2B] text-white font-bold py-3 px-4 rounded transition duration-300 text-lg shadow-md mt-4">
                                Confirmar Asistencia
                            </button>

                            <div id="mensaje" class="mt-4 text-center text-lg font-bold"></div>
                        </form>
                    </div>
                </div>

                <h2 class="text-2xl md:text-3xl mt-4 font-bold text-[#5C3A21]
                           drop-shadow-lg hover:scale-105 transition-transform duration-300 text-center bg-white/50 p-4 rounded-xl shadow-xl"
                    style="font-family: 'Allura', cursive; text-shadow: 2px 2px 8px rgba(0,0,0,0.2);">
                    Su presencia es el testimonio más valioso de nuestro amor
                </h2>

            </div> <div class="hidden md:flex md:w-1/5 items-center justify-center p-4">
                <img src="img/mayecopia.png" alt="Decoración lateral 2" 
                     class="h-full w-full object-cover rounded-2xl shadow-xl opacity-80"
                     style="mask-image: linear-gradient(to bottom, transparent 0%, black 20%, black 80%, transparent 100%);
                            -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 20%, black 80%, transparent 100%);">
            </div>
        </div> 
    </section>

    <script>
        const form = document.getElementById("rsvpForm");
const mensaje = document.getElementById("mensaje");
const nombreSelect = document.getElementById("nombre");
const asistenciaSelect = document.getElementById("asistencia");
const invitadosList = document.getElementById("invitadosList"); // <ul> donde se mostrará la lista
const urlParams = new URLSearchParams(window.location.search);
const codigo = urlParams.get("codigo");
let invitados = [];
let invitadoActual = null;

// ✅ Cargar invitados desde PHP
        fetch("get_invitados.php")
            .then(res => res.json())
            .then(data => {
                invitados = data;
            
                if (!codigo) {
                    mensaje.textContent = "❌ Código de invitación no proporcionado en la URL.";
                    nombreSelect.innerHTML = '<option value="">Código requerido</option>';
                    nombreSelect.disabled = true;
                    asistenciaSelect.disabled = true;
                    return;
                }
            
                const grupo = invitados.filter(inv => inv.codigo === codigo);
            
                if (grupo.length === 0) {
                    mensaje.textContent = "⚠️ Código no válido. Verifique su enlace de invitación.";
                    nombreSelect.innerHTML = '<option value="">Código no encontrado</option>';
                    nombreSelect.disabled = true;
                    asistenciaSelect.disabled = true;
                    return;
                }
            
                actualizarSelect(grupo);
                renderLista(grupo); // <-- renderizamos la lista
            })
            .catch(err => {
                console.error("Error cargando invitados:", err);
                nombreSelect.innerHTML = '<option value="">Error al cargar datos</option>';
                asistenciaSelect.disabled = true;
            });
        
            function actualizarSelect(grupo) {
            nombreSelect.innerHTML = '<option value="">Seleccione su nombre</option>';      

            grupo.forEach(inv => {
                const option = document.createElement("option");
                option.value = inv.nombre;      

                // Determinar estado según asistencia
                let estado = "";
                if (!inv.asistencia || inv.asistencia === "null") {
                    estado = ""; // no confirmado
                    option.disabled = false;
                } else if (inv.asistencia.toLowerCase() === "sí") {
                    estado = " (Ya confirmado)";
                    option.disabled = true;
                } else {
                    estado = " (No asistirá)";
                    option.disabled = true;
                }       

                option.textContent = inv.nombre + estado;
                nombreSelect.appendChild(option);
            });     

            // Verificar si todos respondieron
            const todosRespondieron = grupo.every(inv => inv.asistencia && inv.asistencia.toLowerCase() !== "");
            if (todosRespondieron) {
                mensaje.textContent = "✅ Este grupo ya respondió.";
                nombreSelect.disabled = true;
                asistenciaSelect.disabled = true;
            } else {
                nombreSelect.disabled = false;
                asistenciaSelect.disabled = false;
            }
    }

// Renderizado de lista
function renderLista(grupo) {
    if (!invitadosList) return;
    invitadosList.innerHTML = "";

    grupo.forEach(inv => {
        let estado = "";
        if (!inv.asistencia || inv.asistencia === "null") {
            estado = "❌ Pendiente";
        } else if (inv.asistencia.toLowerCase() === "sí") {
            estado = "✅ Confirmado";
        } else {
            estado = "❌ No asistirá";
        }

        const li = document.createElement("li");
        li.textContent = `${inv.nombre} - ${estado}`;
        invitadosList.appendChild(li);
    });
}
        
        // Evento al seleccionar nombre
        nombreSelect.addEventListener("change", e => {
            const nombreSeleccionado = e.target.value;
            invitadoActual = invitados.find(inv => inv.codigo === codigo && inv.nombre === nombreSeleccionado);
            if (!invitadoActual) {
                asistenciaSelect.value = "";
                return;
            }
            asistenciaSelect.value = invitadoActual.asistencia || "";
        });
        
        // Envío del formulario
        form.addEventListener("submit", e => {
            e.preventDefault();
            if (!codigo) {
                mensaje.textContent = "❌ No se encontró el código de invitación.";
                return;
            }
            const nombre = nombreSelect.value;
            if (!nombre) {
                mensaje.textContent = "⚠️ Por favor seleccione su nombre.";
                return;
            }
            const asistencia = asistenciaSelect.value;
            if (!asistencia) {
                mensaje.textContent = "⚠️ Por favor seleccione si asistirá o no.";
                return;
            }
            const formData = new FormData();
            formData.append("codigo", codigo);
            formData.append("nombre", nombre);
            formData.append("asistencia", asistencia);
        
            fetch("confirmacion.php", {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mensaje.textContent = "🎉 Gracias, " + nombre + ". Tu respuesta fue registrada correctamente.";
                    nombreSelect.querySelector(`option[value="${nombre}"]`).disabled = true;
                    nombreSelect.value = "";
                    asistenciaSelect.value = "";
                
                    // Actualizamos la lista
                    const grupo = invitados.filter(inv => inv.codigo === codigo);
                    renderLista(grupo);
                } else {
                    mensaje.textContent = "⚠️ " + (data.error || "Ocurrió un error al guardar la respuesta.");
                }
            })
            .catch(err => {
                console.error(err);
                mensaje.textContent = "❌ Error al enviar la confirmación. Intenta nuevamente.";
            });
        });

    
        // Lógica de Cuenta Regresiva
        const targetDate = new Date("November 7, 2025 18:30:00").getTime();
        const countdownElement = document.getElementById("countdown");

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate - now;
            
            if (distance < 0) {
                countdownElement.innerHTML = "¡Es hora de celebrar! 🥂";
                clearInterval(interval);
                return;
            }
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            countdownElement.innerHTML = `<span class="font-normal">${days}</span>d : <span class="font-normal">${hours}</span>h : <span class="font-normal">${minutes}</span>m : <span class="font-normal">${seconds}</span>s`;
        }
        
        updateCountdown();
        const interval = setInterval(updateCountdown, 1000);
        
    </script>
</body>
</html>