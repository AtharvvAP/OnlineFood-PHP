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
$page_title = "Add Restaurant";

if(isset($_POST['submit'])) {
    if(empty($_POST['c_name']) || empty($_POST['res_name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['url']) || empty($_POST['o_hr']) || empty($_POST['c_hr']) || empty($_POST['o_days']) || empty($_POST['address'])) {
        $error = 'All fields must be filled!';
    } else {
        $fname = $_FILES['file']['name'];
        $temp = $_FILES['file']['tmp_name'];
        $fsize = $_FILES['file']['size'];
        $extension = explode('.', $fname);
        $extension = strtolower(end($extension));
        $fnew = uniqid().'.'.$extension;
        $store = "Res_img/".basename($fnew);
        
        if($extension == 'jpg' || $extension == 'png' || $extension == 'gif') {
            if($fsize >= 1000000) {
                $error = 'Max image size is 1024kb! Try a different image.';
            } else {
                $res_name = $_POST['res_name'];
                $sql = "INSERT INTO restaurant(c_id,title,email,phone,url,o_hr,c_hr,o_days,address,image) VALUES('".$_POST['c_name']."','".$res_name."','".$_POST['email']."','".$_POST['phone']."','".$_POST['url']."','".$_POST['o_hr']."','".$_POST['c_hr']."','".$_POST['o_days']."','".$_POST['address']."','".$fnew."')";
                mysqli_query($db, $sql);
                move_uploaded_file($temp, $store);
                $success = 'New restaurant added successfully!';
            }
        } elseif($extension == '') {
            $error = 'Please select an image';
        } else {
            $error = 'Invalid extension! PNG, JPG, GIF are accepted.';
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
    <style>
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; font-weight: 600; color: #2D3748; margin-bottom: 0.5rem; }
        .form-input, .form-select, .form-textarea { width: 100%; padding: 0.875rem 1rem; border: 2px solid #E2E8F0; border-radius: 12px; font-size: 1rem; background: #F7FAFC; }
        .form-input:focus, .form-select:focus, .form-textarea:focus { outline: none; border-color: #FF6B35; background: white; }
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
                <h2 class="admin-card-title">Add New Restaurant</h2>
            </div>
            <div style="padding: 2rem;">
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Restaurant Name</label>
                            <input type="text" name="res_name" class="form-input" placeholder="Enter restaurant name" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Business Email</label>
                            <input type="email" name="email" class="form-input" placeholder="email@example.com" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-input" placeholder="Phone number" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Website URL</label>
                            <input type="text" name="url" class="form-input" placeholder="https://example.com" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Open Hours</label>
                            <select name="o_hr" class="form-select" required>
                                <option value="">--Select Hours--</option>
                                <option value="6am">6am</option>
                                <option value="7am">7am</option>
                                <option value="8am">8am</option>
                                <option value="9am">9am</option>
                                <option value="10am">10am</option>
                                <option value="11am">11am</option>
                                <option value="12pm">12pm</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Close Hours</label>
                            <select name="c_hr" class="form-select" required>
                                <option value="">--Select Hours--</option>
                                <option value="3pm">3pm</option>
                                <option value="4pm">4pm</option>
                                <option value="5pm">5pm</option>
                                <option value="6pm">6pm</option>
                                <option value="7pm">7pm</option>
                                <option value="8pm">8pm</option>
                                <option value="9pm">9pm</option>
                                <option value="10pm">10pm</option>
                                <option value="11pm">11pm</option>
                                <option value="12am">12am</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Open Days</label>
                            <select name="o_days" class="form-select" required>
                                <option value="">--Select Days--</option>
                                <option value="Mon-Tue">Mon-Tue</option>
                                <option value="Mon-Wed">Mon-Wed</option>
                                <option value="Mon-Thu">Mon-Thu</option>
                                <option value="Mon-Fri">Mon-Fri</option>
                                <option value="Mon-Sat">Mon-Sat</option>
                                <option value="24hr-x7">24hr-x7</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select name="c_name" class="form-select" required>
                                <option value="">--Select Category--</option>
                                <?php
                                $ssql = "SELECT * FROM res_category";
                                $res = mysqli_query($db, $ssql);
                                while($row = mysqli_fetch_array($res)) {
                                    echo '<option value="'.$row['c_id'].'">'.$row['c_name'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Restaurant Image</label>
                            <input type="file" name="file" class="form-input" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-textarea" rows="4" placeholder="Enter full address" required></textarea>
                    </div>
                    
                    <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                        <button type="submit" name="submit" class="admin-btn-primary" style="padding: 0.875rem 2rem;">
                            <i class="fas fa-save"></i> Save Restaurant
                        </button>
                        <a href="all_restaurant.php" class="admin-btn admin-btn-primary-outline" style="padding: 0.875rem 2rem; text-decoration: none;">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
