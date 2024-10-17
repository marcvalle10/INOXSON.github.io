<?php
class Database {
    private $host = "localhost";
    private $db_name = "inoxson2";
    private $username = "root";
    private $password = "";
    public $conn;

    public function __construct() {
        $dsn = 'mysql:host=localhost;dbname=inoxson2;charset=utf8';
        $username = 'root';
        $password = '';

        try {
            $this->conn = new PDO($dsn, $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function getConnection() {
        $this->conn = null;
        try {
            // Usamos PDO para conectar
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            // Establecemos el modo de error de PDO para que lance excepciones en caso de error
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
    }

    public function closeConnection() {
        $this->conn = null; // Cerrar la conexión estableciendo a null
    }
}
?>
