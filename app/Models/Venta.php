<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Venta {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function contarVentasTotales() {
        // Contamos la suma de boletas vendidas, no solo el número de transacciones
        $sql = "SELECT SUM(cantidad) as total FROM ventas";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function getIngresosGlobales() {
        $sql = "SELECT SUM(total) as total_dinero FROM ventas";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_dinero'] ?? 0;
    }
}