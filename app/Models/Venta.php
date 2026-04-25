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
}