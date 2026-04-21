<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>E-ticket | Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#1a1c20] text-white font-sans p-6">

    <div class="max-w-xl mx-auto mt-10">
        <a href="/E-ticket/" class="text-gray-400 hover:text-[#4ade80] mb-6 inline-block">← Volver</a>
        
        <div class="bg-[#25282e] p-8 rounded-3xl border border-gray-800 shadow-2xl">
            <h2 class="text-2xl font-bold mb-6 text-[#4ade80]">Resumen de tu Compra</h2>
            
            <div class="flex gap-4 mb-8">
                <img src="/E-ticket/public/img/eventos/<?php echo $evento['imagen_url']; ?>" class="w-24 h-24 rounded-xl object-cover">
                <div>
                    <h3 class="text-xl font-bold"><?php echo $evento['nombre_evento']; ?></h3>
                    <p class="text-gray-400 text-sm"><?php echo $evento['lugar']; ?></p>
                    <p class="text-[#4ade80] font-bold mt-2">$<?php echo number_format($evento['precio_boleta'], 0); ?></p>
                </div>
            </div>

            <form action="/E-ticket/procesar-pago" method="POST" class="space-y-4">
                <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento']; ?>">
                <input type="hidden" name="precio" value="<?php echo $evento['precio_boleta']; ?>">

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Nombre del Asistente</label>
                    <input type="text" name="nombre_cliente" required class="w-full bg-[#1a1c20] border border-gray-700 rounded-xl p-3 outline-none focus:border-[#4ade80]">
                </div>

                <div>
                    <label class="block text-sm text-gray-400 mb-1">Correo Electrónico</label>
                    <input type="email" name="email_cliente" required class="w-full bg-[#1a1c20] border border-gray-700 rounded-xl p-3 outline-none focus:border-[#4ade80]">
                </div>

                <button type="submit" class="w-full bg-[#4ade80] text-black font-bold py-4 rounded-xl mt-6 hover:scale-[1.02] transition-transform uppercase">
                    Confirmar y Pagar
                </button>
            </form>
        </div>
    </div>
</body>
</html>