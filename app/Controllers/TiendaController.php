<?php
namespace App\Controllers;

use App\Models\Evento;
use App\Models\Venta;

class TiendaController extends BaseController {

    public function index() {
        $eventoModel = new Evento();
        
        $data = [
            'titulo' => 'Próximos Eventos',
            'eventos' => $eventoModel->getEventosActivos()
        ];

        // Usaremos un layout diferente para la tienda (más limpio)
        $this->render('tienda/home', $data, 'publico');
    }

    public function verEvento($id) {
        $eventoModel = new Evento();
        $evento = $eventoModel->getPorId($id);

        if (!$evento || $evento['estado'] !== 'activo') {
            header('Location: /E-ticket/');
            exit;
        }

        $data = [
            'titulo' => $evento['nombre_evento'],
            'evento' => $evento
        ];
        $this->render('tienda/detalle', $data, 'publico');
    }
/**
 * Método para mostrar las instrucciones de pago 
 * (Nequi/Daviplata o Banco) antes de guardar en la BD
 */
public function confirmacionPago() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $id_evento = $_POST['id_evento'];
        
        // Si por alguna razón el hidden falla, lo pedimos al modelo
        $precio_unitario = $_POST['precio_unitario'] ?? null;
        
        if (!$precio_unitario) {
            $eventoModel = new \App\Models\Evento();
            $evento = $eventoModel->getPorId($id_evento);
            $precio_unitario = $evento['precio_boleta'];
        }

        $cantidad = $_POST['cantidad'];
        $total = $cantidad * $precio_unitario;

        $data = [
            'id_evento' => $id_evento,
            'nombre_cliente' => $_POST['nombre_cliente'],
            'email_cliente' => $_POST['email_cliente'],
            'telefono_cliente' => $_POST['telefono_cliente'],
            'cantidad' => $cantidad,
            'metodo' => $_POST['metodo_pago'],
            'total' => $total,
            'titulo' => 'Confirmar su Pago'
        ];

        $this->render('tienda/confirmacion', $data, 'publico');
    }
}
    public function procesarCompra() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ventaModel = new \App\Models\Venta();
        $eventoModel = new \App\Models\Evento();

        $id_evento = $_POST['id_evento'];
        $cantidad = $_POST['cantidad'];
        
        // Traemos datos del evento para calcular el total
        $evento = $eventoModel->getPorId($id_evento);
        $total = $evento['precio_boleta'] * $cantidad;

        $datosVenta = [
            'id_evento' => $id_evento,
            'nombre'    => $_POST['nombre_cliente'],
            'email'     => $_POST['email_cliente'],
            'telefono'  => $_POST['telefono_cliente'],
            'cantidad'  => $cantidad,
            'total'     => $total,
            'metodo'    => $_POST['metodo_pago']
        ];

        $idNuevaVenta = $ventaModel->crearVenta($datosVenta);

        if ($idNuevaVenta) {
            // Redirigir a una página de éxito o mostrar el ticket
            header("Location: /E-ticket/compra/exito/" . $idNuevaVenta);
        } else {
            die("Error al procesar la compra. Revisa el stock disponible.");
        }
    }
  }
  public function finalizarRegistro() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $ventaModel = new \App\Models\Venta();
        
        // Guardamos los datos incluyendo la referencia y preparamos el estado
        // estado_pago: 'pendiente' hasta que el admin revise el comprobante
        $datos = [
            'id_evento' => $_POST['id_evento'],
            'nombre'    => $_POST['nombre_cliente'],
            'email'     => $_POST['email_cliente'],
            'telefono'  => $_POST['telefono_cliente'],
            'cantidad'  => $_POST['cantidad'],
            'total'     => $_POST['total_oculto'],
            'metodo'    => $_POST['metodo_pago'],
            'referencia'=> $_POST['referencia_pago'] ?? '',
            'estado_pago' => 'revision' 
        ];

        // Manejo de la imagen del comprobante si existe
        if (isset($_FILES['comprobante']) && $_FILES['comprobante']['error'] === 0) {
            $ruta = 'public/uploads/pagos/' . time() . "_" . $_FILES['comprobante']['name'];
            $directorio = 'uploads/pagos/';

            // Si la carpeta no existe, la creamos con permisos (0777)
            if (!is_dir($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $ruta = $directorio . time() . "_" . $_FILES['comprobante']['name'];

            if (move_uploaded_file($_FILES['comprobante']['tmp_name'], $ruta)) {
                $datos['comprobante'] = $ruta;
            } else {
                move_uploaded_file($_FILES['comprobante']['tmp_name'], $ruta);
                $datos['comprobante'] = $ruta;
            }
            
        }

        $idVenta = $ventaModel->crearVentaPendiente($datos);

        if ($idVenta) {
            $this->render('tienda/espera_pago', ['titulo' => 'Procesando Pago'], 'publico');
        }
    }
   }
}