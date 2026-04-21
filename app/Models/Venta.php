<?php
namespace App\Models;

use PDO;

class Venta extends Model {
    // funcion para registrar una venta
    public function registrar($id_evento, $precio) {
        // 1. Insertar la venta
        $sqlVenta = "INSERT INTO ventas (id_evento, cantidad, total, fecha) VALUES (:id, 1, :total, NOW())";
        $stmtVenta = $this->db->prepare($sqlVenta);
        $stmtVenta->execute([':id' => $id_evento, ':total' => $precio]);

        // 2. Restar 1 al stock disponible del evento
        $sqlStock = "UPDATE eventos SET stock_disponible = stock_disponible - 1 WHERE id_evento = :id";
        $stmtStock = $this->db->prepare($sqlStock);
        $stmtStock->execute([':id' => $id_evento]);

        return true;
    }
        // función para obtener los detalles del ticket después de la compra
    public function getDetalleTicket($idVenta) {
    // Cambiamos INNER JOIN por LEFT JOIN solo para probar. 
    // Si aparece el ticket sin la imagen del evento, es que el ID del evento estaba mal.
    $sql = "SELECT v.*, e.nombre_evento, e.fecha_evento, e.lugar, e.imagen_url 
            FROM ventas v 
            LEFT JOIN eventos e ON v.id_evento = e.id_evento 
            WHERE v.id_venta = :id";
            
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $idVenta]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

public function registrarCompleto($id_evento, $nombre, $email, $telefono, $cantidad, $total) {
    try {
        $sql = "INSERT INTO ventas (id_evento, nombre_cliente, email_cliente, telefono_cliente, cantidad, total) 
                VALUES (:id, :nom, :em, :tel, :cant, :tot)";
        
        $stmt = $this->db->prepare($sql);
        $resultado = $stmt->execute([
            ':id'   => $id_evento,
            ':nom'  => $nombre,
            ':em'   => $email,
            ':tel'  => $telefono,
            ':cant' => $cantidad,
            ':tot'  => $total
        ]);

        if ($resultado) {
            // Verificamos el ID generado
            $idVenta = $this->db->lastInsertId();
            
            // Si el ID es 0, es que la tabla no tiene AUTO_INCREMENT
            if ($idVenta == 0) {
                die("Error: La venta se insertó pero el ID es 0. Revisa que 'id_venta' sea AUTO_INCREMENT en MySQL.");
            }

            // Actualizamos el stock
            $sqlStock = "UPDATE eventos SET stock_disponible = stock_disponible - :cant WHERE id_evento = :id";
            $this->db->prepare($sqlStock)->execute([':cant' => $cantidad, ':id' => $id_evento]);
            
            return $idVenta;
        }
        
        return false;

    } catch (\PDOException $e) {
        die("Fallo Fatal en SQL: " . $e->getMessage());
    }
}
// funcion para obtener un resumen de ventas totales, personas y recaudación
public function getResumenVentas() {
    // Esta consulta nos da el dinero total, entradas vendidas y cuántos ya entraron
    $sql = "SELECT 
                COUNT(id_venta) as total_tickets,
                SUM(cantidad) as total_personas,
                SUM(total) as recaudado,
                SUM(CASE WHEN estado_asistencia = 'ingresado' THEN 1 ELSE 0 END) as asistencias
            FROM ventas";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
// Función para obtener estadísticas de asistencia de un evento
public function getEstadisticasAsistencia($idEvento) {
    $sql = "SELECT 
                COUNT(*) as total_vendidos,
                SUM(CASE WHEN estado_asistencia = 'ingresado' THEN 1 ELSE 0 END) as total_ingresados,
                SUM(cantidad) as total_personas_esperadas
            FROM ventas 
            WHERE id_evento = :id";
            
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $idEvento]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
// funcion para marcar los ingreso 
public function marcarIngreso($idVenta) {
    $sql = "UPDATE ventas 
            SET estado_asistencia = 'ingresado', 
                fecha_ingreso = NOW() 
            WHERE id_venta = :id";
            
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([':id' => $idVenta]);
}
 // funciones ver el listado de asistentes de cada evento
    public function getListaAsistentes() {
    
    $sql = "SELECT v.id_venta, v.nombre_cliente, v.cantidad, v.estado_asistencia, 
                   v.fecha_ingreso, e.nombre_evento 
            FROM ventas v
            JOIN eventos e ON v.id_evento = e.id_evento
            ORDER BY v.fecha_ingreso DESC, v.id_venta DESC";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }



    
} // fin de la clase Venta