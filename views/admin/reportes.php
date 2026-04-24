<div class="space-y-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-black text-white uppercase tracking-tighter">Reporte de <span class="text-[#4ade80]">Eventos</span></h1>
            <p class="text-gray-400">Monitoreo en tiempo real de ventas y aforo.</p>
        </div>
        <a href="/E-ticket/admin/nuevo_evento" class="bg-white/5 border border-white/10 text-white px-6 py-3 rounded-2xl hover:bg-[#4ade80] hover:text-black transition-all font-bold text-sm uppercase">
            + Nuevo Evento
        </a>
    </div>

    <?php if(empty($eventos)): ?>
        <div class="bg-[#1e293b] rounded-3xl p-20 text-center border border-dashed border-white/10">
            <p class="text-gray-500 uppercase font-black tracking-widest">No hay eventos para mostrar</p>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach($eventos as $e): 
                // Cálculo de porcentaje de ventas
                $vendidos = $e['stock_total'] - $e['stock_disponible'];
                $porcentaje = ($e['stock_total'] > 0) ? ($vendidos / $e['stock_total']) * 100 : 0;
                $ingresos = $vendidos * $e['precio_boleta'];
            ?>
                <div class="bg-[#1e293b] rounded-3xl overflow-hidden border border-white/5 shadow-2xl hover:border-[#4ade80]/30 transition-all group">
                    <div class="h-40 bg-gray-800 relative">
                        <img src="<?php echo $e['imagen_url']; ?>" class="w-full h-full object-cover opacity-50 group-hover:opacity-80 transition-all" alt="Poster">
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase <?php echo $e['estado'] == 'activo' ? 'bg-[#4ade80] text-black' : 'bg-red-500 text-white'; ?>">
                                <?php echo $e['estado']; ?>
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white mb-1 truncate"><?php echo $e['nombre_evento']; ?></h3>
                        <p class="text-gray-500 text-xs mb-4"><i class="far fa-calendar"></i> <?php echo date('d M, Y', strtotime($e['fecha_evento'])); ?></p>

                        <div class="mb-4">
                            <div class="flex justify-between text-[10px] font-bold uppercase mb-1">
                                <span class="text-gray-400">Ventas: <?php echo $vendidos; ?> / <?php echo $e['stock_total']; ?></span>
                                <span class="text-[#4ade80]"><?php echo round($porcentaje); ?>%</span>
                            </div>
                            <div class="w-full bg-[#0f172a] h-2 rounded-full overflow-hidden">
                                <div class="bg-[#4ade80] h-full transition-all" style="width: <?php echo $porcentaje; ?>%"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 py-4 border-t border-white/5">
                            <div>
                                <p class="text-[10px] text-gray-500 font-bold uppercase">Recaudado</p>
                                <p class="text-white font-bold">$<?php echo number_format($ingresos, 0, ',', '.'); ?></p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-gray-500 font-bold uppercase">Precio</p>
                                <p class="text-white font-bold">$<?php echo number_format($e['precio_boleta'], 0, ',', '.'); ?></p>
                            </div>
                        </div>

                        <a href="/E-ticket/admin/asistentes_evento/<?php echo $e['id_evento']; ?>" 
                           class="block w-full text-center bg-[#0f172a] hover:bg-[#4ade80] hover:text-black text-white font-bold py-3 rounded-xl transition-all uppercase text-xs tracking-widest mt-2">
                            Ver Detalles
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>