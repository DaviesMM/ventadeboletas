<?php
namespace App\Controllers;

use App\Models\Evento;
use App\Models\Venta;
class AdminController extends Controller {
    
    
    private $eventoModel;

    
    public function __construct() {
        $this->eventoModel = new Evento();
    }

     private function verificarSesion() {
    if (session_status() === PHP_SESSION_NONE) session_start();
     
    if (!isset($_SESSION['user'])) {
        header("Location: /E-ticket/login");
        exit;
    }
     } 

    public function index() {
    // 1. Iniciamos sesión para poder leer los datos del usuario
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // 2. EL CANDADO: Si NO existe la sesión 'user', lo expulsamos
    if (!isset($_SESSION['user'])) {
        header("Location: /E-ticket/login");
        exit(); // CRÍTICO: Detiene la ejecución para que no cargue lo de abajo
    }

    // 3. Si pasó el candado, entonces sí buscamos los datos
    $ventaModel = new \App\Models\Venta();
    $data = [
        'resumen' => $ventaModel->getResumenVentas(),
        'asistentes' => $ventaModel->getListaAsistentes(),
        'titulo' => 'E-ticket | Panel de Control'
    ];

    $this->render('admin/dashboard', $data);
}
// Método para validar manualmente un ticket desde el formulario del admin
public function validarManual() {
    $this->verificarSesion();
    $idTicket = $_POST['id_ticket'] ?? null;
    
    if ($idTicket) {
        // Reutilizamos la lógica que ya creamos antes
        return $this->validarTicket($idTicket);
    }
    
    header("Location: /E-ticket/admin/dashboard");
}
/** funcion para validar los tickets */
    public function validarTicket($idVenta = null) {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 2. EL CANDADO: Si NO existe la sesión 'user', lo expulsamos
        if (!isset($_SESSION['user'])) {
            header("Location: /E-ticket/login");
            exit(); // CRÍTICO: Detiene la ejecución para que no cargue lo de abajo
        }
        if (!$idVenta) {
            die("ID de ticket no proporcionado.");
        }

        $ventaModel = new Venta();
        $ticket = $ventaModel->getDetalleTicket($idVenta);

        // Si el ticket no existe en la DB
        if (!$ticket) {
            $data = [
                'mensaje' => 'TICKET NO ENCONTRADO',
                'detalle' => 'Este código no existe en nuestro sistema.',
                'color' => 'bg-red-600'
            ];
        } 
        // Si ya fue usado
        elseif ($ticket['estado_asistencia'] === 'ingresado') {
            $data = [
                'mensaje' => 'ACCESO DENEGADO',
                'detalle' => 'Este ticket ya ingresó el: ' . date('d/m/Y H:i', strtotime($ticket['fecha_ingreso'])),
                'ticket' => $ticket,
                'color' => 'bg-orange-500'
            ];
        } 
        // Si es válido y está pendiente
        else {
            $ventaModel->marcarIngreso($idVenta);
            $data = [
                'mensaje' => '¡ACCESO CONCEDIDO!',
                'detalle' => 'Bienvenido a ' . $ticket['nombre_evento'],
                'ticket' => $ticket,
                'color' => 'bg-green-600'
            ];
        }

        $this->render('admin/resultado_scan', $data);
    }

// metodo para exportar archivos .csv
public function exportarExcel() {
    $this->verificarSesion();
    $ventaModel = new \App\Models\Venta();
    $asistentes = $ventaModel->getListaAsistentes();

    $filename = "asistentes_evento_" . date('Ymd') . ".csv";
    
    // Cabeceras para forzar la descarga
    header("Content-Type: text/csv; charset=utf-8");
    header("Content-Disposition: attachment; filename=$filename");

    $output = fopen("php://output", "w");
    
    // Títulos de las columnas
    fputcsv($output, ['ID Venta', 'Evento', 'Cliente', 'Cantidad', 'Estado', 'Fecha Ingreso']);

    foreach ($asistentes as $a) {
        fputcsv($output, [
            $a['id_venta'],
            $a['nombre_evento'],
            $a['nombre_cliente'],
            $a['cantidad'],
            $a['estado_asistencia'],
            $a['fecha_ingreso']
        ]);
    }
    fclose($output);
    exit();
}
// Método para mostrar la sección de gestión de eventos
   public function eventos() {
    $eventos = $this->eventoModel->getAll();
    $data = [
        'titulo' => 'E-ticket | Gestión de Eventos',
        'eventos' => $eventos
    ];
    $this->render('admin/eventos', $data);
}
// Método para mostrar la sección de reportes financieros
 public function reportes() {
    $this->verificarSesion();
    $db = (new \App\Core\Database())->getConnection();

    // Consultamos los eventos y calculamos sus métricas en una sola query
    $sql = "SELECT 
                e.id_evento, 
                e.nombre_evento, 
                e.stock_total,
                (SELECT SUM(cantidad) FROM ventas WHERE id_evento = e.id_evento) as vendidos,
                (SELECT SUM(cantidad) FROM ventas WHERE id_evento = e.id_evento AND estado_asistencia = 'ingresado') as ingresados
            FROM eventos e";
    
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $eventosData = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    $data = [
        'titulo' => 'Reportes por Evento',
        'eventos' => $eventosData
    ];

    $this->render('admin/reportes', $data);
}
public function verAsistentesPorEvento($idEvento) {
  
    $ventaModel = new \App\Models\Venta();
    $stats = $ventaModel->getStatsEvento($idEvento);
    $asistentes = $ventaModel->getAsistentesPorEvento($idEvento);

    if (!$stats) {
        header("Location: /E-ticket/admin/reportes");
        exit;
    }

    $data = [
        'titulo' => 'Detalle del Evento',
        'stats' => $stats,
        'asistentes' => $asistentes
    ];

    $this->render('admin/detalle_evento', $data);
}
 // Método para mostrar la sección de validadores/staff
    public function staff() {
        $data = ['titulo' => 'E-ticket | Validadores'];
        $this->render('admin/staff', $data);
    }

    // Método para guardar un nuevo evento desde el formulario del admin
    public function guardar() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lógica básica para subir imagen
        $nombreImagen = "";
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            $nombreImagen = time() . "_" . $_FILES['imagen']['name'];
            move_uploaded_file($_FILES['imagen']['tmp_name'], "../public/img/eventos/" . $nombreImagen);
        }

        $this->eventoModel->crear([
            'nombre' => $_POST['nombre'],
            'fecha'  => $_POST['fecha'],
            'lugar'  => $_POST['lugar'],
            'precio' => $_POST['precio'],
            'stock'  => $_POST['stock'],
            'imagen' => $nombreImagen
        ]);

        header("Location: /E-ticket/admin"); // Redirigir al terminar
    }
}


} // final class adminController