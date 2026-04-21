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
 /**public function run($url) {
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
} */
public function run($url) {
    $url = trim($url, '/');
    
    // 1. Intentamos coincidencia exacta primero (Esto salva a 'admin/asistentes_evento')
    if (array_key_exists($url, $this->routes)) {
        $this->execute($this->routes[$url]);
        return;
    }

    // 2. Si no es exacta, probamos por partes para rutas con ID
    $parts = explode('/', $url);
    
    // Intentamos reconstruir la ruta sin el último elemento (el ID)
    // Ej: 'admin/asistentes_evento/1' -> 'admin/asistentes_evento'
    $posibleRuta = "";
    for($i = 0; $i < count($parts) - 1; $i++) {
        $posibleRuta .= ($i > 0 ? '/' : '') . $parts[$i];
    }

    if (!empty($posibleRuta) && array_key_exists($posibleRuta, $this->routes)) {
        $params = end($parts); // El último elemento es el ID
        $this->execute($this->routes[$posibleRuta], $params);
    } 
    // 3. Caso especial para una sola palabra (ej: 'admin', 'login')
    elseif (array_key_exists($parts[0], $this->routes)) {
        $this->execute($this->routes[$parts[0]]);
    }
    else {
        header("HTTP/1.0 404 Not Found");
        echo "Ruta no encontrada: " . $url;
    }
}

private function execute($route, $params = null) {
    $controllerName = $route['controller'];
    $methodName = $route['method'];

    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $methodName)) {
            $controller->$methodName($params);
        } else {
            die("Error: El método $methodName no existe.");
        }
    } else {
        die("Error: El controlador $controllerName no existe.");
    }
}
} // fin de la clase router