<?php
/**
 * Database Upgrade Script
 * Migrates existing database to new architecture
 */

require_once __DIR__ . '/../config/config.php';

echo "=== Golden Era Cafe - Database Upgrade Script ===\n\n";

$db = Database::getInstance()->getConnection();

try {
    $db->beginTransaction();
    
    // 1. Add discount column if not exists
    echo "1. Checking discount column...\n";
    $result = $db->query("SHOW COLUMNS FROM dishes LIKE 'discount'");
    if ($result->rowCount() == 0) {
        $db->exec("ALTER TABLE dishes ADD COLUMN discount DECIMAL(5,2) DEFAULT 0.00 AFTER price");
        echo "   ✓ Added discount column\n";
    } else {
        echo "   ✓ Discount column already exists\n";
    }
    
    // 2. Add indexes for performance
    echo "\n2. Adding database indexes...\n";
    
    $indexes = [
        "CREATE INDEX IF NOT EXISTS idx_dishes_restaurant ON dishes(rs_id)",
        "CREATE INDEX IF NOT EXISTS idx_orders_user ON users_orders(u_id)",
        "CREATE INDEX IF NOT EXISTS idx_orders_status ON users_orders(status)",
        "CREATE INDEX IF NOT EXISTS idx_orders_date ON users_orders(date)",
        "CREATE INDEX IF NOT EXISTS idx_users_username ON users(username)",
        "CREATE INDEX IF NOT EXISTS idx_users_email ON users(email)",
        "CREATE INDEX IF NOT EXISTS idx_restaurant_category ON restaurant(c_id)"
    ];
    
    foreach ($indexes as $index) {
        try {
            $db->exec($index);
            echo "   ✓ Index created\n";
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'Duplicate key name') === false) {
                throw $e;
            }
            echo "   ✓ Index already exists\n";
        }
    }
    
    // 3. Update password hashing for existing users
    echo "\n3. Upgrading password security...\n";
    $users = $db->query("SELECT u_id, password FROM users")->fetchAll();
    $upgraded = 0;
    
    foreach ($users as $user) {
        // Check if password is already hashed with bcrypt
        if (strlen($user['password']) !== 60 || substr($user['password'], 0, 4) !== '$2y$') {
            // Re-hash with bcrypt
            $newHash = password_hash($user['password'], PASSWORD_BCRYPT, ['cost' => 12]);
            $stmt = $db->prepare("UPDATE users SET password = ? WHERE u_id = ?");
            $stmt->execute([$newHash, $user['u_id']]);
            $upgraded++;
        }
    }
    echo "   ✓ Upgraded {$upgraded} user passwords\n";
    
    // 4. Update admin password hashing
    echo "\n4. Upgrading admin password security...\n";
    $admins = $db->query("SELECT adm_id, password FROM admin")->fetchAll();
    $upgraded = 0;
    
    foreach ($admins as $admin) {
        if (strlen($admin['password']) !== 60 || substr($admin['password'], 0, 4) !== '$2y$') {
            $newHash = password_hash($admin['password'], PASSWORD_BCRYPT, ['cost' => 12]);
            $stmt = $db->prepare("UPDATE admin SET password = ? WHERE adm_id = ?");
            $stmt->execute([$newHash, $admin['adm_id']]);
            $upgraded++;
        }
    }
    echo "   ✓ Upgraded {$upgraded} admin passwords\n";
    
    // 5. Add timestamp columns if not exists
    echo "\n5. Adding timestamp columns...\n";
    
    $tables = ['users', 'restaurant', 'dishes'];
    foreach ($tables as $table) {
        $result = $db->query("SHOW COLUMNS FROM {$table} LIKE 'updated_at'");
        if ($result->rowCount() == 0) {
            $db->exec("ALTER TABLE {$table} ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
            echo "   ✓ Added updated_at to {$table}\n";
        }
    }
    
    // 6. Optimize tables
    echo "\n6. Optimizing database tables...\n";
    $tables = ['users', 'dishes', 'users_orders', 'restaurant', 'res_category', 'admin'];
    
    foreach ($tables as $table) {
        $db->exec("OPTIMIZE TABLE {$table}");
        echo "   ✓ Optimized {$table}\n";
    }
    
    // 7. Create cache directory
    echo "\n7. Setting up cache directory...\n";
    $cacheDir = __DIR__ . '/../cache';
    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0755, true);
        echo "   ✓ Created cache directory\n";
    } else {
        echo "   ✓ Cache directory exists\n";
    }
    
    // 8. Create uploads directory
    echo "\n8. Setting up uploads directory...\n";
    $uploadsDir = __DIR__ . '/../uploads';
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0755, true);
        echo "   ✓ Created uploads directory\n";
    } else {
        echo "   ✓ Uploads directory exists\n";
    }
    
    // 9. Create logs directory
    echo "\n9. Setting up logs directory...\n";
    $logsDir = __DIR__ . '/../logs';
    if (!is_dir($logsDir)) {
        mkdir($logsDir, 0755, true);
        echo "   ✓ Created logs directory\n";
    } else {
        echo "   ✓ Logs directory exists\n";
    }
    
    $db->commit();
    
    echo "\n=== Upgrade Complete! ===\n";
    echo "\nNext Steps:\n";
    echo "1. Clear your browser cache\n";
    echo "2. Test the login functionality\n";
    echo "3. Verify API endpoints\n";
    echo "4. Check admin panel access\n";
    echo "\nNote: Default admin password has been upgraded.\n";
    echo "If you can't login, reset it manually in the database.\n\n";
    
} catch (Exception $e) {
    $db->rollBack();
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    echo "Upgrade failed. Database rolled back.\n\n";
    exit(1);
}
