<div class="p-6 flex flex-col items-center justify-center min-h-[80vh]">
    <div class="w-full max-w-md bg-[#1e293b] rounded-3xl overflow-hidden shadow-2xl border border-white/10">
        <div id="reader" class="w-full bg-black"></div>
        
        <div class="p-6 text-center">
            <h2 class="text-xl font-bold mb-2">Listo para Escanear</h2>
            <p class="text-gray-400 text-sm"><?php echo $instruccion; ?></p>
        </div>
    </div>

    <div id="result-overlay" class="fixed inset-0 flex items-center justify-center hidden z-50 bg-[#0f172a]/90">
        <div id="result-card" class="p-10 rounded-full text-center">
            <div id="result-icon" class="mb-4"></div>
            <h2 id="result-text" class="text-2xl font-black uppercase"></h2>
        </div>
    </div>
</div>

<script>
    function onScanSuccess(decodedText, decodedResult) {
    // Pausar el scanner para procesar
    html5QrcodeScanner.pause();
    
    // Enviar al controlador mediante Fetch
    fetch('/E-ticket/staff/validar', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'qr_data=' + encodeURIComponent(decodedText)
    })
    .then(response => response.json())
    .then(data => {
        mostrarResultado(data);
    });
}

function mostrarResultado(res) {
    const overlay = document.getElementById('result-overlay');
    const text = document.getElementById('result-text');
    overlay.classList.remove('hidden');
    
    if(res.status === 'success') {
        overlay.classList.add('bg-green-500');
        text.innerText = "¡TICKET VÁLIDO!";
    } else {
        overlay.classList.add('bg-red-500');
        text.innerText = res.message || "TICKET INVÁLIDO";
    }

    // Ocultar y reanudar después de 2 segundos
    setTimeout(() => {
        overlay.classList.add('hidden');
        overlay.classList.remove('bg-green-500', 'bg-red-500');
        html5QrcodeScanner.resume();
    }, 2000);
}

let html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess);
</script>