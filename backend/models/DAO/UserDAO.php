<?php
include_once __DIR__ . '../../../config/db.php';

include_once __DIR__ . '../../../models/DTO/UseDTO.php';

class UserDAO {
    private $conn;
    private $table_name = "User";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($user) {
        $query = "INSERT INTO " . $this->table_name . " (username, password_hash, role, email, nome, contato) VALUES (:username, :password_hash, :role, :email, :nome, :contato)";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":username", $user->username);
        $stmt->bindParam(":password_hash", $user->password_hash);
        $stmt->bindParam(":role", $user->role);
        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":nome", $user->nome);
        $stmt->bindParam(":contato", $user->contato);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    public function findByEmail($email) {
        $stmt = $this->conn->prepare('SELECT * FROM User WHERE email = :email');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function read($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        return null;
    }

    public function update($user) {
        $query = "UPDATE " . $this->table_name . " SET username = :username, password_hash = :password_hash, role = :role, email = :email, nome = :nome, contato = :contato WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":username", $user->username);
        $stmt->bindParam(":password_hash", $user->password_hash);
        $stmt->bindParam(":role", $user->role);
        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":nome", $user->nome);
        $stmt->bindParam(":contato", $user->contato);
        $stmt->bindParam(":id", $user->id);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);

        return $stmt->execute();

        // if ($stmt->execute()) {
        //     return true;
        // }

        // return false;
    }
}
?>
