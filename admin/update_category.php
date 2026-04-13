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
$page_title = "Update Category";

if(isset($_POST['submit'])) {
    if(empty($_POST['c_name'])) {
        $error = 'Category name is required!';
    } else {
        $mql = "UPDATE res_category SET c_name='".$_POST['c_name']."' WHERE c_id='".$_GET['cat_upd']."'";
        mysqli_query($db, $mql);
        $success = 'Category updated successfully!';
    }
}

$ssql = "SELECT * FROM res_category WHERE c_id='".$_GET['cat_upd']."'";
$res = mysqli_query($db, $ssql);
$row = mysqli_fetch_array($res);
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

        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Update Category</h2>
            </div>
            <div style="padding: 2rem;">
                <form method="post" action="">
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-weight: 600; color: #2D3748; margin-bottom: 0.5rem;">Category Name</label>
                        <input type="text" name="c_name" value="<?php echo $row['c_name']; ?>" class="admin-form-input" placeholder="Enter category name" required style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #E2E8F0; border-radius: 12px; font-size: 1rem; background: #F7FAFC;">
                    </div>
                    
                    <div style="display: flex; gap: 1rem;">
                        <button type="submit" name="submit" class="admin-btn-primary" style="padding: 0.875rem 2rem;">
                            <i class="fas fa-save"></i> Update Category
                        </button>
                        <a href="add_category.php" class="admin-btn admin-btn-primary-outline" style="padding: 0.875rem 2rem; text-decoration: none;">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
