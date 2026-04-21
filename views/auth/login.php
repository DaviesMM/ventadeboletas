<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<div class="min-h-screen bg-[#0f172a] flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-[#1e293b] rounded-3xl p-8 border border-white/10 shadow-2xl">
        <h2 class="text-3xl font-black text-white mb-2 text-center">E-TICKET</h2>
        <p class="text-gray-400 text-center mb-8 uppercase tracking-widest text-xs">Acceso Administrativo</p>

        <?php if(isset($error)): ?>
            <div class="bg-red-500/20 border border-red-500 text-red-500 p-3 rounded-xl mb-6 text-sm text-center">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="/E-ticket/login" method="POST" class="space-y-6">
            <div>
                <label class="text-gray-400 text-xs uppercase font-bold mb-2 block">Email</label>
                <input type="email" name="email" required class="w-full bg-[#0f172a] border border-white/10 rounded-xl py-3 px-4 text-white focus:outline-none focus:border-[#4ade80] transition-colors">
            </div>
            <div>
                <label class="text-gray-400 text-xs uppercase font-bold mb-2 block">Contraseña</label>
                <input type="password" name="password" required class="w-full bg-[#0f172a] border border-white/10 rounded-xl py-3 px-4 text-white focus:outline-none focus:border-[#4ade80] transition-colors">
            </div>
            <button type="submit" class="w-full bg-[#4ade80] text-black font-black py-4 rounded-xl uppercase tracking-widest hover:bg-[#3bc771] transition-all">
                Entrar al Sistema
            </button>
        </form>
    </div>
</div>