<?php
/**
 * Restaurant Model
 * Manages restaurant/branch data
 */

class Restaurant {
    private $db;
    private $table = 'restaurant';
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (c_id, title, email, phone, url, o_hr, c_hr, o_days, address, image) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $this->db->query($sql, [
            $data['c_id'],
            $data['title'],
            $data['email'],
            $data['phone'],
            $data['url'],
            $data['o_hr'],
            $data['c_hr'],
            $data['o_days'],
            $data['address'],
            $data['image']
        ]);
        
        return $this->db->lastInsertId();
    }
    
    public function findById($id) {
        $sql = "SELECT r.*, c.c_name as category_name 
                FROM {$this->table} r 
                LEFT JOIN res_category c ON r.c_id = c.c_id 
                WHERE r.rs_id = ? LIMIT 1";
        return $this->db->query($sql, [$id])->fetch();
    }
    
    public function getAll($limit = null, $offset = 0) {
        $sql = "SELECT r.*, c.c_name as category_name 
                FROM {$this->table} r 
                LEFT JOIN res_category c ON r.c_id = c.c_id 
                ORDER BY r.rs_id DESC";
        
        if ($limit) {
            $sql .= " LIMIT ? OFFSET ?";
            return $this->db->query($sql, [$limit, $offset])->fetchAll();
        }
        
        return $this->db->query($sql)->fetchAll();
    }
    
    public function getByCategory($categoryId) {
        $sql = "SELECT * FROM {$this->table} WHERE c_id = ? ORDER BY rs_id DESC";
        return $this->db->query($sql, [$categoryId])->fetchAll();
    }
    
    public function update($id, $data) {
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            if ($key !== 'rs_id') {
                $fields[] = "{$key} = ?";
                $values[] = $value;
            }
        }
        
        $values[] = $id;
        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE rs_id = ?";
        
        $this->db->query($sql, $values);
        return $this->db->rowCount() > 0;
    }
    
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE rs_id = ?";
        $this->db->query($sql, [$id]);
        return $this->db->rowCount() > 0;
    }
    
    public function count() {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->db->query($sql)->fetch();
        return $result['total'];
    }
}
