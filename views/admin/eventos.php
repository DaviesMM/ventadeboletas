<?php include 'layouts/header.php'; ?>
<?php include 'layouts/sidebar.php'; ?>

<!--<header class="flex justify-between items-center mb-8">
    <h3 class="text-3xl font-bold">Gestión de Eventos  </h>
    // imagen aqui
    // listado de los eventos del dia
</header> -->

<div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-bold">Gestión de Eventos</h2>
    <button onclick="document.getElementById('form-evento').classList.toggle('hidden')" class="bg-[#4ade80] text-black px-4 py-2 rounded-lg font-bold">
        <i class="fa-solid fa-plus"></i> Nuevo Evento
    </button>
</div>

<div id="form-evento" class="hidden mb-10">
    <div class="max-w-4xl bg-[#25282e] p-8 rounded-3xl border border-gray-800 shadow-xl">
    <h3 class="text-xl font-bold mb-6 text-[#4ade80]">Registrar Eventos</h3>
    
    <form action="guardar-evento" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm text-gray-400 mb-2">Nombre del Evento</label>
            <input type="text" name="nombre" required class="w-full bg-[#1a1c20] border border-gray-700 rounded-xl p-3 text-white focus:border-[#4ade80] outline-none">
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-2">Fecha y Hora</label>
            <input type="datetime-local" name="fecha" required class="w-full bg-[#1a1c20] border border-gray-700 rounded-xl p-3 text-white focus:border-[#4ade80] outline-none">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm text-gray-400 mb-2">Lugar</label>
            <input type="text" name="lugar" required class="w-full bg-[#1a1c20] border border-gray-700 rounded-xl p-3 text-white focus:border-[#4ade80] outline-none">
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-2">Precio</label>
            <input type="number" name="precio" step="0.01" required class="w-full bg-[#1a1c20] border border-gray-700 rounded-xl p-3 text-white focus:border-[#4ade80] outline-none">
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-2">Stock Total</label>
            <input type="number" name="stock" required class="w-full bg-[#1a1c20] border border-gray-700 rounded-xl p-3 text-white focus:border-[#4ade80] outline-none">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm text-gray-400 mb-2">Poster</label>
            <input type="file" name="imagen" class="w-full bg-[#1a1c20] border border-gray-700 rounded-xl p-3 text-gray-400">
        </div>
        <div class="md:col-span-2 mt-4">
            <button type="submit" class="w-full bg-[#4ade80] text-black font-bold py-4 rounded-xl hover:bg-[#3bc771] transition-all">
                GUARDAR EVENTO
            </button>
        </div>
    </form>
</div>
</div>

<div class="bg-[#25282e] rounded-3xl border border-gray-800 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#1a1c20] text-gray-400 uppercase text-xs">
                    <th class="p-4">Evento</th>
                    <th class="p-4">Fecha</th>
                    <th class="p-4">Precio</th>
                    <th class="p-4">Ventas</th>
                    <th class="p-4">Estado</th>
                    <th class="p-4">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                <?php foreach($eventos as $ev): ?>
                <tr class="hover:bg-[#1a1c20] transition-colors">
                    <td class="p-4 flex items-center gap-3">
                        <img src="/E-ticket/public/img/eventos/<?php echo $ev['imagen_url']; ?>" class="w-12 h-12 rounded-lg object-cover bg-gray-700">
                        <span class="font-bold"><?php echo $ev['nombre_evento']; ?></span>
                    </td>
                    <td class="p-4 text-sm"><?php echo date('d M, Y', strtotime($ev['fecha_evento'])); ?></td>
                    <td class="p-4 font-mono text-[#4ade80]">$<?php echo number_format($ev['precio_boleta'], 0); ?></td>
                    <td class="p-4 text-sm">
                        <?php echo ($ev['stock_total'] - $ev['stock_disponible']); ?> / <?php echo $ev['stock_total']; ?>
                    </td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase <?php echo $ev['estado'] == 'activo' ? 'bg-green-500/10 text-green-500' : 'bg-yellow-500/10 text-yellow-500'; ?>">
                            <?php echo $ev['estado']; ?>
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="flex gap-2">
                            <button class="text-gray-400 hover:text-white"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="text-gray-400 hover:text-red-500"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'layouts/footer.php'; ?>
<!--- vamos guardar estos para probar como funciona lo nuevo 
<div class="max-w-4xl bg-[#25282e] p-8 rounded-3xl border border-gray-800 shadow-xl">
    <h3 class="text-xl font-bold mb-6 text-[#4ade80]">Registrar Eventos</h3>
    
    <form action="guardar-evento" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm text-gray-400 mb-2">Nombre del Evento</label>
            <input type="text" name="nombre" required class="w-full bg-[#1a1c20] border border-gray-700 rounded-xl p-3 text-white focus:border-[#4ade80] outline-none">
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-2">Fecha y Hora</label>
            <input type="datetime-local" name="fecha" required class="w-full bg-[#1a1c20] border border-gray-700 rounded-xl p-3 text-white focus:border-[#4ade80] outline-none">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm text-gray-400 mb-2">Lugar</label>
            <input type="text" name="lugar" required class="w-full bg-[#1a1c20] border border-gray-700 rounded-xl p-3 text-white focus:border-[#4ade80] outline-none">
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-2">Precio</label>
            <input type="number" name="precio" step="0.01" required class="w-full bg-[#1a1c20] border border-gray-700 rounded-xl p-3 text-white focus:border-[#4ade80] outline-none">
        </div>
        <div>
            <label class="block text-sm text-gray-400 mb-2">Stock Total</label>
            <input type="number" name="stock" required class="w-full bg-[#1a1c20] border border-gray-700 rounded-xl p-3 text-white focus:border-[#4ade80] outline-none">
        </div>
        <div class="md:col-span-2">
            <label class="block text-sm text-gray-400 mb-2">Poster</label>
            <input type="file" name="imagen" class="w-full bg-[#1a1c20] border border-gray-700 rounded-xl p-3 text-gray-400">
        </div>
        <div class="md:col-span-2 mt-4">
            <button type="submit" class="w-full bg-[#4ade80] text-black font-bold py-4 rounded-xl hover:bg-[#3bc771] transition-all">
                GUARDAR EVENTO
            </button>
        </div>
    </form>
</div> -->

