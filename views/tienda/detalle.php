<div class="max-w-6xl mx-auto px-4 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <div class="space-y-6">
            <div class="rounded-[3rem] overflow-hidden shadow-2xl border border-white/5">
                <img src="<?php echo $evento['imagen_url']; ?>" class="w-full h-auto">
            </div>
            <div class="bg-[#1e293b] p-8 rounded-[2rem] border border-white/5">
                <h2 class="text-[#4ade80] font-black uppercase tracking-widest text-sm mb-2">Sobre el evento</h2>
                <p class="text-gray-400 leading-relaxed"><?php echo $evento['descripcion']; ?></p>
                
                <div class="mt-6 flex items-center gap-4 text-sm text-gray-300">
                    <span class="bg-[#0f172a] px-4 py-2 rounded-full border border-white/10">📍 <?php echo $evento['lugar']; ?></span>
                    <span class="bg-[#0f172a] px-4 py-2 rounded-full border border-white/10">📅 <?php echo date('d/m/Y H:i', strtotime($evento['fecha_evento'])); ?></span>
                </div>
            </div>
        </div>

        <div class="bg-[#1e293b] p-10 rounded-[3rem] border border-white/5 shadow-2xl h-fit sticky top-8">
            <h1 class="text-4xl font-black text-white uppercase mb-6 leading-none">Reserva tus <span class="text-[#4ade80]">Tickets</span></h1>
            
            <form action="/E-ticket/compra/confirmacion" method="POST" class="space-y-4">
                <input type="hidden" name="id_evento" value="<?php echo $evento['id_evento']; ?>">
                <input type="hidden" name="precio_unitario" value="<?php echo $evento['precio_boleta']; ?>">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2 ml-2">Nombre Completo</label>
                        <input type="text" name="nombre_cliente" required placeholder="Ej: Juan Pérez"
                               class="w-full bg-[#0f172a] border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-[#4ade80] transition-all">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2 ml-2">Teléfono</label>
                        <input type="tel" name="telefono_cliente" required placeholder="Ej: 3001234567"
                               class="w-full bg-[#0f172a] border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-[#4ade80] transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2 ml-2">Correo Electrónico</label>
                    <input type="email" name="email_cliente" required placeholder="tu@email.com"
                           class="w-full bg-[#0f172a] border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-[#4ade80] transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2 ml-2">Cantidad de Boletas</label>
                        <select name="cantidad" id="cantidad" onchange="calcularTotal(this.value, <?php echo $evento['precio_boleta']; ?>)"
                                class="w-full bg-[#0f172a] border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-[#4ade80] transition-all appearance-none">
                            <?php for($i=1; $i<=min(10, $evento['stock_disponible']); $i++): ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?> boleta(s)</option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2 ml-2">Método de Pago</label>
                        <select name="metodo_pago" class="w-full bg-[#0f172a] border border-white/10 rounded-2xl px-5 py-4 text-white focus:outline-none focus:border-[#4ade80] transition-all appearance-none">
                            <option value="Transferencia">Transferencia Bancaria</option>
                            <option value="Digital Wallet">Billetera Digital (Nequi/Daviplata)</option>
                        </select>
                    </div>
                </div>

                <div class="bg-[#0f172a] p-6 rounded-2xl border border-white/5 mt-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-500 text-xs font-bold uppercase">Precio Unitario</span>
                        <span class="text-white font-bold">$<?php echo number_format($evento['precio_boleta'], 0); ?></span>
                    </div>
                    <div class="flex justify-between items-center border-t border-white/5 pt-4">
                        <span class="text-[#4ade80] text-sm font-black uppercase">Total a Pagar</span>
                        <span id="total_display" class="text-2xl font-black text-white">$<?php echo number_format($evento['precio_boleta'], 0); ?></span>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#4ade80] text-black font-black py-5 rounded-2xl hover:scale-[1.02] transition-transform uppercase text-sm tracking-[0.2em] shadow-[0_10px_30px_rgba(74,222,128,0.2)]">
                    Confirmar Reserva
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function calcularTotal(cant, precio) {
    const total = cant * precio;
    document.getElementById('total_display').innerText = '$' + total.toLocaleString('es-CO');
}
</script>