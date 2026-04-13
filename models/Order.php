<?php
/**
 * Order Model
 * Handles order management and tracking
 */

class Order {
    private $db;
    private $table = 'users_orders';
    
    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROCESS = 'in process';
    const STATUS_CLOSED = 'closed';
    const STATUS_REJECTED = 'rejected';
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function create($userId, $items) {
        $this->db->beginTransaction();
        
        try {
            foreach ($items as $item) {
                $sql = "INSERT INTO {$this->table} (u_id, title, quantity, price, status, date) 
                        VALUES (?, ?, ?, ?, ?, NOW())";
                
                $this->db->query($sql, [
                    $userId,
                    $item['title'],
                    $item['quantity'],
                    $item['price'],
                    self::STATUS_PENDING
                ]);
            }
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            error_log("Order Creation Error: " . $e->getMessage());
            return false;
        }
    }
    
    public function findById($id) {
        $sql = "SELECT o.*, u.username, u.email, u.phone, u.address 
                FROM {$this->table} o 
                LEFT JOIN users u ON o.u_id = u.u_id 
                WHERE o.o_id = ? LIMIT 1";
        return $this->db->query($sql, [$id])->fetch();
    }
    
    public function getByUser($userId, $limit = null, $offset = 0) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE u_id = ? 
                ORDER BY date DESC";
        
        if ($limit) {
            $sql .= " LIMIT ? OFFSET ?";
            return $this->db->query($sql, [$userId, $limit, $offset])->fetchAll();
        }
        
        return $this->db->query($sql, [$userId])->fetchAll();
    }
    
    public function getAll($limit = null, $offset = 0) {
        $sql = "SELECT o.*, u.username, u.email, u.phone 
                FROM {$this->table} o 
                LEFT JOIN users u ON o.u_id = u.u_id 
                ORDER BY o.date DESC";
        
        if ($limit) {
            $sql .= " LIMIT ? OFFSET ?";
            return $this->db->query($sql, [$limit, $offset])->fetchAll();
        }
        
        return $this->db->query($sql)->fetchAll();
    }
    
    public function updateStatus($id, $status) {
        $validStatuses = [self::STATUS_PENDING, self::STATUS_IN_PROCESS, self::STATUS_CLOSED, self::STATUS_REJECTED];
        
        if (!in_array($status, $validStatuses)) {
            return false;
        }
        
        $sql = "UPDATE {$this->table} SET status = ? WHERE o_id = ?";
        $this->db->query($sql, [$status, $id]);
        return $this->db->rowCount() > 0;
    }
    
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE o_id = ?";
        $this->db->query($sql, [$id]);
        return $this->db->rowCount() > 0;
    }
    
    public function count($status = null) {
        if ($status) {
            $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE status = ?";
            $result = $this->db->query($sql, [$status])->fetch();
        } else {
            $sql = "SELECT COUNT(*) as total FROM {$this->table}";
            $result = $this->db->query($sql)->fetch();
        }
        return $result['total'];
    }
    
    public function getTotalRevenue($status = self::STATUS_CLOSED) {
        $sql = "SELECT SUM(price) as total FROM {$this->table} WHERE status = ?";
        $result = $this->db->query($sql, [$status])->fetch();
        return $result['total'] ?? 0;
    }
    
    public function getRecentOrders($limit = 10) {
        $sql = "SELECT o.*, u.username 
                FROM {$this->table} o 
                LEFT JOIN users u ON o.u_id = u.u_id 
                ORDER BY o.date DESC 
                LIMIT ?";
        return $this->db->query($sql, [$limit])->fetchAll();
    }
}
