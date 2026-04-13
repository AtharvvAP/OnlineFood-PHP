<?php
/**
 * Dish Model
 * Handles all dish/menu operations
 */

class Dish {
    private $db;
    private $table = 'dishes';
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (rs_id, title, slogan, price, img, discount) 
                VALUES (?, ?, ?, ?, ?, ?)";
        
        $this->db->query($sql, [
            $data['rs_id'],
            $data['title'],
            $data['slogan'],
            $data['price'],
            $data['img'],
            $data['discount'] ?? 0
        ]);
        
        return $this->db->lastInsertId();
    }
    
    public function findById($id) {
        $sql = "SELECT d.*, r.title as restaurant_name 
                FROM {$this->table} d 
                LEFT JOIN restaurant r ON d.rs_id = r.rs_id 
                WHERE d.d_id = ? LIMIT 1";
        return $this->db->query($sql, [$id])->fetch();
    }
    
    public function getAll($limit = null, $offset = 0) {
        $sql = "SELECT d.*, r.title as restaurant_name 
                FROM {$this->table} d 
                LEFT JOIN restaurant r ON d.rs_id = r.rs_id 
                ORDER BY d.d_id DESC";
        
        if ($limit) {
            $sql .= " LIMIT ? OFFSET ?";
            return $this->db->query($sql, [$limit, $offset])->fetchAll();
        }
        
        return $this->db->query($sql)->fetchAll();
    }
    
    public function getByRestaurant($restaurantId, $limit = null) {
        $sql = "SELECT * FROM {$this->table} WHERE rs_id = ? ORDER BY d_id DESC";
        
        if ($limit) {
            $sql .= " LIMIT ?";
            return $this->db->query($sql, [$restaurantId, $limit])->fetchAll();
        }
        
        return $this->db->query($sql, [$restaurantId])->fetchAll();
    }
    
    public function getPopular($limit = 6) {
        $sql = "SELECT d.*, r.title as restaurant_name,
                (SELECT COUNT(*) FROM users_orders WHERE title = d.title) as order_count
                FROM {$this->table} d 
                LEFT JOIN restaurant r ON d.rs_id = r.rs_id 
                ORDER BY order_count DESC, d.d_id DESC 
                LIMIT ?";
        
        return $this->db->query($sql, [$limit])->fetchAll();
    }
    
    public function getDiscounted($limit = null) {
        $sql = "SELECT d.*, r.title as restaurant_name 
                FROM {$this->table} d 
                LEFT JOIN restaurant r ON d.rs_id = r.rs_id 
                WHERE d.discount > 0 
                ORDER BY d.discount DESC";
        
        if ($limit) {
            $sql .= " LIMIT ?";
            return $this->db->query($sql, [$limit])->fetchAll();
        }
        
        return $this->db->query($sql)->fetchAll();
    }
    
    public function update($id, $data) {
        $fields = [];
        $values = [];
        
        foreach ($data as $key => $value) {
            if ($key !== 'd_id') {
                $fields[] = "{$key} = ?";
                $values[] = $value;
            }
        }
        
        $values[] = $id;
        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE d_id = ?";
        
        $this->db->query($sql, $values);
        return $this->db->rowCount() > 0;
    }
    
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE d_id = ?";
        $this->db->query($sql, [$id]);
        return $this->db->rowCount() > 0;
    }
    
    public function count() {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->db->query($sql)->fetch();
        return $result['total'];
    }
    
    public function calculateDiscountedPrice($price, $discount) {
        if ($discount > 0) {
            return $price - ($price * $discount / 100);
        }
        return $price;
    }
}
