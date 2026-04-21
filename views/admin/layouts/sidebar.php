<body class="bg-[#1a1c20] text-gray-200 font-sans flex">
<aside class="hidden md:flex w-64 h-screen bg-[#25282e] border-r border-gray-800 flex-col fixed z-50">
    <div class="p-6 text-2xl font-bold text-[#4ade80] flex items-center gap-2">
        <i class="fa-solid fa-ticket-simple"></i> E-ticket
    </div>
    <nav class="flex-1 mt-4">
        <a href="/E-ticket/admin" class="flex items-center gap-3 px-6 py-4 hover:bg-[#1a1c20] transition-all">
            <i class="fa-solid fa-chart-line"></i> Dashboard
        </a>
        <a href="/E-ticket/admin/eventos" class="flex items-center gap-3 px-6 py-4 hover:bg-[#1a1c20] transition-all">
            <i class="fa-solid fa-calendar-days"></i> Gestionar Eventos
        </a>
          <a href="/E-ticket/admin/reportes" class="flex items-center gap-3 px-6 py-4 hover:bg-[#1a1c20] transition-all">
                <i class="fa-solid fa-money-bill-trend-up"></i> Reportes de Ventas
        </a>
        <a href="/E-ticket/admin/staff" class="flex items-center gap-3 px-6 py-4 hover:bg-[#1a1c20] transition-all">
            <i class="fa-solid fa-users-gear"></i> Validadores
        </a>
    </nav>

    <div class="p-6 border-t border-gray-800">
            <a href="/E-ticket/logout" class="bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white border border-red-500/50 px-6 py-2 rounded-xl font-bold transition-all flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                </svg>
                CERRAR SESIÓN
            </a>
    </div>
</aside>

<div class="md:hidden bg-[#25282e] w-full p-4 flex justify-between items-center border-b border-gray-800 fixed top-0 z-50">
    <span class="text-[#4ade80] font-bold text-xl">E-ticket</span>
    <button class="text-white text-2xl" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
        <i class="fa-solid fa-bars"></i>
    </button>
</div>

<div id="mobile-menu" class="hidden md:hidden bg-[#25282e] fixed inset-0 z-40 pt-20">
    <nav class="flex flex-col text-center">
        <a href="/E-ticket/admin" class="py-4 border-b border-gray-800">Dashboard</a>
        <a href="/E-ticket/admin/eventos" class="py-4 border-b border-gray-800">Eventos</a>
        <a href="/E-ticket/admin/reportes" class="py-4 border-b border-gray-800">Reportes</a>
        <a href="/E-ticket/admin/staff" class="py-4 border-b border-gray-800">Validadores</a>
        <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="mt-8 text-gray-400">Cerrar</button>
    </nav>
</div>

<main class="w-full md:ml-64 flex-1 p-4 md:p-8 mt-16 md:mt-0">