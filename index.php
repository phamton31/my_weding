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
<html lang="es" class="scroll-smooth">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Información general -->
    <title>Te invitamos a Nuestra Boda | Dreiser & Mayerly 💍</title>
    <meta name="description" content="Acompáñanos en este día tan especial. Confirma tu asistencia y descubre todos los detalles de nuestra boda.">

    <!-- Open Graph para redes sociales -->
    <meta property="og:title" content="Invitación de Boda - Dreiser & Mayerly 💌">
    <meta property="og:description" content="Únete a nuestra celebración y vive con nosotros este momento inolvidable.">
    <meta property="og:image" content="https://my-weding.onrender.com/img/preview.png"> <!-- imagen que se mostrará -->
    <meta property="og:url" content="https://my-weding.onrender.com/">
    <meta property="og:type" content="website">

    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&family=Great+Vibes&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Windsong&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&family=UnifrakturCook:wght@700&family=WindSong:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Allura&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="img/anillos.png">

    
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Playfair Display', serif;
            /* El degradado de fondo principal del body ahora se encarga de la consistencia */
            background-attachment: fixed; /* Esto hace que el degradado del body se mueva suavemente */
        }
        #countdown {
          margin-top: 0 !important;
          padding-top: 0 !important;
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
            50% { transform: scale(1.08); opacity: 0.95; } /* Pulso sutil en el reloj */
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
           
            /* Contenedor de las flores */
            .flower {
                position: fixed;
                top: -10px;
                font-size: 24px;
                pointer-events: none;
                animation: fall linear forwards;
                z-index: 9999;
            }
        
            @keyframes fall {
                0% {
                  transform: translateY(0) rotate(0deg);
                  opacity: 1;
                }
                100% {
                  transform: translateY(100vh) rotate(360deg);
                  opacity: 0;
                }
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
                           class="scroll-indicator bg-[#5C3A21]/80 hover:bg-[#5C3A21] text-white font-bold py-2 px-6 rounded-lg shadow-lg transition duration-300 mt-4 flex items-center justify-center space-x-2"
                           style="font-family: 'Playfair Display', cursive;">
                            <span>CONFIRMAR ASISTENCIA</span>
                            <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative bg-[url('img/sobres.png')] bg-cover bg-center bg-no-repeat w-screen h-[205px] bg-opacity-70 text-center">
        <!-- Capa semitransparente -->
        <div class="absolute inset-0 bg-blue-300/30"></div>
              
        <!-- Texto centrado -->
        <h2 class="absolute inset-0 flex items-center justify-center text-8xl text-[#5C3A21] w-[600px] m-auto" style="font-family: 'Allura', cursive; font-style: italic;">
          Lluvia de sobres
        </h2>
    </section>

    <section id="confirmacion" class="w-full min-h-screen p-6 md:p-12 flex flex-col items-center justify-center relative bg-blue-300/50">
        <div class="absolute inset-0 bg-gradient-to-b from-blue-500/10 via-transparent to-blue-500/20"></div>

        <div class="z-10 relative w-full max-w-7xl flex flex-col md:flex-row items-stretch justify-center gap-4">

            <div class="hidden md:flex md:w-1/5 items-center justify-center p-4">
                <img src="img/solodreiser.png" alt="Dreiser" 
                     class="h-full w-full object-cover rounded-2xl shadow-xl opacity-80"
                     style="mask-image: linear-gradient(to bottom, transparent 0%, black 20%, black 80%, transparent 100%);
                            -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 20%, black 80%, transparent 100%);">
            </div>

            <div class="relative w-full md:w-3/5 flex flex-col items-center justify-center space-y-8 p-8 rounded-2xl shadow-2xl bg-[url('img/juntos.png')] bg-center bg-no-repeat bg-auto">
                <div class="absolute inset-0 bg-white/40 rounded-2xl pointer-events-none"></div>
                    <div class="relative z-10 w-full">
                    <div class="text-center w-full">
                        <div class="text-3xl md:text-4xl font-bold text-[#5C3A21]"
                             style="font-family: 'Allura', cursive; text-shadow: 2px 2px 6px rgba(255,255,255,0.7);">
                            ¡Falta poco!
                            <div class="linea-pulsante mx-auto -mt-2 mb-4 relative"></div> 
                        </div> 

                        <div id="countdown" 
                             class="countdown-pulsante w-full text-5xl bg-white/50 pt-8 rounded-xl shadow-xl transition-transform duration-200"
                             style="font-family: 'WindSong', cursive; font-weight: 400;">
                        </div> 

                    </div>

                    <div class="w-full h-32 md:h-12 border-b-2 border-[#5C3A21]/20"></div>

                    <div class="w-full">

                        <div class="grid grid-cols-3 gap-1 relative overflow-hidden rounded-lg  w-full h-32 md:h-48 opacity-0">

                            <div class="absolute inset-0 z-10 pointer-events-none" 
                                 style="background: linear-gradient(to right, rgba(255, 255, 255, 0.7) 0%, transparent 20%, transparent 80%, rgba(255, 255, 255, 0.7) 100%);">
                            </div>

                        </div>
                    </div>

                    <div class="w-full bg-white/30 p-2 rounded-2xl text-center">
                        <div class="w-full">
                            <label for="nombre" class="text-6xl text-[#5C3A21] border-b mb-2 w-[600px]" style="font-family: 'Allura', cursive; font-style: italic;">
                                Confirma tu Asistencia
                            </label>
                            <p class="text-2xl text-black text-center m-4" style="font-family: 'Playfair Display', serif;">
                                <span style="font-style: italic; font-size: 1.9rem; display: inline-block;">
                                    <?= htmlspecialchars($invitado['nombre']) ?>
                                </span><br>
                                Con el fin de que todos podamos disfrutar plenamente de la velada, hemos decidido que esta ocasión será exclusivamente para adultos.
                            </p>
                            <?php if ($invitado['confirmado']): ?>
                                <p class="text-center font-semibold text-[#5C3A21] text-xl p-4">
                                    Gracias por responder <strong><?= htmlspecialchars($invitado['asistencia']) ?></strong> a nuestra invitacion
                                </p>
                            <?php else: ?>
                                <form method="POST" class="mt-4 text-center text-xl max-w-xs mx-auto">
                                    <p class="mb-4 text-[#5C3A21] font-semibold m-auto">¿Asistirás a la boda?</p>
                                    <div class="flex "> 
                                        <label class="flex items-center space-x-2 justify-center">
                                            <input type="radio" name="asistencia" value="si" required class="form-radio">
                                            <span class="text-[#5C3A21] font-semibold">Sí, asistiré 🎉</span>
                                        </label>
                                        <label class="flex items-center space-x-2 justify-center">
                                            <input type="radio" name="asistencia" value="no" required class="form-radio">
                                            <span class="text-[#5C3A21] font-semibold">No podré asistir 😔</span>
                                        </label>
                                    </div>
                                    <button type="submit" class="bg-[#5C3A21] hover:bg-[#7A4C2B] text-white font-bold py-3 px-6 rounded transition duration-300 text-lg shadow-md mx-auto block mt-6">
                                        Enviar Respuesta
                                    </button>
                                </form>
                            <?php endif; ?>
                            
                            <?php if ($mensaje): ?>
                                <div class="mensaje mt-4 text-center text-lg font-bold text-[#5C3A21]">
                                    <?= htmlspecialchars($mensaje) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <h2 class="text-2xl md:text-5xl mt-4 text-[#5C3A21]
                               drop-shadow-lg hover:scale-105 transition-transform duration-300 text-center bg-white/50 p-4 rounded-xl shadow-xl"
                        style="font-family: 'Allura', cursive; text-shadow: 2px 2px 8px rgba(0,0,0,0.2);">
                        Su presencia es el testimonio más valioso de nuestro amor
                    </h2>
                </div>                   
            </div> <div class="hidden md:flex md:w-1/5 items-center justify-center p-4">
                <img src="img/mayecopia.png" alt="Decoración lateral 2" 
                     class="h-full w-full object-cover rounded-2xl shadow-xl opacity-80"
                     style="mask-image: linear-gradient(to bottom, transparent 0%, black 20%, black 80%, transparent 100%);
                            -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 20%, black 80%, transparent 100%);">
            </div>
        </div> 
    </section>

    <audio id="musica" loop>
        <source src="audio/all-of-me.mp3" type="audio/mpeg">
    </audio>

    <script>

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

        // Función para crear una flor
        function createFlower() {
            const flower = document.createElement('div');
            flower.classList.add('flower');
            flower.innerHTML = '💮'; // puedes cambiar por 🌺, 🌷, ❄️ etc.
            
            // posición horizontal aleatoria
            flower.style.left = Math.random() * 100 + 'vw';
            flower.style.animationDuration = (5 + Math.random() * 5) + 's'; // velocidad variable
            flower.style.fontSize = (16 + Math.random() * 20) + 'px'; // tamaño variable
            
            document.body.appendChild(flower);
            
            // eliminar la flor después de la animación
            setTimeout(() => {
              flower.remove();
            }, 10000);
        }

        // Crear flores constantemente
        // setInterval(createFlower, 300);  cada 0.3 segundos aparece una nueva

        // Espera la primera interacción del usuario
        document.addEventListener("click", function() {
            const audio = document.getElementById("musica");
            audio.play().catch(err => console.log("Autoplay bloqueado:", err));
        }, { once: true });
        
    </script>

</body>
</html>