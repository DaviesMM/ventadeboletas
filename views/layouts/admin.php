<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo ?? 'E-Ticket Pro'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0f172a] text-white">
    <div class="flex">
        <?php include '../views/layouts/sidebar_admin.php'; ?>

        <main class="flex-1 p-8">
            <?php include $content; ?>
        </main>
    </div>
</body>
</html>