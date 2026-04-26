<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket | <?php echo $titulo; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#0f172a] text-gray-200">
    <nav class="border-b border-white/5 py-6 px-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/E-ticket/" class="text-2xl font-black text-white tracking-tighter">E-<span class="text-[#4ade80]">TICKET</span></a>
            <div class="flex gap-6 text-sm font-bold uppercase tracking-widest">
                <a href="/E-ticket/" class="hover:text-[#4ade80] transition-colors">Inicio</a>
                <a href="#" class="hover:text-[#4ade80] transition-colors">Mis Compras</a>
                <a href="/E-ticket/admin" class="bg-white/5 px-4 py-2 rounded-lg border border-white/10 hover:bg-white/10 transition-all text-[10px]">Admin</a>
            </div>
        </div>
    </nav>

    <main>
        <?php include $content; ?>
    </main>

    <footer class="border-t border-white/5 py-12 mt-20 text-center">
        <p class="text-gray-600 text-xs uppercase font-bold tracking-widest">&copy; 2026 E-Ticket System. Todos los derechos reservados.</p>
    </footer>
</body>
</html>