<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    // Configuración de la base de datos
    private $host = "localhost";
    private $db_name = "ticket_stream_db";
    private $username = "root"; // Cambia si tienes contraseña en MySQL
    private $password = ""; 
    public $conn;
    // funcion para hacer la conexion
    public function getConnection() {
        $this->conn = null;
        // verifica si la conexion es exitosa o no
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            // Esto obliga a MySQL a usar UTF-8 y a lanzar errores si algo falla
            $this->conn->exec("set names utf8mb4");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            // Envia una excepcion o error si la conexion falla 
            echo "Error de conexión: " . $exception->getMessage();
        }
        // retorna la conexion a la base de datos
        return $this->conn;
    }
}