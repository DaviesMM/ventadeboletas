<?php
// 1. Errores para desarrollo
ini_set('display_errors', 1);
error_reporting(E_ALL);

// 2. Cargar el Autoload
require_once "../app/Core/Autoload.php";

// 3. Usar el Router
use App\Core\Router;

$router = new Router();

// 4. DEFINIR LAS RUTAS
// formato: $router->add('ruta', 'Controlador', 'Método');
$router->add('', 'App\Controllers\HomeController', 'index');
// Rutas del Panel Administrativo

$router->add('admin/eventos', 'App\Controllers\AdminController', 'eventos');
$router->add('admin/reportes', 'App\Controllers\AdminController', 'reportes');
$router->add('admin/staff', 'App\Controllers\AdminController', 'staff');
$router->add('admin/guardar-evento', 'App\Controllers\AdminController', 'guardar');
$router->add('admin', 'App\Controllers\AdminController', 'index');
// rutas para panel de clientes/compra

// ruta para mostrar el ticket después de la compra
$router->add('ticket', 'App\Controllers\VentaController', 'ticket');
// Cuando el usuario viene del Home
$router->add('comprar', 'App\Controllers\VentaController', 'checkout');
// Cuando el usuario envía el formulario de datos
$router->add('procesar-pago', 'App\Controllers\VentaController', 'procesarPago');
// Cuando el validador escanea el QR
$router->add('validar', 'App\Controllers\AdminController', 'validarTicket');
$router->add('validar_manual', 'App\Controllers\AdminController', 'validarManual');
// Cuando ya se procesó y queremos ver el QR
$router->add('ticket', 'App\Controllers\VentaController', 'ticket');
// Rutas de autenticación
$router->add('login', 'App\Controllers\AuthController', 'login');
$router->add('logout', 'App\Controllers\AuthController', 'logout');

// Capturamos la URL que nos manda el .htaccess
$url = $_GET['url'] ?? '';
$url = trim($url, '/');

// Si la URL está vacía (raiz), le asignamos algo por defecto o lo dejamos vacío
// dependiendo de cómo tengas tus rutas.
$router->run($url);
