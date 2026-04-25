<div class="space-y-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <a href="/E-ticket/admin/reportes" class="text-[#4ade80] text-xs font-bold uppercase tracking-widest hover:underline">← Volver a Reportes</a>
            <h1 class="text-3xl font-black text-white uppercase mt-2"><?php echo $evento['nombre_evento']; ?></h1>
        </div>
        <div class="flex gap-3">
            <button onclick="confirmarEliminacion(<?php echo $evento['id_evento']; ?>)" class="bg-red-500/10 border border-red-500/20 text-red-500 px-4 py-2 rounded-xl hover:bg-red-500 hover:text-white transition-all text-xs font-bold">
                ELIMINAR EVENTO
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-[#1e293b] p-6 rounded-3xl border border-white/5 shadow-xl">
                <h3 class="text-[#4ade80] text-sm font-bold uppercase mb-6">Modificar Datos</h3>
                <form action="/E-ticket/admin/actualizar_evento" method="POST" class="space-y-4">
                    <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento']; ?>">
                    
                    <div>
                        <label class="block text-[10px] text-gray-500 font-bold uppercase mb-1">Precio actual</label>
                        <input type="number" name="precio" value="<?php echo $evento['precio_boleta']; ?>" class="w-full bg-[#0f172a] border border-white/10 rounded-lg px-3 py-2 text-white text-sm">
                    </div>
                    
                    <div>
                        <label class="block text-[10px] text-gray-500 font-bold uppercase mb-1">Estado</label>
                        <select name="estado" class="w-full bg-[#0f172a] border border-white/10 rounded-lg px-3 py-2 text-white text-sm">
                            <option value="activo" <?php echo $evento['estado'] == 'activo' ? 'selected' : ''; ?>>Activo / Publicado</option>
                            <option value="pausado" <?php echo $evento['estado'] == 'pausado' ? 'selected' : ''; ?>>Pausado</option>
                            <option value="finalizado" <?php echo $evento['estado'] == 'finalizado' ? 'selected' : ''; ?>>Finalizado</option>
                        </select>
                    </div>

                    <button class="w-full bg-white/5 hover:bg-white/10 text-white font-bold py-3 rounded-xl transition-all text-xs uppercase border border-white/10">
                        Guardar Cambios
                    </button>
                </form>
            </div>

            <div class="bg-gradient-to-br from-[#4ade80]/20 to-transparent p-6 rounded-3xl border border-[#4ade80]/20 shadow-xl">
                <h3 class="text-white text-sm font-bold uppercase mb-2">Evento Especial</h3>
                <p class="text-gray-400 text-xs mb-4">Activa esta opción para destacar este evento en la parte superior de la tienda.</p>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer">
                    <div class="w-11 h-6 bg-[#0f172a] peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-gray-300 after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#4ade80]"></div>
                    <span class="ml-3 text-xs font-bold text-gray-300 uppercase">Destacar</span>
                </label>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="bg-[#1e293b] rounded-3xl border border-white/5 overflow-hidden shadow-xl">
                <div class="p-6 border-b border-white/5 flex justify-between items-center">
                    <h3 class="text-sm font-bold text-white uppercase tracking-widest">Lista de Compradores</h3>
                    <span class="text-[10px] bg-[#4ade80]/10 text-[#4ade80] px-2 py-1 rounded">Total: <?php echo count($compradores); ?></span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#0f172a]/50 text-gray-500 text-[10px] uppercase font-black">
                                <th class="p-4">Cliente</th>
                                <th class="p-4">Cantidad</th>
                                <th class="p-4">Total</th>
                                <th class="p-4">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-300">
                            <?php if(empty($compradores)): ?>
                                <tr>
                                    <td colspan="4" class="p-10 text-center text-gray-600 italic">No hay ventas registradas para este evento todavía.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($compradores as $v): ?>
                                <tr class="border-b border-white/5 hover:bg-white/5 transition-colors">
                                    <td class="p-4 font-bold">Cliente #<?php echo $v['id_usuario']; ?></td>
                                    <td class="p-4"><?php echo $v['cantidad']; ?></td>
                                    <td class="p-4 text-[#4ade80]">$<?php echo number_format($v['total'], 0); ?></td>
                                    <td class="p-4">
                                        <span class="px-2 py-1 rounded-md text-[10px] bg-blue-500/10 text-blue-400 font-bold uppercase">Confirmado</span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmarEliminacion(id) {
    if(confirm('¿Estás seguro de que deseas eliminar este evento? Esta acción no se puede deshacer.')) {
        window.location.href = '/E-ticket/admin/eliminar_evento/' + id;
    }
}
</script>