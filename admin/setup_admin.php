<?php
/**
 * Admin Setup Script
 * Run this once to create default admin user
 * Default credentials: admin / codeastro
 */

include("../connection/connect.php");

// Check if admin table exists
$check_table = mysqli_query($db, "SHOW TABLES LIKE 'admin'");

if(mysqli_num_rows($check_table) == 0) {
    // Create admin table
    $create_table = "CREATE TABLE `admin` (
        `adm_id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(50) NOT NULL,
        `password` varchar(255) NOT NULL,
        `email` varchar(100) DEFAULT NULL,
        `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`adm_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if(mysqli_query($db, $create_table)) {
        echo "✓ Admin table created successfully<br>";
    } else {
        echo "✗ Error creating admin table: " . mysqli_error($db) . "<br>";
    }
}

// Check if admin user exists
$check_admin = mysqli_query($db, "SELECT * FROM admin WHERE username='admin'");

if(mysqli_num_rows($check_admin) == 0) {
    // Create default admin user
    $username = 'admin';
    $password = md5('codeastro'); // Password: codeastro
    $email = 'admin@ap.com';
    
    $insert_admin = "INSERT INTO admin (username, password, email) VALUES ('$username', '$password', '$email')";
    
    if(mysqli_query($db, $insert_admin)) {
        echo "✓ Default admin user created successfully<br>";
        echo "<br><strong>Login Credentials:</strong><br>";
        echo "Username: admin<br>";
        echo "Password: codeastro<br>";
        echo "<br><a href='index.php' style='background: #FF6B35; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px;'>Go to Login</a>";
    } else {
        echo "✗ Error creating admin user: " . mysqli_error($db) . "<br>";
    }
} else {
    echo "✓ Admin user already exists<br>";
    echo "<br><strong>Existing Login Credentials:</strong><br>";
    echo "Username: admin<br>";
    echo "Password: codeastro<br>";
    echo "<br><a href='index.php' style='background: #FF6B35; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px;'>Go to Login</a>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Setup</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #F7FAFC;
            padding: 50px;
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            color: #1A202C;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Admin Setup</h1>
</body>
</html>
