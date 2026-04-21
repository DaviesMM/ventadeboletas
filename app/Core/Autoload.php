<?php
namespace App\Autoload;

spl_autoload_register(function ($class) {
    // Definimos el directorio base del proyecto (subimos un nivel desde Core)
    $base_dir = __DIR__ . '/../../';

    // Cambiamos los backslashes (\) del namespace por slashes (/) de carpetas
    // Ejemplo: App\Core\Router -> App/Core/Router
    $relative_class = str_replace('\\', '/', $class);

    // Armamos la ruta completa al archivo
    $file = $base_dir . $relative_class . ".php";

    // Si el archivo existe, lo cargamos
    if (file_exists($file)) {
        require_once $file;
    } else {
        // Esto te ayudará a debuguear si escribes mal un nombre
         die("Autoload: No se pudo encontrar la clase en la ruta: $file");
    }
});