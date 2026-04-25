
<div class="space-y-8">
    <div class="flex justify-between items-end">
        <div>
            <h1 class="text-4xl font-black text-white uppercase tracking-tighter">Panel de <span class="text-[#4ade80]">Control</span></h1>
            <p class="text-gray-400">Resumen general de tu plataforma de tickets.</p>
        </div>
        <div class="text-right">
            <span class="block text-xs font-bold text-gray-500 uppercase">Fecha Actual</span>
            <span class="text-white font-mono"><?php echo date('d / m / Y'); ?></span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-[#1e293b] p-6 rounded-3xl border border-white/5 shadow-xl">
            <p class="text-gray-500 text-[10px] font-bold uppercase mb-2">Eventos Activos</p>
            <span class="text-4xl font-black text-white"><?php echo $stats['total_eventos']; ?></span>
        </div>
        <div class="bg-[#1e293b] p-6 rounded-3xl border border-white/5 shadow-xl">
            <p class="text-gray-500 text-[10px] font-bold uppercase mb-2">Tickets Vendidos</p>
            <span class="text-4xl font-black text-[#4ade80]"><?php echo $stats['total_ventas']; ?></span>
        </div>
        <div class="bg-[#1e293b] p-6 rounded-3xl border border-white/5 shadow-xl">
            <p class="text-gray-500 text-[10px] font-bold uppercase mb-2">Ingresos Globales</p>
            <span class="text-4xl font-black text-white">$<?php echo number_format($stats['ingresos'], 0, ',', '.'); ?></span>
        </div>
    </div>

    <?php if($stats['total_eventos'] == 0): ?>
    <div class="bg-[#1e293b] border-2 border-dashed border-white/10 rounded-3xl p-12 text-center">
        <div class="bg-[#4ade80]/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#4ade80]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
        </div>
        <h3 class="text-xl font-bold text-white mb-2">No hay eventos creados</h3>
        <p class="text-gray-400 mb-6">Parece que no has empezado a generar ganancias. ¡Comienza creando tu primer evento!</p>
        <a href="/E-ticket/admin/nuevo_evento" class="inline-block bg-[#4ade80] text-black font-black px-8 py-3 rounded-2xl hover:scale-105 transition-transform uppercase text-sm">
            Crear Primer Evento
        </a>
    </div>
    <?php else: ?>
    <div class="bg-[#1e293b] rounded-3xl border border-white/5 overflow-hidden">
       <div class="bg-[#1e293b] rounded-3xl border border-white/5 overflow-hidden shadow-xl">
    <div class="p-6 border-b border-white/5 flex justify-between items-center">
        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Últimos Eventos</h3>
        <a href="/E-ticket/admin/reportes" class="text-[#4ade80] text-xs font-bold hover:underline">Ver todos</a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#0f172a]/30 text-gray-500 text-[10px] uppercase font-black">
                    <th class="p-4">Evento</th>
                    <th class="p-4 text-center">Boletas</th>
                    <th class="p-4 text-center">Ventas / Día</th>
                    <th class="p-4">Estado</th>
                    <th class="p-4 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-300">
                <?php foreach($eventos_recientes as $e): 
                    // Lógica de cálculos rápida
                    $vendidas = $e['stock_total'] - $e['stock_disponible'];
                    
                    // Cálculo de ventas por día (desde que se creó el evento)
                    $fecha_creacion = new DateTime($e['created_at']);
                    $hoy = new DateTime();
                    $dias_activo = $fecha_creacion->diff($hoy)->days ?: 1; // Mínimo 1 día para evitar división por cero
                    $ventas_por_dia = round($vendidas / $dias_activo, 1);
                    
                    // Configuración mensaje WhatsApp
                    $texto_wa = urlencode("¡No te pierdas el evento " . $e['nombre_evento'] . "! Compra tus entradas aquí: " . $_SERVER['HTTP_HOST'] . "/E-ticket/tienda/evento/" . $e['id_evento']);
                ?>
                <tr class="border-b border-white/5 hover:bg-white/5 transition-colors group">
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gray-800 overflow-hidden">
                                <img src="<?php echo $e['imagen_url']; ?>" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="font-bold text-white"><?php echo $e['nombre_evento']; ?></p>
                                <p class="text-[10px] text-gray-500"><?php echo date('d M, Y', strtotime($e['fecha_evento'])); ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="p-4 text-center">
                        <span class="font-mono font-bold text-[#4ade80]"><?php echo $vendidas; ?></span>
                        <span class="text-gray-600 text-xs">/ <?php echo $e['stock_total']; ?></span>
                    </td>
                    <td class="p-4 text-center">
                        <div class="inline-flex items-center gap-1 text-xs">
                            <span class="text-white"><?php echo $ventas_por_dia; ?>%</span>
                            <svg class="w-3 h-3 text-[#4ade80]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                    </td>
                    <td class="p-4">
                        <?php if($e['estado'] == 'activo'): ?>
                            <span class="px-2 py-1 rounded-md text-[9px] bg-[#4ade80]/10 text-[#4ade80] font-black uppercase">En Venta</span>
                        <?php else: ?>
                            <span class="px-2 py-1 rounded-md text-[9px] bg-red-500/10 text-red-500 font-black uppercase">Pausado</span>
                        <?php endif; ?>
                    </td>
                    <td class="p-4 text-right">
                        <div class="flex justify-end gap-2">
                            <a href="https://wa.me/?text=<?php echo $texto_wa; ?>" target="_blank" 
                               class="p-2 bg-green-500/10 text-green-500 rounded-lg hover:bg-green-500 hover:text-white transition-all shadow-lg" 
                               title="Compartir por WhatsApp">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </a>

                            <a href="/E-ticket/admin/detalle/<?php echo $e['id_evento']; ?>" 
                               class="p-2 bg-blue-500/10 text-blue-500 rounded-lg hover:bg-blue-500 hover:text-white transition-all shadow-lg"
                               title="Ver detalles">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
        </div>
    <?php endif; ?>
</div>