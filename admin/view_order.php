<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(0);
session_start();
if(empty($_SESSION["adm_id"])) {
    header('location:index.php');
    exit();
}
$page_title = "View Order";

$sql = "SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id WHERE o_id='".$_GET['user_upd']."'";
$query = mysqli_query($db, $sql);
$rows = mysqli_fetch_array($query);
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $page_title; ?> - AP Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="css/admin-peak-design.css" rel="stylesheet">
    <style>
        .order-detail-card { background: white; border-radius: 16px; padding: 2rem; margin-bottom: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
        .order-detail-row { display: grid; grid-template-columns: 200px 1fr auto; gap: 1.5rem; padding: 1.25rem 0; border-bottom: 1px solid #E2E8F0; align-items: center; }
        .order-detail-row:last-child { border-bottom: none; }
        .order-detail-label { font-weight: 600; color: #2D3748; }
        .order-detail-value { color: #4A5568; }
    </style>
</head>

<body>
    <?php include('includes/admin_header.php'); ?>

    <main class="admin-content">
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Order Details #<?php echo $rows['o_id']; ?></h2>
            </div>
            
            <div style="padding: 2rem;">
                <div class="order-detail-card">
                    <div class="order-detail-row">
                        <div class="order-detail-label"><i class="fas fa-user"></i> Username</div>
                        <div class="order-detail-value"><strong><?php echo $rows['username']; ?></strong></div>
                        <div>
                            <a href="javascript:void(0);" onClick="window.open('userprofile.php?newform_id=<?php echo $rows['o_id'];?>','popUpWindow','height=600,width=800,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');" class="admin-btn admin-btn-sm admin-btn-info">
                                <i class="fas fa-user-circle"></i> View Profile
                            </a>
                        </div>
                    </div>
                    
                    <div class="order-detail-row">
                        <div class="order-detail-label"><i class="fas fa-utensils"></i> Dish</div>
                        <div class="order-detail-value"><?php echo $rows['title']; ?></div>
                        <div></div>
                    </div>
                    
                    <div class="order-detail-row">
                        <div class="order-detail-label"><i class="fas fa-sort-numeric-up"></i> Quantity</div>
                        <div class="order-detail-value"><?php echo $rows['quantity']; ?></div>
                        <div></div>
                    </div>
                    
                    <div class="order-detail-row">
                        <div class="order-detail-label"><i class="fas fa-rupee-sign"></i> Price</div>
                        <div class="order-detail-value"><strong style="font-size: 1.25rem; color: #FF6B35;">₹<?php echo number_format($rows['price'], 2); ?></strong></div>
                        <div></div>
                    </div>
                    
                    <div class="order-detail-row">
                        <div class="order-detail-label"><i class="fas fa-map-marker-alt"></i> Address</div>
                        <div class="order-detail-value"><?php echo $rows['address']; ?></div>
                        <div></div>
                    </div>
                    
                    <div class="order-detail-row">
                        <div class="order-detail-label"><i class="fas fa-calendar"></i> Date</div>
                        <div class="order-detail-value"><?php echo date('M d, Y h:i A', strtotime($rows['date'])); ?></div>
                        <div></div>
                    </div>
                    
                    <div class="order-detail-row">
                        <div class="order-detail-label"><i class="fas fa-info-circle"></i> Status</div>
                        <div class="order-detail-value">
                            <?php 
                            $status = $rows['status'];
                            if($status == "" || $status == "NULL") {
                                echo '<span class="admin-badge admin-badge-info"><i class="fas fa-clock"></i> Pending</span>';
                            } elseif($status == "in process") {
                                echo '<span class="admin-badge admin-badge-warning"><i class="fas fa-spinner fa-spin"></i> Processing</span>';
                            } elseif($status == "closed") {
                                echo '<span class="admin-badge admin-badge-success"><i class="fas fa-check-circle"></i> Delivered</span>';
                            } elseif($status == "rejected") {
                                echo '<span class="admin-badge admin-badge-danger"><i class="fas fa-times-circle"></i> Cancelled</span>';
                            }
                            ?>
                        </div>
                        <div>
                            <a href="javascript:void(0);" onClick="window.open('order_update.php?form_id=<?php echo $rows['o_id'];?>','popUpWindow','height=400,width=600,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes');" class="admin-btn admin-btn-sm admin-btn-warning">
                                <i class="fas fa-edit"></i> Update Status
                            </a>
                        </div>
                    </div>
                </div>
                
                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <a href="all_orders.php" class="admin-btn admin-btn-primary-outline" style="padding: 0.875rem 2rem; text-decoration: none;">
                        <i class="fas fa-arrow-left"></i> Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
