<div class="max-w-2xl mx-auto px-4 py-12">
    <div class="bg-[#1e293b] p-10 rounded-[3rem] border border-white/5 shadow-2xl text-center">
        
        <?php if($metodo === 'Digital Wallet'): ?>
            <div class="mb-8">
                <div class="w-16 h-16 bg-[#4ade80]/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">📱</span>
                </div>
                <h2 class="text-2xl font-black text-white uppercase italic">Pago por Billetera Digital</h2>
                <p class="text-gray-400 text-sm mt-2">Escanea el QR para transferir desde <span class="text-white font-bold">Nequi o Daviplata</span></p>
            </div>
            <div class="bg-white p-4 inline-block rounded-3xl mb-8 shadow-[0_0_50px_rgba(74,222,128,0.2)]">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=TRANSFERENCIA_DIGITAL" alt="QR de Pago">
            </div>

        <?php else: ?>
            <div class="mb-8">
                <div class="w-16 h-16 bg-blue-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl">🏦</span>
                </div>
                <h2 class="text-2xl font-black text-white uppercase italic">Transferencia Bancaria</h2>
                <p class="text-gray-400 text-sm mt-2">Realiza la transferencia a la siguiente cuenta:</p>
            </div>
            <div class="bg-[#0f172a] p-6 rounded-2xl border border-white/5 text-left mb-8">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-[10px] text-gray-500 font-bold uppercase">Banco</span>
                    <span class="text-white font-bold">BANCO NACIONAL</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-[10px] text-gray-500 font-bold uppercase">Cuenta de Ahorros</span>
                    <span class="text-[#4ade80] font-mono text-xl tracking-tighter">987-654321-00</span>
                </div>
            </div>
        <?php endif; ?>

        <form action="/E-ticket/compra/finalizar" method="POST" enctype="multipart/form-data" class="space-y-6 text-left border-t border-white/5 pt-8">
            <input type="hidden" name="id_evento" value="<?php echo $id_evento; ?>">
            <input type="hidden" name="nombre_cliente" value="<?php echo $nombre_cliente; ?>">
            <input type="hidden" name="email_cliente" value="<?php echo $email_cliente; ?>">
            <input type="hidden" name="telefono_cliente" value="<?php echo $telefono_cliente; ?>">
            <input type="hidden" name="cantidad" value="<?php echo $cantidad; ?>">
            <input type="hidden" name="total_oculto" value="<?php echo $total; ?>">
            <input type="hidden" name="metodo_pago" value="<?php echo $metodo; ?>">

            <div class="bg-[#0f172a] p-4 rounded-xl mb-6 flex justify-between items-center border border-[#4ade80]/20">
                <span class="text-xs text-gray-400 font-bold uppercase">Monto a enviar:</span>
                <span class="text-[#4ade80] font-black text-xl">$<?php echo number_format($total, 0); ?></span>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2 ml-2 tracking-widest">Referencia / ID de Pago</label>
                <input type="text" name="referencia_pago" required placeholder="Ej: 129384756"
                       class="w-full bg-[#0f172a] border border-white/10 rounded-2xl px-5 py-4 text-white focus:border-[#4ade80] transition-all outline-none">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2 ml-2 tracking-widest">Subir Foto del Comprobante</label>
                <input type="file" name="comprobante" accept="image/*" required
                       class="w-full text-xs text-gray-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:bg-white/5 file:text-white file:font-bold hover:file:bg-white/10 cursor-pointer">
            </div>

            <button type="submit" class="w-full bg-[#4ade80] text-black font-black py-5 rounded-2xl uppercase text-sm tracking-widest hover:shadow-[0_0_30px_rgba(74,222,128,0.3)] transition-all">
                Finalizar y Enviar Soporte
            </button>
        </form>
    </div>
</div>