<!-- Database connection  -->
 <!-- we use PDO model based database querires its just like mongoose_db and its secured prevents SQL-INJECTION-->

 <?php
class Database {
    private $host = "localhost";
    private $db_name = "todo_app";
    private $username = "root"; 
    private $password = "";   
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // This is the connection string (DSN)
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
            // Set error mode to exception for easier debugging
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>