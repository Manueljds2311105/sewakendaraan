<?php
class User {
    private $conn;
    private $table = 'users';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        if($stmt->rowCount() > 0) {
            $user = $stmt->fetch();
            if(password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }

    public function getAllUsers() {
        $query = "SELECT id, username, nama_lengkap, email, role, created_at FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUserById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function createUser($data) {
        $query = "INSERT INTO " . $this->table . " (username, password, nama_lengkap, email, role) 
                  VALUES (:username, :password, :nama_lengkap, :email, :role)";
        $stmt = $this->conn->prepare($query);
        
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':nama_lengkap', $data['nama_lengkap']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':role', $data['role']);
        
        return $stmt->execute();
    }

    public function updateUser($id, $data) {
        if(!empty($data['password'])) {
            $query = "UPDATE " . $this->table . " 
                      SET username = :username, password = :password, nama_lengkap = :nama_lengkap, 
                          email = :email, role = :role 
                      WHERE id = :id";
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        } else {
            $query = "UPDATE " . $this->table . " 
                      SET username = :username, nama_lengkap = :nama_lengkap, 
                          email = :email, role = :role 
                      WHERE id = :id";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':nama_lengkap', $data['nama_lengkap']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':id', $id);
        
        if(!empty($data['password'])) {
            $stmt->bindParam(':password', $hashedPassword);
        }
        
        return $stmt->execute();
    }

    public function deleteUser($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>