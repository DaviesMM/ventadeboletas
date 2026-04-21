<?php include 'layouts/header.php'; ?>
<?php include 'layouts/sidebar.php'; ?>
<div class="p-8">
    <div class="flex items-center gap-4 mb-8">
        <a href="/E-ticket/admin/reportes" class="bg-white/5 p-2 rounded-xl hover:bg-[#4ade80] hover:text-black transition-all">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-3xl font-black text-white uppercase"><?php echo $stats['nombre_evento']; ?></h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-[#1e293b] p-6 rounded-3xl border border-white/5">
            <p class="text-gray-500 text-[10px] font-bold uppercase mb-1">Ingresos Totales</p>
            <span class="text-2xl font-black text-[#4ade80]">$<?php echo number_format($stats['ingresados_totales'] ?? 0, 0, ',', '.'); ?></span>
        </div>
        <div class="bg-[#1e293b] p-6 rounded-3xl border border-white/5">
            <p class="text-gray-500 text-[10px] font-bold uppercase mb-1">Boletas Vendidas</p>
            <span class="text-2xl font-black text-white"><?php echo $stats['boletas_vendidas'] ?? 0; ?></span>
        </div>
        <div class="bg-[#1e293b] p-6 rounded-3xl border border-white/5">
            <p class="text-gray-500 text-[10px] font-bold uppercase mb-1">Stock Disponible</p>
            <span class="text-2xl font-black text-blue-400"><?php echo $stats['stock_total'] - ($stats['boletas_vendidas'] ?? 0); ?></span>
        </div>
        <div class="bg-[#1e293b] p-6 rounded-3xl border border-white/5">
            <p class="text-gray-500 text-[10px] font-bold uppercase mb-1">Efectividad Puerta</p>
            <span class="text-2xl font-black text-yellow-500"><?php echo $stats['personas_adentro'] ?? 0; ?> <small class="text-xs text-gray-600">Ingresaron</small></span>
        </div>
    </div>

    <div class="p-6 border-b border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
    <div>
        <h3 class="font-bold text-gray-400 uppercase text-xs tracking-widest">Listado de Compradores</h3>
    </div>
    <input type="text" id="buscadorCliente" placeholder="Buscar por nombre o ID..." 
           class="bg-[#0f172a] border border-white/10 rounded-xl px-4 py-2 text-sm text-white focus:outline-none focus:border-[#4ade80] w-full md:w-80">
</div>

<div class="overflow-x-auto">
    <table class="w-full text-left" id="tablaDetalle">
        <thead>
            <tr class="text-[10px] text-gray-500 uppercase bg-black/20">
                <th class="p-4">ID</th>
                <th class="p-4">Cliente</th>
                <th class="p-4 text-center">Cant.</th>
                <th class="p-4">Total</th>
                <th class="p-4">Estado</th>
                <th class="p-4 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody id="cuerpoTabla" class="text-sm">
            <?php foreach($asistentes as $a): ?>
            <tr class="border-b border-white/5 hover:bg-white/5 transition-all fila-cliente">
                <td class="p-4 text-gray-500 font-mono">#<?php echo str_pad($a['id_venta'], 4, "0", STR_PAD_LEFT); ?></td>
                <td class="p-4">
                    <p class="font-bold text-white"><?php echo $a['nombre_cliente']; ?></p>
                    <p class="text-[10px] text-gray-500"><?php echo $a['email_cliente']; ?></p>
                </td>
                <td class="p-4 text-center text-white"><?php echo $a['cantidad']; ?></td>
                <td class="p-4 text-[#4ade80] font-bold">$<?php echo number_format($a['total'], 0, ',', '.'); ?></td>
                <td class="p-4">
                    <span class="px-2 py-1 rounded-lg text-[9px] font-black uppercase <?php echo $a['estado_asistencia'] == 'ingresado' ? 'bg-green-500/10 text-green-400' : 'bg-yellow-500/10 text-yellow-400'; ?>">
                        <?php echo $a['estado_asistencia']; ?>
                    </span>
                </td>
                <td class="p-4 text-center">
                    <div class="flex justify-center gap-2">
                        <a href="/E-ticket/ver_ticket/<?php echo $a['id_venta']; ?>" target="_blank" title="Ver Ticket" class="p-2 bg-blue-500/10 text-blue-400 rounded-lg hover:bg-blue-500 hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </a>
                        <button onclick="confirmarReenvio(<?php echo $a['id_venta']; ?>)" title="Reenviar Correo" class="p-2 bg-purple-500/10 text-purple-400 rounded-lg hover:bg-purple-500 hover:text-white transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="p-4 bg-black/10 flex justify-between items-center text-gray-400 text-[10px] font-bold uppercase tracking-widest">
    <button id="prevBtn" class="px-4 py-2 bg-[#0f172a] rounded-lg hover:text-[#4ade80] disabled:opacity-20 transition-all">Anterior</button>
    <span id="pageInfo">Página 1 de 1</span>
    <button id="nextBtn" class="px-4 py-2 bg-[#0f172a] rounded-lg hover:text-[#4ade80] disabled:opacity-20 transition-all">Siguiente</button>
</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filasPorPagina = 8;
    let paginaActual = 1;
    const filas = Array.from(document.querySelectorAll('.fila-cliente'));
    const totalPaginas = Math.ceil(filas.length / filasPorPagina);

    function actualizarTabla(numPagina) {
        const inicio = (numPagina - 1) * filasPorPagina;
        const fin = inicio + filasPorPagina;

        filas.forEach((fila, index) => {
            fila.style.display = (index >= inicio && index < fin) ? '' : 'none';
        });

        document.getElementById('pageInfo').innerText = `Página ${numPagina} de ${totalPaginas || 1}`;
        document.getElementById('prevBtn').disabled = numPagina === 1;
        document.getElementById('nextBtn').disabled = numPagina === totalPaginas || totalPaginas === 0;
    }

    document.getElementById('prevBtn').addEventListener('click', () => {
        if (paginaActual > 1) { paginaActual--; actualizarTabla(paginaActual); }
    });

    document.getElementById('nextBtn').addEventListener('click', () => {
        if (paginaActual < totalPaginas) { paginaActual++; actualizarTabla(paginaActual); }
    });

    // Buscador
    document.getElementById('buscadorCliente').addEventListener('keyup', function() {
        let filtro = this.value.toLowerCase();
        filas.forEach(fila => {
            let texto = fila.innerText.toLowerCase();
            fila.style.display = texto.includes(filtro) ? '' : 'none';
        });
        if(filtro === "") actualizarTabla(1);
    });

    actualizarTabla(1);
});

function confirmarReenvio(id) {
    if(confirm('¿Deseas reenviar el ticket al correo del cliente?')) {
        // Aquí podrías disparar un fetch a una ruta de envío de correo
        alert('Simulación: Correo enviado para la venta #' + id);
    }
}
</script>