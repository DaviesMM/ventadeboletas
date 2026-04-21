<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Finalizar Compra - E-ticket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#1a1c20] text-white p-6">
    <div class="max-w-2xl mx-auto bg-[#25282e] p-8 rounded-3xl border border-gray-800 shadow-2xl">
        <h2 class="text-3xl font-bold mb-6 text-[#4ade80]">Datos de tu Reserva</h2>
        
        <div class="flex gap-4 mb-8 bg-[#1a1c20] p-4 rounded-2xl border border-gray-700">
            <img src="/E-ticket/public/img/eventos/<?php echo $evento['imagen_url']; ?>" class="w-24 h-24 object-cover rounded-xl">
            <div>
                <h3 class="text-xl font-bold"><?php echo $evento['nombre_evento']; ?></h3>
                <p class="text-gray-400"><?php echo $evento['lugar']; ?></p>
                <p class="text-[#4ade80] font-bold text-lg">$<?php echo number_format($evento['precio_boleta'], 0); ?></p>
            </div>
        </div>

        <form action="/E-ticket/procesar-pago" method="POST" class="space-y-6">
            <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento']; ?>">
            <input type="hidden" id="precio_unitario" value="<?php echo $evento['precio_boleta']; ?>">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm text-gray-400 mb-2">Nombre Completo</label>
                    <input type="text" name="nombre" required class="w-full bg-[#1a1c20] border border-gray-700 rounded-xl p-3 outline-none focus:border-[#4ade80]">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-2">Correo Electrónico</label>
                    <input type="email" name="email" required class="w-full bg-[#1a1c20] border border-gray-700 rounded-xl p-3 outline-none focus:border-[#4ade80]">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-2">Teléfono</label>
                    <input type="text" name="telefono" class="w-full bg-[#1a1c20] border border-gray-700 rounded-xl p-3 outline-none focus:border-[#4ade80]">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-2">Cantidad de Boletas</label>
                    <input type="number" name="cantidad" id="cantidad" value="1" min="1" max="<?php echo $evento['stock_disponible']; ?>" 
                           class="w-full bg-[#1a1c20] border border-gray-700 rounded-xl p-3 outline-none focus:border-[#4ade80]"
                           onchange="recalcularTotal()">
                </div>
            </div>

            <div class="pt-6 border-t border-gray-700 flex justify-between items-center">
                <div>
                    <p class="text-gray-400 text-sm">Total a pagar:</p>
                    <p class="text-3xl font-bold text-[#4ade80]" id="total_display">$<?php echo number_format($evento['precio_boleta'], 0); ?></p>
                </div>
                <button type="submit" class="bg-[#4ade80] text-black px-8 py-4 rounded-2xl font-bold hover:scale-105 transition-transform uppercase">
                    Confirmar Compra
                </button>
            </div>
        </form>
    </div>

    <script>
        function recalcularTotal() {
            const precio = document.getElementById('precio_unitario').value;
            const cantidad = document.getElementById('cantidad').value;
            const total = precio * cantidad;
            document.getElementById('total_display').innerText = '$' + total.toLocaleString();
        }
    </script>
</body>
</html>