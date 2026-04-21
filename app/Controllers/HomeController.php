<?php
namespace App\Controllers;

use App\Models\Evento;

class HomeController extends Controller {
    
    private function verificarSesion() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['user'])) {
            header("Location: /E-ticket/login");
            exit;
        }
    }
    public function index() {
        $eventoModel = new Evento();
        // Traemos solo los eventos activos para el público
        $eventos = $eventoModel->getAllActive(); 
        
        $data = [
            'titulo' => 'E-ticket | Compra tus entradas',
            'eventos' => $eventos
        ];
        
        $this->render('home', $data);
    }
}