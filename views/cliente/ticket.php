<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tu Ticket - E-ticket</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-[#1a1c20] p-6 flex justify-center items-center min-h-screen">

    <div class="max-w-sm w-full bg-[#25282e] rounded-3xl overflow-hidden shadow-2xl border border-gray-800">
        <div class="relative h-48">
            <img src="/E-ticket/public/img/eventos/<?php echo $ticket['imagen_url']; ?>" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-[#25282e] to-transparent"></div>
        </div>

        <div class="p-8 text-center">
            <h2 class="text-2xl font-bold text-white mb-1"><?php echo $ticket['nombre_evento']; ?></h2>
            <p class="text-[#4ade80] font-medium mb-6"><?php echo date('d M, Y - H:i', strtotime($ticket['fecha_evento'])); ?></p>
            
            <div class="flex justify-between text-left mb-8 border-t border-b border-gray-700 py-4">
                <div>
                    <p class="text-xs text-gray-400 uppercase">Lugar</p>
                    <p class="text-sm font-bold text-white"><?php echo $ticket['lugar']; ?></p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-400 uppercase">Ticket ID</p>
                    <p class="text-sm font-bold text-white">#<?php echo str_pad($ticket['id_venta'], 6, "0", STR_PAD_LEFT); ?></p>
                </div>
            </div>
                <div class="text-center mb-4">
                        <p class="text-gray-400 text-xs uppercase">Cantidad de personas</p>
                        <p class="text-xl font-bold text-white"><?php echo $ticket['cantidad']; ?> Entradas</p>
                </div>
           <div class="bg-white p-4 inline-block rounded-2xl mb-6">
                <?php 
                    // Cambiamos el texto plano por una URL real de tu proyecto
                    // Al escanearlo, el celular del staff abrirá directamente el validador
                    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
                    $host = $_SERVER['HTTP_HOST'];
                    $urlValidacion = "$protocol://$host/E-ticket/validar/" . $ticket['id_venta'];
                    
                    $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($urlValidacion);
                ?>
                <img src="<?php echo $qrUrl; ?>" alt="QR Code" class="w-32 h-32">
            </div>

            <p class="text-xs text-gray-500 italic">Muestra este código en la entrada del evento para validar tu acceso.</p>
        </div>

        <button onclick="window.print()" class="w-full bg-gray-700 py-4 text-white font-bold hover:bg-gray-600 transition-all">
            <i class="fa-solid fa-print mr-2"></i> IMPRIMIR TICKET
        </button>
    </div>

</body>
</html>