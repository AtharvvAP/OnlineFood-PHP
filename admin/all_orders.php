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
$page_title = "All Orders";
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $page_title; ?> - AP Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="css/admin-peak-design.css" rel="stylesheet">
</head>

<body>
    <?php include('includes/admin_header.php'); ?>

    <!-- Main Content -->
    <main class="admin-content">
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">All Orders</h2>
            </div>
            
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Dish</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT users.*, users_orders.* FROM users INNER JOIN users_orders ON users.u_id=users_orders.u_id ORDER BY users_orders.o_id DESC";
                        $query = mysqli_query($db, $sql);
                        
                        if(!mysqli_num_rows($query) > 0) {
                            echo '<tr><td colspan="8" style="text-align:center; padding: 2rem; color: #A0AEC0;">No orders found</td></tr>';
                        } else {
                            while($rows = mysqli_fetch_array($query)) {
                                $status = $rows['status'];
                                
                                // Status badge
                                if($status == "" || $status == "NULL") {
                                    $status_badge = '<span class="admin-badge admin-badge-info"><i class="fas fa-clock"></i> Pending</span>';
                                } elseif($status == "in process") {
                                    $status_badge = '<span class="admin-badge admin-badge-warning"><i class="fas fa-spinner fa-spin"></i> Processing</span>';
                                } elseif($status == "closed") {
                                    $status_badge = '<span class="admin-badge admin-badge-success"><i class="fas fa-check-circle"></i> Delivered</span>';
                                } elseif($status == "rejected") {
                                    $status_badge = '<span class="admin-badge admin-badge-danger"><i class="fas fa-times-circle"></i> Cancelled</span>';
                                } else {
                                    $status_badge = '<span class="admin-badge admin-badge-info">'.$status.'</span>';
                                }
                                
                                echo '<tr>
                                    <td><strong>'.$rows['username'].'</strong></td>
                                    <td>'.$rows['title'].'</td>
                                    <td>'.$rows['quantity'].'</td>
                                    <td>₹'.number_format($rows['price'], 2).'</td>
                                    <td>'.$rows['address'].'</td>
                                    <td>'.$status_badge.'</td>
                                    <td>'.date('M d, Y', strtotime($rows['date'])).'</td>
                                    <td>
                                        <a href="view_order.php?user_upd='.$rows['o_id'].'" class="admin-btn admin-btn-sm admin-btn-info" title="View/Edit">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="delete_orders.php?order_del='.$rows['o_id'].'" onclick="return confirm(\'Are you sure you want to delete this order?\');" class="admin-btn admin-btn-sm admin-btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
