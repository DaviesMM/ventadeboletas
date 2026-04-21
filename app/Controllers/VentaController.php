<?php
namespace App\Controllers;

use App\Models\Evento;
use App\Models\Venta;

class VentaController extends Controller {

private function verificarSesion() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    
    if (!isset($_SESSION['user'])) {
        header("Location: /E-ticket/login");
        exit;
    }
}
    // PASO 1: Mostrar la pantalla de pago
  // Este método SOLO debe mostrar el formulario
public function checkout($id = null) {
    if (!$id) {
        header("Location: /E-ticket/");
        exit;
    }

    $eventoModel = new \App\Models\Evento();
    $evento = $eventoModel->getById($id);

    if (!$evento) {
        die("El evento no existe.");
    }

    // PASO CLAVE: Solo cargamos la vista, no registramos nada aún
    $data = [
        'titulo' => 'Finalizar Compra | E-ticket',
        'evento' => $evento
    ];

    $this->render('cliente/checkout', $data);
}
    // PASO 2: Procesar la transacción (Cuando el usuario de clic en "Pagar")
  public function procesarPago() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // VERIFICA: Que los nombres dentro de $_POST['...'] coincidan con el 'name' de tus inputs en el formulario
        $id_evento = $_POST['id_evento'];
        $cantidad  = $_POST['cantidad'];
        $nombre    = $_POST['nombre'];
        $email     = $_POST['email'];
        $telefono  = $_POST['telefono'];

        $ventaModel = new \App\Models\Venta();
        
        // Buscamos el precio para calcular el total real
        $eventoModel = new \App\Models\Evento();
        $evento = $eventoModel->getById($id_evento);
        $total = $evento['precio_boleta'] * $cantidad;

        $idVenta = $ventaModel->registrarCompleto($id_evento, $nombre, $email, $telefono, $cantidad, $total);

        if ($idVenta) {
            header("Location: /E-ticket/ticket/" . $idVenta);
            exit;
        } else {
            // Si entras aquí, es porque registrarCompleto devolvió false o 0
            die("Error: El modelo no pudo registrar la venta.");
        }
    }
}

 // metodo para mostrar el ticket al usuario después de la compra
 public function ticket($idVenta = null) {
    if (!$idVenta) {
        header("Location: /E-ticket/?error=no_id");
        exit;
    }

    $ventaModel = new \App\Models\Venta();
    $datosTicket = $ventaModel->getDetalleTicket($idVenta);

    if (!$datosTicket) {
        die("Error crítico: La venta #$idVenta no existe en la base de datos.");
    }

    $data = [
        'titulo' => 'Tu E-Ticket | E-ticket',
        'ticket' => $datosTicket
    ];
    
    $this->render('cliente/ticket', $data);
}
}