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
public function crearVentaPendiente($datos) {
    try {
        $this->db->beginTransaction();

        // Insertar la venta con estado pendiente
        $sql = "INSERT INTO ventas (id_evento, nombre_cliente, email_cliente, telefono_cliente, cantidad, total, estado_asistencia, fecha, metodo_pago, estado_pago) 
                VALUES (:id_e, :nom, :em, :tel, :cant, :total, 'pendiente', NOW(), :met, 'pendiente')";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id_e'  => $datos['id_evento'],
            ':nom'   => $datos['nombre'],
            ':em'    => $datos['email'],
            ':tel'   => $datos['telefono'],
            ':cant'  => $datos['cantidad'],
            ':total' => $datos['total'],
            ':met'   => $datos['metodo']
        ]);

        $idVenta = $this->db->lastInsertId();

        // Restar el stock disponible en la tabla eventos
        $updateStock = "UPDATE eventos SET stock_disponible = stock_disponible - :cant WHERE id_evento = :id_e";
        $stmtStock = $this->db->prepare($updateStock);
        $stmtStock->execute([':cant' => $datos['cantidad'], ':id_e' => $datos['id_evento']]);

        $this->db->commit();
        return $idVenta;

    } catch (\Exception $e) {
        $this->db->rollBack();
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
}