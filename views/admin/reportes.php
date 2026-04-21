<?php include 'layouts/header.php'; ?>
<?php include 'layouts/sidebar.php'; ?>

<div class="p-8">
    
    <div class="p-8">
    <h1 class="text-4xl font-black text-white uppercase mb-2">Monitor de <span class="text-[#4ade80]">Eventos</span></h1>
    <p class="text-gray-400 mb-10">Estado individual de ventas y aforo por cada espectáculo.</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach($eventos as $e): 
            $vendidos = $e['vendidos'] ?? 0;
            $stock = $e['stock_total'];
            $disponibles = $stock - $vendidos;
            $porcentajeVenta = ($stock > 0) ? round(($vendidos / $stock) * 100) : 0;
            $ingresados = $e['ingresados'] ?? 0;
        ?>
        <div class="bg-[#1e293b] rounded-3xl border border-white/5 p-6 hover:border-[#4ade80]/50 transition-all group">
            <div class="flex justify-between items-start mb-4">
                <h3 class="text-xl font-bold text-white group-hover:text-[#4ade80] transition-colors"><?php echo $e['nombre_evento']; ?></h3>
                <span class="bg-black/40 text-[10px] text-gray-400 px-2 py-1 rounded-lg uppercase font-black">ID #<?php echo $e['id_evento']; ?></span>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-black/20 p-3 rounded-2xl">
                    <p class="text-[10px] text-gray-500 uppercase font-bold">Vendidas</p>
                    <p class="text-xl font-black text-white"><?php echo $vendidos; ?></p>
                </div>
                <div class="bg-black/20 p-3 rounded-2xl border border-red-500/10">
                    <p class="text-[10px] text-gray-500 uppercase font-bold">Faltan / Stock</p>
                    <p class="text-xl font-black text-red-400"><?php echo $disponibles; ?> <span class="text-[10px] text-gray-600">/ <?php echo $stock; ?></span></p>
                </div>
            </div>

            <div class="mb-6">
                <div class="flex justify-between text-[10px] uppercase font-bold mb-2">
                    <span class="text-gray-400">Progreso de Ventas</span>
                    <span class="text-[#4ade80]"><?php echo $porcentajeVenta; ?>%</span>
                </div>
                <div class="w-full bg-black/40 h-3 rounded-full overflow-hidden border border-white/5">
                    <div class="bg-gradient-to-r from-[#4ade80] to-[#22c55e] h-full transition-all duration-1000" style="width: <?php echo $porcentajeVenta; ?>%"></div>
                </div>
            </div>

            <a href="/E-ticket/admin/asistentes_evento/<?php echo $e['id_evento']; ?>" 
               class="block w-full text-center bg-white/5 hover:bg-[#4ade80] text-white hover:text-black font-black py-3 rounded-xl transition-all uppercase text-xs tracking-widest">
                Ver Listado de Clientes
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</div>