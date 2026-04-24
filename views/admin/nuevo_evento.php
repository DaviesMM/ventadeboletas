<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-black text-white uppercase tracking-tighter">Crear <span class="text-[#4ade80]">Nuevo Evento</span></h1>
        <p class="text-gray-400">Completa la información para publicar tu evento.</p>
    </div>

    <form action="/E-ticket/admin/guardar_evento" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-[#1e293b] p-8 rounded-3xl border border-white/5 shadow-2xl">
        
        <div class="md:col-span-2">
            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Nombre del Evento</label>
            <input type="text" name="nombre_evento" required 
                   class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#4ade80] transition-all">
        </div>

        <div class="md:col-span-2">
            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Descripción</label>
            <textarea name="descripcion" rows="3" 
                      class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#4ade80] transition-all"></textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Fecha y Hora</label>
            <input type="datetime-local" name="fecha_evento" required 
                   class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#4ade80] transition-all">
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Lugar / Ubicación</label>
            <input type="text" name="lugar" required 
                   class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#4ade80] transition-all">
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Precio de Boleta ($)</label>
            <input type="number" name="precio_boleta" step="0.01" required 
                   class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#4ade80] transition-all">
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Stock Total (Aforo)</label>
            <input type="number" name="stock_total" required 
                   class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#4ade80] transition-all">
        </div>

        <div class="md:col-span-2">
            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">URL de la Imagen (Poster)</label>
            <input type="text" name="imagen_url" placeholder="https://ejemplo.com/imagen.jpg" 
                   class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#4ade80] transition-all">
        </div>
            
        <div class="md:col-span-2 flex gap-4 mt-4">
            <button type="submit" class="flex-1 bg-[#4ade80] text-black font-black py-4 rounded-2xl hover:scale-[1.02] transition-transform uppercase text-sm">
                Publicar Evento
            </button>
            
            <a href="/E-ticket/admin" class="px-8 py-4 border border-white/10 text-gray-400 rounded-2xl hover:bg-white/5 transition-all text-sm uppercase font-bold text-center">
                Cancelar
            </a>
        </div>
        <p class="mt-2 text-[10px] text-[#4ade80] font-bold uppercase tracking-wider">
    ℹ️       El sistema habilitará automáticamente el 100% del aforo al publicar el evento.
            </p>
    </form>
</div>