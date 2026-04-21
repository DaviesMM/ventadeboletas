<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#1a1c20] text-white font-sans">
    
    <nav class="p-6 border-b border-gray-700 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-[#4ade80]">E-ticket</h1>
        <div class="space-x-4">
            <a href="#" class="hover:text-[#4ade80]">Eventos</a>
            <a href="admin" class="bg-[#4ade80] text-black px-4 py-2 rounded-lg font-bold">Admin</a>
        </div>
    </nav>
    <?php if(isset($_GET['compra']) && $_GET['compra'] == 'exitosa'): ?>
        <div class="max-w-6xl mx-auto mt-6 px-6">
            <div class="bg-green-500/10 border border-green-500 text-green-500 p-4 rounded-2xl flex items-center gap-3 animate-bounce">
                <i class="fa-solid fa-circle-check text-xl"></i>
                <p class="font-bold">¡Pago procesado con éxito! Tu e-ticket ha sido generado.</p>
            </div>
        </div>
    <?php endif; ?>
    <main class="max-w-6xl mx-auto mt-12 px-6">
    <h2 class="text-4xl font-bold mb-8 text-white">Próximos Eventos</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php foreach($eventos as $evento): ?>
        <div class="bg-[#25282e] rounded-3xl border border-gray-800 overflow-hidden hover:border-[#4ade80] transition-all group">
            <div class="h-64 overflow-hidden">
                <img src="/E-ticket/public/img/eventos/<?php echo $evento['imagen_url']; ?>" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                     alt="<?php echo $evento['nombre_evento']; ?>">
            </div>
            
            <div class="p-6">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-xl font-bold text-white"><?php echo $evento['nombre_evento']; ?></h3>
                    <span class="text-[#4ade80] font-mono font-bold">$<?php echo number_format($evento['precio_boleta'], 0); ?></span>
                </div>
                
                <p class="text-gray-400 text-sm mb-4">
                    <i class="fa-solid fa-location-dot"></i> <?php echo $evento['lugar']; ?> <br>
                    <i class="fa-solid fa-calendar"></i> <?php echo date('d M, Y - H:i', strtotime($evento['fecha_evento'])); ?>
                </p>

                <a href="comprar/<?php echo $evento['id_evento']; ?>" class="block w-full text-center bg-[#4ade80] text-black py-3 rounded-xl font-bold uppercase tracking-widest hover:bg-[#3bc771] transition-colors">
                    Comprar Ticket
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</main>

</body>
</html>