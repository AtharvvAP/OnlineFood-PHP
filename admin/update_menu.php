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
$page_title = "Update Menu Item";

if(isset($_POST['submit'])) {
    if(empty($_POST['d_name']) || empty($_POST['about']) || empty($_POST['price']) || empty($_POST['res_name'])) {
        $error = 'All fields must be filled!';
    } else {
        $fname = $_FILES['file']['name'];
        $discount = isset($_POST['discount']) ? $_POST['discount'] : 0;
        
        if(!empty($fname)) {
            $temp = $_FILES['file']['tmp_name'];
            $fsize = $_FILES['file']['size'];
            $extension = explode('.', $fname);
            $extension = strtolower(end($extension));
            $fnew = uniqid().'.'.$extension;
            $store = "Res_img/dishes/".basename($fnew);
            
            if($extension == 'jpg' || $extension == 'png' || $extension == 'gif') {
                if($fsize >= 1000000) {
                    $error = 'Max image size is 1024kb! Try a different image.';
                } else {
                    $sql = "UPDATE dishes SET rs_id='".$_POST['res_name']."', title='".$_POST['d_name']."', slogan='".$_POST['about']."', price='".$_POST['price']."', discount='".$discount."', img='".$fnew."' WHERE d_id='".$_GET['menu_upd']."'";
                    mysqli_query($db, $sql);
                    move_uploaded_file($temp, $store);
                    $success = 'Menu item updated successfully!';
                }
            } else {
                $error = 'Invalid extension! PNG, JPG, GIF are accepted.';
            }
        } else {
            $sql = "UPDATE dishes SET rs_id='".$_POST['res_name']."', title='".$_POST['d_name']."', slogan='".$_POST['about']."', price='".$_POST['price']."', discount='".$discount."' WHERE d_id='".$_GET['menu_upd']."'";
            mysqli_query($db, $sql);
            $success = 'Menu item updated successfully!';
        }
    }
}

$qml = "SELECT * FROM dishes WHERE d_id='".$_GET['menu_upd']."'";
$rest = mysqli_query($db, $qml);
$roww = mysqli_fetch_array($rest);
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $page_title; ?> - AP Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="css/admin-peak-design.css" rel="stylesheet">
    <style>
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; font-weight: 600; color: #2D3748; margin-bottom: 0.5rem; }
        .form-input, .form-select { width: 100%; padding: 0.875rem 1rem; border: 2px solid #E2E8F0; border-radius: 12px; font-size: 1rem; background: #F7FAFC; }
        .form-input:focus, .form-select:focus { outline: none; border-color: #FF6B35; background: white; }
        @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } }
    </style>
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
                <h2 class="admin-card-title">Update Menu Item</h2>
            </div>
            <div style="padding: 2rem;">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Dish Name</label>
                            <input type="text" name="d_name" value="<?php echo $roww['title']; ?>" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <input type="text" name="about" value="<?php echo $roww['slogan']; ?>" class="form-input" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Price (₹)</label>
                            <input type="number" name="price" value="<?php echo $roww['price']; ?>" class="form-input" step="0.01" min="0" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Discount (%)</label>
                            <input type="number" name="discount" value="<?php echo isset($roww['discount']) ? $roww['discount'] : 0; ?>" class="form-input" min="0" max="100" step="0.01">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Select Restaurant</label>
                            <select name="res_name" class="form-select" required>
                                <option value="">--Select Restaurant--</option>
                                <?php
                                $ssql = "SELECT * FROM restaurant";
                                $res = mysqli_query($db, $ssql);
                                while($row = mysqli_fetch_array($res)) {
                                    $selected = ($row['rs_id'] == $roww['rs_id']) ? 'selected' : '';
                                    echo '<option value="'.$row['rs_id'].'" '.$selected.'>'.$row['title'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Update Image (Optional)</label>
                            <input type="file" name="file" class="form-input">
                            <small style="color: #718096; font-size: 0.875rem;">Leave empty to keep current image</small>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                        <button type="submit" name="submit" class="admin-btn-primary" style="padding: 0.875rem 2rem;">
                            <i class="fas fa-save"></i> Update Menu Item
                        </button>
                        <a href="all_menu.php" class="admin-btn admin-btn-primary-outline" style="padding: 0.875rem 2rem; text-decoration: none;">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
