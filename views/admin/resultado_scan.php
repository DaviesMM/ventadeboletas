<?php include 'layouts/header.php'; ?>
<div class="min-h-screen <?php echo $color; ?> flex items-center justify-center p-6 text-white font-sans">
    <div class="max-w-md w-full bg-white/10 backdrop-blur-md p-8 rounded-3xl border border-white/20 shadow-2xl text-center">
        
        <h1 class="text-5xl font-black mb-4 tracking-tighter uppercase">
            <?php echo $mensaje; ?>
        </h1>
        
        <p class="text-xl mb-8 opacity-80">
            <?php echo $detalle; ?>
        </p>

        <?php if(isset($ticket)): ?>
            <div class="bg-black/20 p-6 rounded-2xl text-left border border-white/10 mb-8">
                <p class="text-xs uppercase opacity-50">Cliente</p>
                <p class="text-2xl font-bold mb-4"><?php echo $ticket['nombre_cliente']; ?></p>
                
                <div class="flex justify-between">
                    <div>
                        <p class="text-xs uppercase opacity-50">Boletas</p>
                        <p class="text-xl font-bold"><?php echo $ticket['cantidad']; ?></p>
                    </div>
                    <div>
                        <p class="text-xs uppercase opacity-50">Ticket ID</p>
                        <p class="text-xl font-bold">#<?php echo $ticket['id_venta']; ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <a href="/E-ticket/" class="inline-block w-full py-4 bg-white text-black font-bold rounded-xl shadow-lg hover:scale-105 transition-transform uppercase tracking-widest">
            Siguiente Escaneo
        </a>
    </div>
</div>