<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Model {
    protected $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
}