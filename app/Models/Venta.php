<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Venta {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }
 // contar las ventas totales 
    public function contarVentasTotales() {
        // Contamos la suma de boletas vendidas, no solo el número de transacciones
        $sql = "SELECT SUM(cantidad) as total FROM ventas";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
 // cuanto dinero entra o cuanto a ingresado
    public function getIngresosGlobales() {
        $sql = "SELECT SUM(total) as total_dinero FROM ventas";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_dinero'] ?? 0;
    }
    // llamar a todas las venta de cada evento
    public function getVentasPorEvento($id) {
        $sql = "SELECT * FROM ventas WHERE id_evento = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
     public function crearVenta($d) {
    try {
        $this->db->beginTransaction();

        // 1. Insertar la venta (con tus campos reales)
        $sql = "INSERT INTO ventas (id_evento, nombre_cliente, email_cliente, telefono_cliente, cantidad, total, estado_asistencia, fecha, metodo_pago, estado_pago) 
                VALUES (:id_e, :nom, :em, :tel, :cant, :total, 'pendiente', NOW(), :met, 'completado')";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_e'  => $d['id_evento'],
            ':nom'   => $d['nombre'],
            ':em'    => $d['email'],
            ':tel'   => $d['telefono'],
            ':cant'  => $d['cantidad'],
            ':total' => $d['total'],
            ':met'   => $d['metodo']
        ]);

        $idVenta = $this->db->lastInsertId();

        // 2. Restar el stock disponible en la tabla eventos
        $updateStock = "UPDATE eventos SET stock_disponible = stock_disponible - :cant WHERE id_evento = :id_e";
        $stmtStock = $this->db->prepare($updateStock);
        $stmtStock->execute([':cant' => $d['cantidad'], ':id_e' => $d['id_evento']]);

        $this->db->commit();
        return $idVenta;

    } catch (\Exception $e) {
        $this->db->rollBack();
        return false;
    }
}
public function crearVentaPendiente($d) {
    try {
        $sql = "INSERT INTO ventas (
                    id_evento, nombre_cliente, email_cliente, telefono_cliente, 
                    cantidad, total, estado_asistencia, fecha, 
                    metodo_pago, estado_pago, referencia_pago, comprobante
                ) VALUES (
                    :id_e, :nom, :em, :tel, 
                    :cant, :total, 'pendiente', NOW(), 
                    :met, 'revision', :ref, :comp
                )";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id_e'  => $d['id_evento'],
            ':nom'   => $d['nombre'],
            ':em'    => $d['email'],
            ':tel'   => $d['telefono'],
            ':cant'  => $d['cantidad'],
            ':total' => $d['total'],
            ':met'   => $d['metodo'],
            ':ref'   => $d['referencia'],
            ':comp'  => $d['comprobante']
        ]);
    } catch (\Exception $e) {
        return false;
    }
}
  public function validarEntrada($idVenta) {
    // 1. Buscamos la venta por su ID
    $sql = "SELECT id_venta, nombre_cliente, estado_asistencia 
            FROM ventas 
            WHERE id_venta = :id";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $idVenta]);
    $venta = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($venta) {
        // 2. Verificamos si ya ingresó
        if ($venta['estado_asistencia'] === 'ingresado') {
            return [
                'status' => 'error', 
                'message' => 'ESTE TICKET YA FUE USADO por ' . $venta['nombre_cliente']
            ];
        }

        // 3. Si está pendiente, marcamos el ingreso
        $update = "UPDATE ventas 
                   SET estado_asistencia = 'ingresado', 
                       fecha_ingreso = NOW() 
                   WHERE id_venta = :id";
        
        $this->db->prepare($update)->execute([':id' => $idVenta]);
        
        return [
            'status' => 'success', 
            'message' => '¡BIENVENIDO! ' . $venta['nombre_cliente']
        ];
    }

    // 4. Si el ID no existe en la tabla
    return ['status' => 'error', 'message' => 'TICKET NO ENCONTRADO'];
}

public function getPagosPorRevisar() {
    $sql = "SELECT v.*, e.nombre_evento 
            FROM ventas v 
            JOIN eventos e ON v.id_evento = e.id_evento 
            WHERE v.estado_pago = 'revision' 
            ORDER BY v.fecha DESC";
    return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
}

public function confirmarPago($id) {
    // Al confirmar, pasamos de 'revision' a 'completado'
    $sql = "UPDATE ventas SET estado_pago = 'completado' WHERE id_venta = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([':id' => $id]);
}

public function rechazarPago() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_venta = $_POST['id_venta'];
        $motivo = $_POST['motivo'];
        
        $ventaModel = new \App\Models\Venta();
        
        // Cambiamos el estado a 'rechazado' y guardamos el motivo
        if ($ventaModel->registrarRechazo($id_venta, $motivo)) {
            header('Location: /E-ticket/admin/pagos_pendientes?error=rechazado');
        }
    }
}
public function registrarRechazo($id, $motivo) {
    try {
        $this->db->beginTransaction();

        // 1. Traer info de la venta antes de cambiarla
        $sqlVenta = "SELECT id_evento, cantidad FROM ventas WHERE id_venta = :id";
        $stmt = $this->db->prepare($sqlVenta);
        $stmt->execute([':id' => $id]);
        $venta = $stmt->fetch(\PDO::FETCH_ASSOC);

        // 2. Cambiar estado a rechazado (necesitarás crear esta columna o usar estado_pago)
        $update = "UPDATE ventas SET estado_pago = 'rechazado' WHERE id_venta = :id";
        $this->db->prepare($update)->execute([':id' => $id]);

        // 3. REGRESAR EL STOCK AL EVENTO
        $restaurarStock = "UPDATE eventos SET stock_disponible = stock_disponible + :cant WHERE id_evento = :id_e";
        $this->db->prepare($restaurarStock)->execute([
            ':cant' => $venta['cantidad'], 
            ':id_e' => $venta['id_evento']
        ]);

        $this->db->commit();
        return true;
    } catch (\Exception $e) {
        $this->db->rollBack();
        return false;
    }
}
}