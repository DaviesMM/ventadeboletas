<?php
require_once '../app/autoload.php';// Si usas composer, sino carga tus archivos manualmente

use App\Core\Router;

$router = new Router();


// --- RUTAS PÚBLICAS (TIENDA) ---
$router->add('', 'App\Controllers\TiendaController', 'index');
$router->add('evento', 'App\Controllers\TiendaController', 'MostrarEvento');

// --- RUTAS ADMINISTRATIVAS ---
$router->add('admin', 'App\Controllers\AdminController', 'index');
$router->add('admin/reportes', 'App\Controllers\AdminController', 'reportes');
$router->add('admin/asistentes_evento', 'App\Controllers\AdminController', 'verAsistentesPorEvento');
// Rutas para creación de eventos
$router->add('admin/nuevo_evento', 'App\Controllers\AdminController', 'crearEvento');
$router->add('admin/guardar_evento', 'App\Controllers\AdminController', 'guardarEvento');
// Detalle, edición y eliminación
$router->add('admin/detalle', 'App\Controllers\AdminController', 'verDetalle');
$router->add('admin/eliminar_evento', 'App\Controllers\AdminController', 'eliminarEvento');

// --- RUTAS DEL STAFF ---
$router->add('staff/scanner', 'App\Controllers\StaffController', 'index');
$router->add('staff/validar', 'App\Controllers\StaffController', 'validarQR');

// Ejecución
$url = $_GET['url'] ?? '';
$router->run($url);