<?php
namespace App\Controllers;

use App\Models\Evento;
use App\Models\Venta;

class AdminController extends BaseController {

    public function index() {
        // En una base de datos limpia, estos valores serán 0 o arrays vacíos
        $eventoModel = new Evento();
        $ventaModel = new Venta();

        $data = [
            'titulo' => 'Dashboard Principal',
            'usuario' => 'Administrador',
            'stats' => [
                'total_eventos' => $eventoModel->contarEventos() ?? 0,
                'total_ventas' => $ventaModel->contarVentasTotales() ?? 0,
                'ingresos' => $ventaModel->getIngresosGlobales() ?? 0,
                'eventos_recientes' => $eventoModel->getRecientes(5)
            ],
            'eventos_recientes' => $eventoModel->getRecientes(5) // Para mostrar algo en la tabla
        ];

        // Cargamos la vista 'admin/dashboard' usando el layout 'admin'
        $this->render('admin/dashboard', $data, 'admin');
    }

    public function crearEvento() {
        $data = ['titulo' => 'Crear Nuevo Evento'];
        $this->render('admin/nuevo_evento', $data, 'admin');
    }
     public function listarPagos() {
    $ventaModel = new \App\Models\Venta();
    
    $data = [
        'titulo' => 'Validación de Pagos',
        'pagos' => $ventaModel->getPagosPorRevisar()
    ];

    $this->render('admin/pagos_revision', $data, 'admin');
}

public function aprobarPago() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_venta = $_POST['id_venta'];
        $ventaModel = new \App\Models\Venta();

        if ($ventaModel->confirmarPago($id_venta)) {
            // Aquí es donde en el futuro dispararemos el Email/WhatsApp
            header('Location: /E-ticket/admin/pagos_pendientes?success=1');
        }
    }
}
    public function guardarEvento() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $eventoModel = new \App\Models\Evento();
        
        // Preparamos los datos del formulario
        $datos = [
            'nombre' => $_POST['nombre_evento'],
            'descripcion' => $_POST['descripcion'],
            'fecha' => $_POST['fecha_evento'],
            'lugar' => $_POST['lugar'],
            'precio' => $_POST['precio_boleta'],
            'stock' => $_POST['stock_total'],
            'imagen' => $_POST['imagen_url'] ?? 'default.jpg'
        ];

        if ($eventoModel->insertar($datos)) {
            header('Location: /E-ticket/admin/reportes');
        } else {
            die("Error al crear el evento");
        }
        }
    }
   public function reportes() {
    $eventoModel = new \App\Models\Evento();
    
    // Obtenemos todos los eventos (puedes crear un método getAll en el modelo)
    $eventos = $eventoModel->getRecientes(100); 

    $data = [
        'titulo' => 'Reportes de Eventos',
        'eventos' => $eventos
    ];

    $this->render('admin/reportes', $data, 'admin');
    }
    // funcion para ver los detalles de cada eventos, teniendo encuenta quienes han comprado
    public function verDetalle($id) {
    if (!$id) { header('Location: /E-ticket/admin/reportes'); exit; }

    $eventoModel = new \App\Models\Evento();
    $ventaModel = new \App\Models\Venta();

    $evento = $eventoModel->getPorId($id);
    
    // Si el evento no existe, volvemos atrás
    if (!$evento) { header('Location: /E-ticket/admin/reportes'); exit; }

    $data = [
        'titulo' => 'Gestión: ' . $evento['nombre_evento'],
        'evento' => $evento,
        'compradores' => $ventaModel->getVentasPorEvento($id),
        'stats' => [
            'ingreso_estimado' => ($evento['stock_total'] - $evento['stock_disponible']) * $evento['precio_boleta']
        ]
    ];

    $this->render('admin/detalle_evento', $data, 'admin');
}
}