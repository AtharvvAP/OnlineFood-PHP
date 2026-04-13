<!DOCTYPE html>
<html lang="en">
<?php
include("../connection/connect.php");
error_reporting(E_ALL);
session_start();

$error_message = "";
$success_message = "";

if(isset($_POST['submit']))
{
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = $_POST['password'];
	
	if(!empty($username) && !empty($password)) 
    {
		$loginquery = "SELECT * FROM admin WHERE username='$username' AND password='".md5($password)."'";
		$result = mysqli_query($db, $loginquery);
		
		if($result && mysqli_num_rows($result) > 0) {
			$row = mysqli_fetch_array($result);
			$_SESSION["adm_id"] = $row['adm_id'];
			$success_message = "Login successful! Redirecting...";
			header("refresh:1;url=dashboard.php");
			exit();
		} else {
			$error_message = "Invalid Username or Password!";
		}
	} else {
		$error_message = "Please enter both username and password!";
	}
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - AP</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/admin-peak-design.css">
</head>
<body>
    <div class="admin-login-wrapper">
        <div class="admin-login-card">
            <div class="admin-login-logo">
                <span>AP</span>
            </div>
            <h1 class="admin-login-title">Admin Panel</h1>
            <p class="admin-login-subtitle">Sign in to manage your platform</p>
            
            <?php if($error_message): ?>
                <div style="background: #FED7D7; color: #C53030; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.875rem;">
                    <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            
            <?php if($success_message): ?>
                <div style="background: #C6F6D5; color: #22543D; padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem; font-size: 0.875rem;">
                    <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
                </div>
            <?php endif; ?>
            
            <form method="post" action="index.php">
                <div class="admin-form-group">
                    <label class="admin-form-label">Username</label>
                    <input type="text" name="username" class="admin-form-input" placeholder="Enter your username" required>
                </div>
                
                <div class="admin-form-group">
                    <label class="admin-form-label">Password</label>
                    <input type="password" name="password" class="admin-form-input" placeholder="Enter your password" required>
                </div>
                
                <button type="submit" name="submit" class="admin-btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Sign In
                </button>
            </form>
        </div>
    </div>
</body>
</html>
