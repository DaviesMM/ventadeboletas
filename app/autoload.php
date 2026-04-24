<?php
spl_autoload_register(function ($class) {
    // 1. Reemplazamos el Namespace 'App' por el nombre de la carpeta real 'app'
    $class = str_replace('App\\', 'app\\', $class);
    
    
    // La constante correcta es DIRECTORY_SEPARATOR
    $classPath = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    
    // 3. Construimos la ruta completa desde la raíz del proyecto
    $file = dirname(__DIR__) . DIRECTORY_SEPARATOR . $classPath . '.php';

    // 4. Verificamos si el archivo existe antes de cargarlo
    if (file_exists($file)) {
        require_once $file;
    }
});