<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STAFF | <?php echo $titulo; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body class="bg-[#0f172a] text-white overflow-hidden">
    
    <nav class="p-4 border-b border-white/5 bg-[#1e293b] flex justify-between items-center">
        <span class="font-black text-[#4ade80] tracking-tighter">STAFF MODE</span>
        <a href="/E-ticket/admin" class="text-[10px] text-gray-400 border border-white/10 px-2 py-1 rounded">SALIR</a>
    </nav>

    <main>
        <?php include $content; ?>
    </main>

</body>
</html>