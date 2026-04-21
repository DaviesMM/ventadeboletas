<?php include 'layouts/header.php'; ?>
<?php include 'layouts/sidebar.php'; ?>

    
        <header class="flex justify-between items-center mb-8">
           
            <div class="flex items-center gap-4">
                <div>
                <h3 class="text-3xl font-black uppercase tracking-widest text-[#4ade80]">Panel de <?php echo $_SESSION['user']['rol']; ?></h3>
                <p class="text-gray-400">Sesión iniciada  <strong><?php echo $_SESSION['user']['nombre']; ?></strong></p>
            </div>
                <div class="w-10 h-10 bg-[#4ade80] rounded-full"></div>
            </div>

        <div class="flex justify-between items-center mb-8">
            
            
            <a href="/E-ticket/logout" placeholder="cerrar session" class="bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white border border-red-500/50 px-6 py-2 rounded-xl font-bold transition-all flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                </svg>
                
            </a>
        </div>
        </header>
        <section class="bg-[#25282e] p-8 rounded-3xl border border-gray-800">
            <h4 class="text-xl font-bold mb-4">Acciones de hoy</h4>
            <div class="flex gap-4">
                
                 <div class="mb-8 bg-gradient-to-r from-[#4ade80]/10 to-transparent p-6 rounded-3xl border border-[#4ade80]/20 flex flex-col md:flex-row items-center justify-between gap-4">
                        <div>
                        <h3 class="text-[#4ade80] font-black uppercase tracking-widest text-sm">Validación Manual</h3>
                        <p class="text-gray-400 text-xs">Si el QR falla, ingresa el ID del ticket aquí:</p>
                        </div>
                        <form action="/E-ticket/validar_manual" method="POST" class="flex gap-2 w-full md:w-auto">
                        <input type="number" name="id_ticket" placeholder="Ej: 105" required
                            class="bg-[#0f172a] border border-white/10 rounded-xl px-4 py-2 text-white focus:outline-none focus:border-[#4ade80] w-full md:w-32">
                        <button type="submit" class="bg-[#4ade80] text-black font-black px-6 py-2 rounded-xl hover:bg-[#3bc771] transition-all uppercase text-xs tracking-widest">
                            Validar
                        </button>
                        </form>
                        <button class="bg-[#4ade80] text-black px-5 py-2 rounded-xl font-bold hover:scale-105 transition-transform">
                            + Crear Nuevo Evento
                        </button>
                        <button class="bg-gray-700 text-white px-6 py-2 rounded-xl font-bold hover:bg-gray-600 transition-colors">
                            Ver Listado de Staff
                        </button>
                </div>
            </div>
               
        </section>
        
    
    <div class="p-8 bg-[#0f172a] min-h-screen text-white">
    <h1 class="text-3xl font-black mb-8 uppercase tracking-widest text-[#4ade80]">Panel de Control E-Ticket</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-[#1e293b] p-6 rounded-3xl border border-white/5 shadow-xl">
            <p class="text-gray-400 text-sm uppercase font-bold">Total Recaudado</p>
            <p class="text-3xl font-black text-[#4ade80]">$<?php echo number_format($resumen['recaudado'], 0, ',', '.'); ?></p>
        </div>

        <div class="bg-[#1e293b] p-6 rounded-3xl border border-white/5 shadow-xl">
            <p class="text-gray-400 text-sm uppercase font-bold">Tickets Vendidos</p>
            <p class="text-3xl font-black"><?php echo $resumen['total_tickets']; ?></p>
        </div>

        <div class="bg-[#1e293b] p-6 rounded-3xl border border-white/5 shadow-xl">
            <p class="text-gray-400 text-sm uppercase font-bold">Personas en Puerta</p>
            <p class="text-3xl font-black text-blue-400"><?php echo $resumen['asistencias']; ?> / <?php echo $resumen['total_personas']; ?></p>
        </div>

        <div class="bg-[#1e293b] p-6 rounded-3xl border border-white/5 shadow-xl">
            <p class="text-gray-400 text-sm uppercase font-bold">% de Aforo</p>
            <?php $porcentaje = ($resumen['total_personas'] > 0) ? ($resumen['asistencias'] / $resumen['total_personas']) * 100 : 0; ?>
            <p class="text-3xl font-black text-purple-400"><?php echo round($porcentaje); ?>%</p>
        </div>
        
    </div>
<div class="mt-12 bg-[#1e293b] rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
    <div class="p-6 border-b border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-xl font-black uppercase tracking-wider text-white">Gestión de Asistentes</h2>
            <p class="text-xs text-gray-400">Control de ingresos por evento</p>
        </div>
        <input type="text" id="buscador" placeholder="Buscar cliente o evento..." 
               class="bg-[#0f172a] border border-white/10 rounded-xl px-4 py-2 text-sm text-white focus:outline-none focus:border-[#4ade80] w-full md:w-80">
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="tablaAsistentes">
            <thead>
                <tr class="bg-black/20 text-gray-400 text-[10px] uppercase tracking-widest">
                    <th class="p-4">ID</th>
                    <th class="p-4">Evento</th>
                    <th class="p-4">Cliente</th>
                    <th class="p-4">Cant.</th>
                    <th class="p-4">Estado</th>
                    <th class="p-4 text-right">Ingreso</th>
                </tr>
            </thead>
            <tbody id="tabla-cuerpo">
                <?php foreach($asistentes as $a): ?>
                <tr class="border-b border-white/5 hover:bg-white/5 transition-colors fila-asistente">
                    <td class="p-4 font-mono text-gray-500 text-xs">#<?php echo str_pad($a['id_venta'], 4, "0", STR_PAD_LEFT); ?></td>
                    <td class="p-4 font-medium text-[#4ade80] text-sm"><?php echo $a['nombre_evento']; ?></td>
                    <td class="p-4 font-bold text-white"><?php echo $a['nombre_cliente']; ?></td>
                    <td class="p-4 text-center text-white"><?php echo $a['cantidad']; ?></td>
                    <td class="p-4">
                        <?php if($a['estado_asistencia'] == 'ingresado'): ?>
                            <span class="bg-green-500/10 text-green-400 border border-green-500/20 px-3 py-1 rounded-full text-[9px] font-black uppercase">Adentro</span>
                        <?php else: ?>
                            <span class="bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 px-3 py-1 rounded-full text-[9px] font-black uppercase">Pendiente</span>
                        <?php endif; ?>
                    </td>
                    <td class="p-4 text-right text-xs text-gray-400">
                        <?php echo $a['fecha_ingreso'] ? date('H:i', strtotime($a['fecha_ingreso'])) : '--:--'; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="p-4 bg-black/10 flex justify-between items-center text-gray-400 text-xs">
        <button id="btnPrev" class="px-4 py-2 bg-[#0f172a] rounded-lg hover:text-[#4ade80] disabled:opacity-30">Anterior</button>
        <span id="infoPagina">Página 1 de X</span>
        <button id="btnNext" class="px-4 py-2 bg-[#0f172a] rounded-lg hover:text-[#4ade80] disabled:opacity-30">Siguiente</button>
    </div>
</div>


</div>
<script>
    // Configuración de la paginación
    const filasPorPagina = 10;
    let paginaActual = 1;
    const filas = Array.from(document.querySelectorAll('.fila-asistente'));
    const totalPaginas = Math.ceil(filas.length / filasPorPagina);

    function mostrarPagina(numPagina) {
        const inicio = (numPagina - 1) * filasPorPagina;
        const fin = inicio + filasPorPagina;

        filas.forEach((fila, index) => {
            fila.style.display = (index >= inicio && index < fin) ? '' : 'none';
        });

        document.getElementById('infoPagina').innerText = `Página ${numPagina} de ${totalPaginas || 1}`;
        document.getElementById('btnPrev').disabled = numPagina === 1;
        document.getElementById('btnNext').disabled = numPagina === totalPaginas || totalPaginas === 0;
    }

    document.getElementById('btnPrev').addEventListener('click', () => {
        if (paginaActual > 1) { paginaActual--; mostrarPagina(paginaActual); }
    });

    document.getElementById('btnNext').addEventListener('click', () => {
        if (paginaActual < totalPaginas) { paginaActual++; mostrarPagina(paginaActual); }
    });

    // Buscador mejorado
    document.getElementById('buscador').addEventListener('keyup', function() {
        let filtro = this.value.toLowerCase();
        filas.forEach(fila => {
            let textoFila = fila.innerText.toLowerCase();
            fila.style.display = textoFila.includes(filtro) ? '' : 'none';
        });
        // Si hay búsqueda, desactivamos paginación temporalmente para mostrar resultados
        if(filtro === "") mostrarPagina(1);
    });

    // Iniciar
    mostrarPagina(1);
</script>

</body>
</html>