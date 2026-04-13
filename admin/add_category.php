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

$error = "";
$success = "";
$page_title = "Add Category";

if(isset($_POST['submit'])) {
    if(empty($_POST['c_name'])) {
        $error = 'Category name is required!';
    } else {
        $check_cat = mysqli_query($db, "SELECT c_name FROM res_category WHERE c_name = '".$_POST['c_name']."'");
        
        if(mysqli_num_rows($check_cat) > 0) {
            $error = 'Category already exists!';
        } else {
            $mql = "INSERT INTO res_category(c_name) VALUES('".$_POST['c_name']."')";
            mysqli_query($db, $mql);
            $success = 'New category added successfully!';
        }
    }
}
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
        <?php if($error): ?>
            <div style="background: #FED7D7; color: #C53030; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem;">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <?php if($success): ?>
            <div style="background: #C6F6D5; color: #22543D; padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 1.5rem;">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <!-- Add Category Form -->
        <div class="admin-card" style="margin-bottom: 2rem;">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Add New Category</h2>
            </div>
            <div style="padding: 2rem;">
                <form method="post" action="">
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: 600; color: #2D3748; margin-bottom: 0.5rem;">Category Name</label>
                        <input type="text" name="c_name" class="admin-form-input" placeholder="Enter category name" required style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #E2E8F0; border-radius: 12px; font-size: 1rem; background: #F7FAFC;">
                    </div>
                    
                    <div style="display: flex; gap: 1rem;">
                        <button type="submit" name="submit" class="admin-btn-primary" style="padding: 0.875rem 2rem;">
                            <i class="fas fa-save"></i> Save Category
                        </button>
                        <a href="add_category.php" class="admin-btn admin-btn-primary-outline" style="padding: 0.875rem 2rem; text-decoration: none;">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Listed Categories -->
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">All Categories</h2>
            </div>
            
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Date Added</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM res_category ORDER BY c_id DESC";
                        $query = mysqli_query($db, $sql);
                        
                        if(!mysqli_num_rows($query) > 0) {
                            echo '<tr><td colspan="4" style="text-align:center; padding: 2rem; color: #A0AEC0;">No categories found</td></tr>';
                        } else {
                            while($rows = mysqli_fetch_array($query)) {
                                echo '<tr>
                                    <td><strong>#'.$rows['c_id'].'</strong></td>
                                    <td>'.$rows['c_name'].'</td>
                                    <td>'.date('M d, Y', strtotime($rows['date'])).'</td>
                                    <td>
                                        <a href="update_category.php?cat_upd='.$rows['c_id'].'" class="admin-btn admin-btn-sm admin-btn-info" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete_category.php?cat_del='.$rows['c_id'].'" onclick="return confirm(\'Are you sure you want to delete this category?\');" class="admin-btn admin-btn-sm admin-btn-danger" title="Delete">
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
