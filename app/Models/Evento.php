<?php
namespace App\Models;

use PDO;

class Evento extends Model {
    
    // Obtener todos los eventos activos para la página principal
    public function getAllActive() {
        $sql = "SELECT * FROM eventos WHERE estado = 'activo' ORDER BY fecha_evento ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // llamar los eventos por id para mostrar los detalles del evento en la página de compra
    public function getById($id) {
    $sql = "SELECT * FROM eventos WHERE id_evento = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener estadísticas rápidas para el Dashboard del Admin
    public function getStats() {
    // Obtenemos total de eventos, total de tickets vendidos y RECAUDACIÓN TOTAL
    $sql = "SELECT 
                (SELECT COUNT(*) FROM eventos) as total_eventos,
                (SELECT SUM(cantidad) FROM ventas) as total_vendido,
                (SELECT SUM(total) FROM ventas) as recaudacion_total";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
    /* funcion para crear los eventos desde el admin, 
    // recibe un array con los datos del evento y lo inserta en la base de datos. */
    
    public function crear($datos) {
    $sql = "INSERT INTO eventos (nombre_evento, fecha_evento, lugar, precio_boleta, stock_total, stock_disponible, imagen_url, estado) 
            VALUES (:nombre, :fecha, :lugar, :precio, :stock, :stock, :imagen, 'activo')";
    
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':nombre' => $datos['nombre'],
        ':fecha'  => $datos['fecha'],
        ':lugar'  => $datos['lugar'],
        ':precio' => $datos['precio'],
        ':stock'  => $datos['stock'],
        ':imagen' => $datos['imagen']
    ]);
   }
 // Esta función para obtener todos los eventos, sin importar su estado, para mostrar en el admin.
   public function getAll() {
    $sql = "SELECT * FROM eventos ORDER BY fecha_evento DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

} //fin de clase eventos