<div class="max-w-7xl mx-auto px-4 py-12">
    <div class="mb-12 text-center">
        <h1 class="text-5xl font-black text-white uppercase tracking-tighter mb-4">
            Vive la <span class="text-[#4ade80]">Experiencia</span>
        </h1>
        <p class="text-gray-400">Encuentra y asegura tus entradas para los mejores eventos.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach($eventos as $e): ?>
        <div class="bg-[#1e293b] rounded-[2rem] overflow-hidden border border-white/5 group hover:border-[#4ade80]/50 transition-all shadow-2xl">
            <div class="h-64 relative overflow-hidden">
                <img src="<?php echo $e['imagen_url']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute top-4 left-4 bg-black/60 backdrop-blur-md px-4 py-2 rounded-2xl border border-white/10">
                    <p class="text-[#4ade80] font-black text-xl">$<?php echo number_format($e['precio_boleta'], 0); ?></p>
                </div>
            </div>

            <div class="p-8">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-2xl font-bold text-white mb-1"><?php echo $e['nombre_evento']; ?></h3>
                        <p class="text-gray-500 text-sm italic"><?php echo $e['lugar']; ?></p>
                    </div>
                </div>

                <div class="flex items-center gap-4 mb-6">
                    <div class="text-center bg-[#0f172a] px-3 py-2 rounded-xl border border-white/5">
                        <p class="text-[10px] text-gray-500 uppercase font-bold">Fecha</p>
                        <p class="text-white text-xs font-bold"><?php echo date('d M', strtotime($e['fecha_evento'])); ?></p>
                    </div>
                    <div class="text-center bg-[#0f172a] px-3 py-2 rounded-xl border border-white/5">
                        <p class="text-[10px] text-gray-500 uppercase font-bold">Disponibles</p>
                        <p class="text-[#4ade80] text-xs font-bold"><?php echo $e['stock_disponible']; ?></p>
                    </div>
                </div>

                <a href="/E-ticket/evento/detalle/<?php echo $e['id_evento']; ?>" 
                   class="block w-full text-center bg-[#4ade80] text-black font-black py-4 rounded-2xl hover:shadow-[0_0_20px_rgba(74,222,128,0.4)] transition-all uppercase text-sm tracking-widest">
                    Comprar Tickets
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>