<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();

if(empty($_SESSION['user_id'])) {
	header('location:login.php');
	exit;
}
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Orders - Golden Era Cafe</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="css/peak-design.css" rel="stylesheet">
    <style>
        .orders-table { width: 100%; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
        .orders-table table { width: 100%; border-collapse: collapse; }
        .orders-table th { background: #F7FAFC; padding: 1rem; text-align: left; font-weight: 600; color: #2D3748; border-bottom: 2px solid #E2E8F0; }
        .orders-table td { padding: 1rem; border-bottom: 1px solid #E2E8F0; color: #4A5568; }
        .orders-table tr:last-child td { border-bottom: none; }
        .orders-table tr:hover { background: #F7FAFC; }
        .status-badge { padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; }
        .status-pending { background: #FED7D7; color: #C53030; }
        .status-process { background: #FEEBC8; color: #C05621; }
        .status-delivered { background: #C6F6D5; color: #2F855A; }
        .status-cancelled { background: #FED7D7; color: #C53030; }
        .btn-delete { color: #F56565; padding: 0.5rem; border-radius: 8px; transition: all 0.3s ease; }
        .btn-delete:hover { background: #FED7D7; }
        @media (max-width: 768px) { .orders-table { overflow-x: auto; } }
    </style>
</head>

<body>
    <nav class="peak-nav" id="mainNav">
        <div class="container">
            <div class="peak-nav-inner">
                <a href="index.php" class="peak-logo" style="text-decoration: none; display: flex; align-items: center; gap: 8px;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #FF6B35, #FF8C42); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3); position: relative; overflow: hidden;">
                        <div style="position: absolute; width: 100%; height: 100%; background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.3), transparent); pointer-events: none;"></div>
                        <span style="font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 900; color: white; letter-spacing: -2px; text-shadow: 0 2px 8px rgba(0,0,0,0.2);">AP</span>
                    </div>
                </a>
                <button class="peak-nav-toggle" id="navToggle"><i class="fas fa-bars"></i></button>
                <ul class="peak-nav-menu" id="navMenu">
                    <li><a href="index.php" class="peak-nav-link"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="restaurants.php" class="peak-nav-link"><i class="fas fa-utensils"></i> Menu</a></li>
                    <li><a href="your_orders.php" class="peak-nav-link active"><i class="fas fa-shopping-bag"></i> My Orders</a></li>
                    <li><a href="logout.php" class="peak-btn-primary"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="peak-section" style="padding-top: 120px;">
        <div class="container">
            <div class="peak-section-header">
                <h2 class="peak-section-title">My Orders</h2>
                <p class="peak-section-subtitle">Track and manage your orders</p>
            </div>

            <div class="orders-table">
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $query_res = mysqli_query($db,"select * from users_orders where u_id='".$_SESSION['user_id']."' ORDER BY date DESC");
                        if(!mysqli_num_rows($query_res) > 0) {
                            echo '<tr><td colspan="6" style="text-align: center; padding: 3rem; color: #A0AEC0;">
                                <i class="fas fa-shopping-bag" style="font-size: 3rem; margin-bottom: 1rem; display: block;"></i>
                                You have no orders placed yet.
                            </td></tr>';
                        } else {
                            while($row = mysqli_fetch_array($query_res)) {
                                $status = $row['status'];
                        ?>
                            <tr>
                                <td><strong><?php echo $row['title']; ?></strong></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td><strong>₹<?php echo $row['price']; ?></strong></td>
                                <td>
                                    <?php 
                                    if($status == "" || $status == "NULL" || $status == "pending") {
                                        echo '<span class="status-badge status-pending"><i class="fas fa-clock"></i> Pending</span>';
                                    } elseif($status == "in process") {
                                        echo '<span class="status-badge status-process"><i class="fas fa-truck"></i> On The Way</span>';
                                    } elseif($status == "closed") {
                                        echo '<span class="status-badge status-delivered"><i class="fas fa-check-circle"></i> Delivered</span>';
                                    } elseif($status == "rejected") {
                                        echo '<span class="status-badge status-cancelled"><i class="fas fa-times-circle"></i> Cancelled</span>';
                                    }
                                    ?>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($row['date'])); ?></td>
                                <td>
                                    <a href="delete_orders.php?order_del=<?php echo $row['o_id'];?>" 
                                       onclick="return confirm('Are you sure you want to cancel this order?');" 
                                       class="btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php }} ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <footer class="peak-footer">
        <div class="container">
            <div class="peak-footer-bottom">
                <p>&copy; 2024 Golden Era Cafe. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('navToggle').addEventListener('click', function() {
            document.getElementById('navMenu').classList.toggle('active');
        });
    </script>
</body>
</html>
