<?php
namespace App\Core;

class Router {
    protected $routes = [];

    public function add($route, $controller, $method) {
        $this->routes[$route] = ['controller' => $controller, 'method' => $method];
    }

    public function run($url) {
        $url = trim($url, '/');

        // 1. Coincidencia exacta
        if (array_key_exists($url, $this->routes)) {
            $this->execute($this->routes[$url]);
            return;
        }

        // 2. Coincidencia con parámetros (ID)
        $parts = explode('/', $url);
        $posibleRuta = "";
        for($i = 0; $i < count($parts) - 1; $i++) {
            $posibleRuta .= ($i > 0 ? '/' : '') . $parts[$i];
        }

        if (!empty($posibleRuta) && array_key_exists($posibleRuta, $this->routes)) {
            $params = end($parts);
            $this->execute($this->routes[$posibleRuta], $params);
        } 
        elseif (array_key_exists($parts[0], $this->routes)) {
            $this->execute($this->routes[$parts[0]]);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo "404 - Ruta no encontrada";
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
                die("Error: Método $methodName no existe.");
            }
        } else {
            die("Error: Controlador $controllerName no existe.");
        }
    }
}