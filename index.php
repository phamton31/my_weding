<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Invitación de Boda</title>
    <!-- Fuentes -->
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&family=Great+Vibes&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Windsong&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&family=UnifrakturCook:wght@700&family=WindSong:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 to-blue-300 flex items-center justify-center min-h-screen">

    <!-- Contenedor principal -->
    <div class="relative w-full max-w-5xl h-screen mx-auto p-10">

        <!-- Imagen del marco -->
        <div class="absolute inset-0 flex items-center justify-center z-10 pointer-events-none">
            <img src="img/marco.jpg" alt="Marco de invitación"
                 class="w-auto h-full max-w-full max-h-full opacity-70"
                 style="mask-image: linear-gradient(to right, transparent 0%, black 20%, black 80%, transparent 100%);
                        -webkit-mask-image: linear-gradient(to right, transparent 0%, black 20%, black 80%, transparent 100%);
                        mask-repeat: no-repeat;
                        mask-position: center;
                        mask-size: cover;">
        </div>

        <!-- Imágenes de las esquinas -->
        <img src="img/esquina1.jpg" alt="Esquina 1" class="absolute top-0 left-0 w-20 h-20 md:w-32 md:h-32">
        <img src="img/esquina2.jpg" alt="Esquina 2" class="absolute top-0 right-0 w-20 h-20 md:w-32 md:h-32">
        <img src="img/esquina3.jpg" alt="Esquina 3" class="absolute bottom-0 left-0 w-20 h-20 md:w-32 md:h-32">
        <img src="img/esquina4.jpg" alt="Esquina 4" class="absolute bottom-0 right-0 w-20 h-20 md:w-32 md:h-32">
        <!-- Cambia cada src a tu carpeta de imágenes -->

        <!-- Contenido principal -->
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center pointer-events-auto z-20 space-y-6 bg-blue-300/35 p-4 rounded-lg">

            <!-- Título principal -->
            <h1 class="text-7xl md:text-8xl text-yellow-700/80"
                style="font-family: 'Windsong', cursive; color: #5C3A21;">
                Nos Casamos
            </h1>
            <!-- Nombres y espacio para anillos -->
            <div class="flex flex-col items-center justify-center space-y-4">
                <div class="flex flex-col items-center justify-center">
                    <!-- Dreiser Morales -->
                    <div class="">
                        <p class="text-5xl md:text-6xl mb-2" style="font-family: 'Playfair Display', serif; color: #5C3A21;">Dreiser</p>
                        <p class="text-6xl md:text-7xl" style="font-family: 'Windsong', cursive; color: #5C3A21;">Morales</p>
                    </div>

                    <!-- Imagen de anillos -->
                    <div class="-mt-12">
                        <img src="img/anillos.png" alt="Anillos" class="w-24 md:w-24 mx-auto">
                    </div>

                    <!-- Mayerly Florez -->
                    <div class="-mt-8">
                        <p class="text-5xl md:text-6xl mb-2" style="font-family: 'Playfair Display', serif; color: #5C3A21;">Mayerly</p>
                        <p class="text-6xl md:text-7xl" style="font-family: 'Windsong', cursive; color: #5C3A21;">Florez</p>
                    </div>
                </div>
            </div>

            <!-- Fecha del evento con día destacado -->
            <div class="text-center mt-6 flex flex-col items-center justify-center">
                <!-- Día y hora -->
                <p class="text-2xl md:text-3xl mb-2 border-b-4 border-[#5C3A21]/70 pb-2" style="font-family: 'Playfair Display', serif; color: #5C3A21;">
                    Viernes 
                    <!-- Número destacado -->
                    <span class="inline-block text-5xl md:text-6xl font-bold rounded-full bg-white/0 px-6 py-6 mx-2" style="color: #5C3A21;">
                        7
                    </span> 
                    6:30 PM
                </p>

                <!-- Mes debajo del 7, centrado -->
                <p class="text-2xl md:text-3xl -mt-2" style="font-family: 'Playfair Display', serif; color: #5C3A21;">
                    Noviembre
                </p>
            </div>

            <!-- Dirección y botón -->
            <div class="mt-4 flex flex-col items-center space-y-3">
                <p class="text-xl md:text-2xl" style="font-family: 'Playfair Display', serif; color: #5C3A21;">
                    Bariio Aeropuerto: <span class="">Calle 15 # 4 - 10 </span>
                </p>
                <a href="bienvenida.php"
                   class="bg-[#5C3A21]/80 hover:bg-[#5C3A21] text-white font-bold py-2 px-6 rounded-lg shadow-lg transition duration-300"
                   style="font-family: 'Playfair Display', cursive;">
                   CONTINUAR
                </a>
            </div>
        </div>
    </div>
</body>
</html>
