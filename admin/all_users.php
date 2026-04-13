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
$page_title = "All Users";
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
                <h2 class="admin-card-title">All Users</h2>
            </div>
            
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Reg Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM users ORDER BY u_id DESC";
                        $query = mysqli_query($db, $sql);
                        
                        if(!mysqli_num_rows($query) > 0) {
                            echo '<tr><td colspan="8" style="text-align:center; padding: 2rem; color: #A0AEC0;">No users found</td></tr>';
                        } else {
                            while($rows = mysqli_fetch_array($query)) {
                                echo '<tr>
                                    <td><strong>'.$rows['username'].'</strong></td>
                                    <td>'.$rows['f_name'].'</td>
                                    <td>'.$rows['l_name'].'</td>
                                    <td>'.$rows['email'].'</td>
                                    <td>'.$rows['phone'].'</td>
                                    <td>'.$rows['address'].'</td>
                                    <td>'.date('M d, Y', strtotime($rows['date'])).'</td>
                                    <td>
                                        <a href="delete_users.php?user_del='.$rows['u_id'].'" onclick="return confirm(\'Are you sure you want to delete this user?\');" class="admin-btn admin-btn-sm admin-btn-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="update_users.php?user_upd='.$rows['u_id'].'" class="admin-btn admin-btn-sm admin-btn-info" title="Edit">
                                            <i class="fas fa-edit"></i>
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
