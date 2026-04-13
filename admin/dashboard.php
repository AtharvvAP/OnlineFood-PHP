<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
if(empty($_SESSION["adm_id"]))
{
	header('location:index.php');
}
else
{
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - AP</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="css/admin-peak-design.css" rel="stylesheet">
</head>

<body>
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-sidebar-logo">
            <div class="admin-sidebar-logo-icon">
                <span>AP</span>
            </div>
            <span class="admin-sidebar-logo-text">Admin Panel</span>
        </div>
        
        <ul class="admin-sidebar-menu">
            <li class="admin-menu-label">Main</li>
            <li class="admin-menu-item">
                <a href="dashboard.php" class="admin-menu-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <li class="admin-menu-label">Management</li>
            <li class="admin-menu-item">
                <a href="all_users.php" class="admin-menu-link">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="admin-menu-item">
                <a href="all_restaurant.php" class="admin-menu-link">
                    <i class="fas fa-store"></i>
                    <span>Restaurants</span>
                </a>
            </li>
            <li class="admin-menu-item">
                <a href="add_category.php" class="admin-menu-link">
                    <i class="fas fa-tags"></i>
                    <span>Add Category</span>
                </a>
            </li>
            <li class="admin-menu-item">
                <a href="add_restaurant.php" class="admin-menu-link">
                    <i class="fas fa-plus-circle"></i>
                    <span>Add Restaurant</span>
                </a>
            </li>
            
            <li class="admin-menu-label">Menu</li>
            <li class="admin-menu-item">
                <a href="all_menu.php" class="admin-menu-link">
                    <i class="fas fa-utensils"></i>
                    <span>All Menu Items</span>
                </a>
            </li>
            <li class="admin-menu-item">
                <a href="add_menu.php" class="admin-menu-link">
                    <i class="fas fa-plus"></i>
                    <span>Add Menu Item</span>
                </a>
            </li>
            
            <li class="admin-menu-label">Orders</li>
            <li class="admin-menu-item">
                <a href="all_orders.php" class="admin-menu-link">
                    <i class="fas fa-shopping-cart"></i>
                    <span>All Orders</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Header -->
    <header class="admin-header">
        <h1 class="admin-header-title">Dashboard</h1>
        <div class="admin-header-user">
            <div class="admin-header-avatar">
                <i class="fas fa-user"></i>
            </div>
            <a href="logout.php" style="text-decoration: none; color: #4A5568; font-weight: 500;">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="admin-content">
        <!-- Stats Grid -->
        <div class="admin-stats-grid">
            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <div>
                        <div class="admin-stat-value">
                            <?php 
                            $sql="select * from restaurant";
                            $result=mysqli_query($db,$sql); 
                            $rws=mysqli_num_rows($result);
                            echo $rws;
                            ?>
                        </div>
                        <div class="admin-stat-label">Restaurants</div>
                    </div>
                    <div class="admin-stat-icon primary">
                        <i class="fas fa-store"></i>
                    </div>
                </div>
            </div>

            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <div>
                        <div class="admin-stat-value">
                            <?php 
                            $sql="select * from dishes";
                            $result=mysqli_query($db,$sql); 
                            $rws=mysqli_num_rows($result);
                            echo $rws;
                            ?>
                        </div>
                        <div class="admin-stat-label">Dishes</div>
                    </div>
                    <div class="admin-stat-icon warning">
                        <i class="fas fa-utensils"></i>
                    </div>
                </div>
            </div>

            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <div>
                        <div class="admin-stat-value">
                            <?php 
                            $sql="select * from users";
                            $result=mysqli_query($db,$sql); 
                            $rws=mysqli_num_rows($result);
                            echo $rws;
                            ?>
                        </div>
                        <div class="admin-stat-label">Users</div>
                    </div>
                    <div class="admin-stat-icon info">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <div>
                        <div class="admin-stat-value">
                            <?php 
                            $sql="select * from users_orders";
                            $result=mysqli_query($db,$sql); 
                            $rws=mysqli_num_rows($result);
                            echo $rws;
                            ?>
                        </div>
                        <div class="admin-stat-label">Total Orders</div>
                    </div>
                    <div class="admin-stat-icon success">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row Stats -->
        <div class="admin-stats-grid">
            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <div>
                        <div class="admin-stat-value">
                            <?php 
                            $sql="select * from res_category";
                            $result=mysqli_query($db,$sql); 
                            $rws=mysqli_num_rows($result);
                            echo $rws;
                            ?>
                        </div>
                        <div class="admin-stat-label">Categories</div>
                    </div>
                    <div class="admin-stat-icon primary">
                        <i class="fas fa-tags"></i>
                    </div>
                </div>
            </div>

            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <div>
                        <div class="admin-stat-value">
                            <?php 
                            $sql="select * from users_orders WHERE status = 'in process'";
                            $result=mysqli_query($db,$sql); 
                            $rws=mysqli_num_rows($result);
                            echo $rws;
                            ?>
                        </div>
                        <div class="admin-stat-label">Processing</div>
                    </div>
                    <div class="admin-stat-icon warning">
                        <i class="fas fa-spinner"></i>
                    </div>
                </div>
            </div>

            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <div>
                        <div class="admin-stat-value">
                            <?php 
                            $sql="select * from users_orders WHERE status = 'closed'";
                            $result=mysqli_query($db,$sql); 
                            $rws=mysqli_num_rows($result);
                            echo $rws;
                            ?>
                        </div>
                        <div class="admin-stat-label">Delivered</div>
                    </div>
                    <div class="admin-stat-icon success">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
            </div>

            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <div>
                        <div class="admin-stat-value">
                            ₹<?php 
                            $result = mysqli_query($db, 'SELECT SUM(price) AS value_sum FROM users_orders WHERE status = "closed"'); 
                            $row = mysqli_fetch_assoc($result); 
                            $sum = $row['value_sum'];
                            echo number_format($sum, 2);
                            ?>
                        </div>
                        <div class="admin-stat-label">Total Earnings</div>
                    </div>
                    <div class="admin-stat-icon success">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Third Row Stats -->
        <div class="admin-stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
            <div class="admin-stat-card">
                <div class="admin-stat-header">
                    <div>
                        <div class="admin-stat-value">
                            <?php 
                            $sql="select * from users_orders WHERE status = 'rejected'";
                            $result=mysqli_query($db,$sql); 
                            $rws=mysqli_num_rows($result);
                            echo $rws;
                            ?>
                        </div>
                        <div class="admin-stat-label">Cancelled Orders</div>
                    </div>
                    <div class="admin-stat-icon" style="background: rgba(245, 101, 101, 0.1); color: #F56565;">
                        <i class="fas fa-times-circle"></i>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
<?php
}
?>
