<?php
namespace App\Core;

class Router {
    protected $routes = [];

    // Método para registrar una ruta (URL, Controlador, Método)
    public function add($url, $controller, $method) {
        $this->routes[$url] = [
            'controller' => $controller,
            'method' => $method
        ];
    }

    // Método para ejecutar la ruta actual
 public function run($url) {
    $url = trim($url, '/');
    
    // Intentamos buscar la coincidencia exacta primero (ej: admin/reportes)
    // Esto soluciona tu problema de las pestañas del sidebar.
    if (array_key_exists($url, $this->routes)) {
        $this->execute($this->routes[$url]);
        return;
    }

    // Si no hay coincidencia exacta, probamos si es una ruta con ID (ej: validar/105)
    $parts = explode('/', $url);
    $routeKey = $parts[0]; // Aquí tomamos 'validar'
    $params = isset($parts[1]) ? $parts[1] : null;

    if (array_key_exists($routeKey, $this->routes)) {
        $this->execute($this->routes[$routeKey], $params);
    } else {
        header("HTTP/1.0 404 Not Found");
        include "../views/errors/404.php"; // O un simple echo
    }
}

// Función auxiliar para no repetir código
private function execute($route, $params = null) {
    $controllerName = $route['controller'];
    $methodName = $route['method'];

    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $methodName)) {
            $controller->$methodName($params);
        } else {
            die("Error: El método $methodName no existe en $controllerName");
        }
    } else {
        die("Error: El controlador $controllerName no existe");
    }
}
}