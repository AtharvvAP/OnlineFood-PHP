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
$page_title = "All Restaurants";
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
                <h2 class="admin-card-title">All Restaurants</h2>
            </div>
            
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Hours</th>
                            <th>Address</th>
                            <th>Image</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM restaurant ORDER BY rs_id DESC";
                        $query = mysqli_query($db, $sql);
                        
                        if(!mysqli_num_rows($query) > 0) {
                            echo '<tr><td colspan="9" style="text-align:center; padding: 2rem; color: #A0AEC0;">No restaurants found</td></tr>';
                        } else {
                            while($rows = mysqli_fetch_array($query)) {
                                // Get category name
                                $cat_sql = "SELECT * FROM res_category WHERE c_id='".$rows['c_id']."'";
                                $cat_res = mysqli_query($db, $cat_sql);
                                $cat_row = mysqli_fetch_array($cat_res);
                                
                                echo '<tr>
                                    <td>'.$cat_row['c_name'].'</td>
                                    <td><strong>'.$rows['title'].'</strong></td>
                                    <td>'.$rows['email'].'</td>
                                    <td>'.$rows['phone'].'</td>
                                    <td>'.$rows['o_hr'].' - '.$rows['c_hr'].'</td>
                                    <td>'.$rows['address'].'</td>
                                    <td>
                                        <img src="Res_img/'.$rows['image'].'" style="width: 80px; height: 60px; object-fit: cover; border-radius: 8px;" alt="'.$rows['title'].'">
                                    </td>
                                    <td>'.date('M d, Y', strtotime($rows['date'])).'</td>
                                    <td>
                                        <a href="update_restaurant.php?res_upd='.$rows['rs_id'].'" class="admin-btn admin-btn-sm admin-btn-info" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete_restaurant.php?res_del='.$rows['rs_id'].'" onclick="return confirm(\'Are you sure you want to delete this restaurant?\');" class="admin-btn admin-btn-sm admin-btn-danger" title="Delete">
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
