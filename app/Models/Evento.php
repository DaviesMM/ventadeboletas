<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Evento {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function contarEventos() {
        $sql = "SELECT COUNT(*) as total FROM eventos";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getRecientes($limite = 5) {
        $sql = "SELECT * FROM eventos ORDER BY id_evento DESC LIMIT :limite";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
public function insertar($datos) {
    $sql = "INSERT INTO eventos (
                nombre_evento, 
                descripcion, 
                fecha_evento, 
                lugar, 
                precio_boleta, 
                stock_total, 
                stock_disponible, 
                estado, 
                imagen_url
            ) VALUES (
                :nombre, 
                :desc, 
                :fecha, 
                :lugar, 
                :precio, 
                :stock_total, 
                :stock_disponible, 
                'activo', 
                :img
            )";
    
    $stmt = $this->db->prepare($sql);
    
    return $stmt->execute([
        ':nombre'           => $datos['nombre'],
        ':desc'             => $datos['descripcion'],
        ':fecha'            => $datos['fecha'],
        ':lugar'            => $datos['lugar'],
        ':precio'           => $datos['precio'],
        ':stock_total'      => $datos['stock'], // El total definido por el admin
        ':stock_disponible' => $datos['stock'], // Al inicio, disponible es igual al total
        ':img'              => $datos['imagen']
    ]);
    }
    public function getPorId($id) {
    $sql = "SELECT * FROM eventos WHERE id_evento = :id";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

    public function eliminar($id) {
    $sql = "DELETE FROM eventos WHERE id_evento = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([':id' => $id]);
}
// solo trae los eventos activos 
 public function getEventosActivos() {
    $sql = "SELECT * FROM eventos WHERE estado = 'activo' AND stock_disponible > 0 ORDER BY fecha_evento ASC";
    return $this->db->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
}
} // fin de la clase