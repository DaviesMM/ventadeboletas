<?php
namespace App\Controllers;

class Controller {
    // Método para cargar una vista y pasarle datos
    public function render($view, $data = []) {
        extract($data); // Convierte ['evento' => 'Rock'] en $evento = 'Rock'
        $viewPath = "../views/" . $view . ".php";
        
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("La vista $view no existe.");
        }
    }
}