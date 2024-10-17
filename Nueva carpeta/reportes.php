<?php
require 'db_connection.php';

class Reporte {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function generateFinancialReport() {
        $sql = "SELECT tipo, SUM(monto) as total FROM transacciones_financieras GROUP BY tipo";
        $result = $this->db->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function __destruct() {
        $this->db->close();
    }
}
?>
