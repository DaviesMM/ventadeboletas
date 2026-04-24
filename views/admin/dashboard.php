
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
        <div class="p-6 border-b border-white/5">
            <h3 class="text-sm font-bold text-gray-400 uppercase">Últimos Eventos</h3>
        </div>
        </div>
    <?php endif; ?>
</div>