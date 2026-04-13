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
$page_title = "All Menu Items";
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
                <h2 class="admin-card-title">All Menu Items</h2>
            </div>
            
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Restaurant</th>
                            <th>Dish Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM dishes ORDER BY d_id DESC";
                        $query = mysqli_query($db, $sql);
                        
                        if(!mysqli_num_rows($query) > 0) {
                            echo '<tr><td colspan="7" style="text-align:center; padding: 2rem; color: #A0AEC0;">No menu items found</td></tr>';
                        } else {
                            while($rows = mysqli_fetch_array($query)) {
                                // Get restaurant name
                                $rest_sql = "SELECT * FROM restaurant WHERE rs_id='".$rows['rs_id']."'";
                                $rest_query = mysqli_query($db, $rest_sql);
                                $rest_row = mysqli_fetch_array($rest_query);
                                
                                $discount = isset($rows['discount']) ? $rows['discount'] : 0;
                                
                                echo '<tr>
                                    <td>'.$rest_row['title'].'</td>
                                    <td><strong>'.$rows['title'].'</strong></td>
                                    <td>'.$rows['slogan'].'</td>
                                    <td>₹'.number_format($rows['price'], 2).'</td>
                                    <td>';
                                
                                if($discount > 0) {
                                    echo '<span class="admin-badge admin-badge-success">'.$discount.'% OFF</span>';
                                } else {
                                    echo '<span style="color: #A0AEC0;">No discount</span>';
                                }
                                
                                echo '</td>
                                    <td>
                                        <img src="Res_img/dishes/'.$rows['img'].'" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;" alt="'.$rows['title'].'">
                                    </td>
                                    <td>
                                        <a href="update_menu.php?menu_upd='.$rows['d_id'].'" class="admin-btn admin-btn-sm admin-btn-info" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete_menu.php?menu_del='.$rows['d_id'].'" onclick="return confirm(\'Are you sure you want to delete this menu item?\');" class="admin-btn admin-btn-sm admin-btn-danger" title="Delete">
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
