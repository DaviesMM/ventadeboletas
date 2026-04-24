<?php
namespace App\Controllers;

class BaseController {
    /**
     * @param string $view   Nombre de la vista (ej: 'admin/reportes')
     * @param array  $data   Datos para la vista
     * @param string $layout Nombre del archivo base (ej: 'admin', 'tienda', 'staff')
     */
    protected function render($view, $data = [], $layout = 'admin') {
        // Convierte el array ['titulo' => 'Hola'] en variable $titulo
        extract($data);

        // Definimos la ruta de la vista que se cargará dentro del layout
        $content = "../views/{$view}.php";

        // Cargamos el layout principal que contiene el HTML, Head, Body
        // y dentro de ese archivo haremos un include de $content
        if (file_exists("../views/layouts/{$layout}.php")) {
            include "../views/layouts/{$layout}.php";
        } else {
            // Si no existe el layout, cargamos la vista a pelo (fallback)
            include $content;
        }
    }
}