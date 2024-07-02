<?php 

class Database {
    private $host = "127.0.0.1:3308"; // Host e porta corretos do seu MySQL/MariaDB
    private $db_name = "api_condiminio";
    private $username = "root";
    private $password = "instalar";
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db_name};charset=utf8", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Erro de conexão: " . $e->getMessage();
        }

        return $this->conn;
    }
}

?>