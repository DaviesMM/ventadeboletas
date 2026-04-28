<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-black text-white uppercase tracking-tighter">Validación de <span class="text-[#4ade80]">Pagos</span></h1>
        <p class="text-gray-400">Revisa los comprobantes y aprueba el ingreso de dinero.</p>
    </div>

    <div class="bg-[#1e293b] rounded-3xl border border-white/5 overflow-hidden shadow-2xl">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-[#0f172a]/50 text-gray-500 text-[10px] uppercase font-black">
                    <th class="p-4">Cliente</th>
                    <th class="p-4">Evento</th>
                    <th class="p-4">Monto</th>
                    <th class="p-4">Referencia</th>
                    <th class="p-4">Comprobante</th>
                    <th class="p-4 text-right">Acción</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-300">
                <?php foreach($pagos as $p): ?>
                <tr class="border-b border-white/5 hover:bg-white/5 transition-all">
                    <td class="p-4">
                        <p class="font-bold text-white"><?php echo $p['nombre_cliente']; ?></p>
                        <p class="text-[10px] text-gray-500"><?php echo $p['email_cliente']; ?></p>
                    </td>
                    <td class="p-4 text-xs"><?php echo $p['nombre_evento']; ?></td>
                    <td class="p-4 font-bold text-[#4ade80]">$<?php echo number_format($p['total'], 0); ?></td>
                    <td class="p-4 font-mono text-xs"><?php echo $p['referencia_pago'] ?? 'Sin referencia'; ?></td>
                    <td class="p-4">
                        <button onclick="verImagen('<?php echo '/E-ticket/' . $p['comprobante']; ?>')" 
                                class="text-[10px] bg-white/5 border border-white/10 px-3 py-1 rounded-lg hover:bg-[#4ade80] hover:text-black transition-all font-bold">
                            VER IMAGEN
                        </button>
                    </td>
                    <td class="p-4 text-right">
                        <form action="/E-ticket/admin/aprobar_pago" method="POST">
                            <input type="hidden" name="id_venta" value="<?php echo $p['id_venta']; ?>">
                            <button type="submit" class="bg-[#4ade80]/10 text-[#4ade80] border border-[#4ade80]/20 px-4 py-2 rounded-xl text-[10px] font-black hover:bg-[#4ade80] hover:text-black transition-all">
                                APROBAR PAGO
                            </button>
                        </form>
                        <button onclick="prepararRechazo(<?php echo $p['id_venta']; ?>)" class="bg-red-500/10 text-red-500 border border-red-500/20 px-4 py-2 rounded-xl text-[10px] font-black hover:bg-red-500 hover:text-white transition-all">
                            RECHAZAR PAGO
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
    <?php if(isset($_GET['success'])): ?>
    <div class="bg-[#4ade80]/10 border border-[#4ade80]/20 text-[#4ade80] p-4 rounded-2xl mb-6 text-xs font-bold uppercase tracking-widest animate-bounce">
        ✅ Pago aprobado correctamente. Las boletas han sido habilitadas.
    </div>
<?php endif; ?>
</div>

<div id="modalImagen" class="fixed inset-0 bg-black/90 z-50 hidden flex items-center justify-center p-4">
    <div class="max-w-3xl w-full">
        <img id="imgComprobante" src="" class="w-full h-auto rounded-2xl shadow-2xl border border-white/10">
        <button onclick="cerrarModal()" class="mt-4 w-full bg-red-500 text-white font-bold py-3 rounded-xl">CERRAR</button>
    </div>
</div>
<div id="modalRechazo" class="fixed inset-0 bg-black/80 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-[#1e293b] p-8 rounded-[2rem] border border-white/10 max-w-md w-full">
        <h2 class="text-white font-black uppercase mb-4">Rechazar Pago</h2>
        <form action="/E-ticket/admin/rechazar_pago" method="POST" class="space-y-4">
            <input type="hidden" name="id_venta" id="id_rechazo">
            <div>
                <label class="block text-[10px] text-gray-500 font-bold uppercase mb-2">Motivo del rechazo</label>
                <textarea name="motivo" required class="w-full bg-[#0f172a] border border-white/10 rounded-xl p-4 text-white text-sm" placeholder="Ej: El comprobante no es legible..."></textarea>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="cerrarRechazo()" class="flex-1 px-4 py-3 text-xs font-bold text-gray-400">CANCELAR</button>
                <button type="submit" class="flex-1 bg-red-500 text-white font-bold py-3 rounded-xl text-xs">CONFIRMAR RECHAZO</button>
            </div>
        </form>
    </div>
</div>

<script>
function prepararRechazo(id) {
    document.getElementById('id_rechazo').value = id;
    document.getElementById('modalRechazo').classList.remove('hidden');
}
function cerrarRechazo() {
    document.getElementById('modalRechazo').classList.add('hidden');
}
</script>
<script>
function verImagen(url) {
    document.getElementById('imgComprobante').src = url;
    document.getElementById('modalImagen').classList.remove('hidden');
}
function cerrarModal() {
    document.getElementById('modalImagen').classList.add('hidden');
}
</script>