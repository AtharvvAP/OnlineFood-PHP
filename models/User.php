<?php
/**
 * User Model
 * Modern OOP approach with security best practices
 */

class User {
    private $db;
    private $table = 'users';
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (username, f_name, l_name, email, phone, password, address) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $hashedPassword = password_hash($data['password'], PASSWORD_HASH_ALGO, ['cost' => PASSWORD_HASH_COST]);
        
        $this->db->query($sql, [
            $data['username'],
            $data['f_name'],
            $data['l_name'],
            $data['email'],
            $data['phone'],
            $hashedPassword,
            $data['address']
        ]);
        
        return $this->db->lastInsertId();
    }
    
    public function findByUsername($username) {
        $sql = "SELECT * FROM {$this->table} WHERE username = ? LIMIT 1";
        return $this->db->query($sql, [$username])->fetch();
    }
    
    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ? LIMIT 1";
        return $this->db->query($sql, [$email])->fetch();
    }
    
    public function findById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE u_id = ? LIMIT 1";
        return $this->db->query($sql, [$id])->fetch();
    }
    
    public function authenticate($username, $password) {
        $user = $this->findByUsername($username);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    public function getAll($limit = null, $offset = 0) {
        $sql = "SELECT u_id, username, f_name, l_name, email, phone, address, date 
                FROM {$this->table} ORDER BY date DESC";
        
        if ($limit) {
            $sql .= " LIMIT ? OFFSET ?";
            return $this->db->query($sql, [$limit, $offset])->fetchAll();
        }
        
        return $this->db->query($sql)->fetchAll();
    }
    
    public function update($id, $data) {
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            if ($key !== 'u_id' && $key !== 'password') {
                $fields[] = "{$key} = ?";
                $values[] = $value;
            }
        }
        
        $values[] = $id;
        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE u_id = ?";
        
        $this->db->query($sql, $values);
        return $this->db->rowCount() > 0;
    }
    
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE u_id = ?";
        $this->db->query($sql, [$id]);
        return $this->db->rowCount() > 0;
    }
    
    public function count() {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->db->query($sql)->fetch();
        return $result['total'];
    }
}
