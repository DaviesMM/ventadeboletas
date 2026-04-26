<?php
namespace App\Controllers;

use App\Models\Venta;
use App\Models\Evento;

class StaffController extends BaseController {

    // Pantalla principal del escáner
    public function index() {
        $data = [
            'titulo' => 'Validador de Tickets', //  cambiar este titulo por algo mejor 
            'instruccion' => 'Apunte al código QR del asistente'
        ];
        
        // Usamos un layout llamado 'staff' (sin sidebars)
        $this->render('staff/scanner', $data, 'staff');
    }

    // Proceso AJAX para validar el QR
    public function validarTicket() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigoQR = $_POST['qr_data'];
            $ventaModel = new Venta();
            
            // Lógica para marcar como "Ingresado"
            $resultado = $ventaModel->validarEntrada($codigoQR);
            
            header('Content-Type: application/json');
            echo json_encode($resultado);
        }
    }
}