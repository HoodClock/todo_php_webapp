<!-- Model & Controller Logic (CRUD-operations) -->

<?php
class Todo {
    private $conn;
    private $table_name = "tasks";

    public function __construct($db) {
        $this->conn = $db;
    }

    // READ (Get all tasks)
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // CREATE
    public function create($title) {
        $query = "INSERT INTO " . $this->table_name . " (title) VALUES (:title)";
        $stmt = $this->conn->prepare($query);
        
        // Sanitize
        $title = htmlspecialchars(strip_tags($title));
        
        // Bind Param (Prevents SQL Injection)
        $stmt->bindParam(":title", $title);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>