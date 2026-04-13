<?php
/**
 * Admin Password Reset Script
 * Use this to reset admin password if you forgot it
 */

include("../connection/connect.php");

$message = "";

if(isset($_POST['reset'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $new_password = $_POST['new_password'];
    
    if(!empty($username) && !empty($new_password)) {
        $hashed_password = md5($new_password);
        $update_query = "UPDATE admin SET password='$hashed_password' WHERE username='$username'";
        
        if(mysqli_query($db, $update_query)) {
            if(mysqli_affected_rows($db) > 0) {
                $message = "<div style='background: #C6F6D5; color: #22543D; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;'>
                    ✓ Password updated successfully!<br>
                    Username: $username<br>
                    New Password: $new_password<br>
                    <a href='index.php' style='color: #22543D; font-weight: bold;'>Go to Login</a>
                </div>";
            } else {
                $message = "<div style='background: #FED7D7; color: #C53030; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;'>
                    ✗ Username not found!
                </div>";
            }
        } else {
            $message = "<div style='background: #FED7D7; color: #C53030; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;'>
                ✗ Error: " . mysqli_error($db) . "
            </div>";
        }
    } else {
        $message = "<div style='background: #FED7D7; color: #C53030; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;'>
            ✗ Please fill all fields!
        </div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Admin Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #FF6B35, #FF8C42);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .reset-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            max-width: 450px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }
        h1 {
            color: #1A202C;
            margin-bottom: 0.5rem;
            font-size: 1.75rem;
        }
        p {
            color: #718096;
            margin-bottom: 1.5rem;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        label {
            display: block;
            font-weight: 600;
            color: #2D3748;
            margin-bottom: 0.5rem;
        }
        input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #E2E8F0;
            border-radius: 12px;
            font-size: 1rem;
            background: #F7FAFC;
        }
        input:focus {
            outline: none;
            border-color: #FF6B35;
            background: white;
        }
        button {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #FF6B35, #FF8C42);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 1rem;
        }
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(255, 107, 53, 0.4);
        }
        .info-box {
            background: #EBF8FF;
            color: #2C5282;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="reset-card">
        <h1>Reset Admin Password</h1>
        <p>Enter username and new password</p>
        
        <?php echo $message; ?>
        
        <div class="info-box">
            <strong>Default Credentials:</strong><br>
            Username: admin<br>
            Password: codeastro
        </div>
        
        <form method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="admin" required>
            </div>
            
            <div class="form-group">
                <label>New Password</label>
                <input type="text" name="new_password" placeholder="Enter new password" required>
            </div>
            
            <button type="submit" name="reset">Reset Password</button>
        </form>
        
        <div style="text-align: center; margin-top: 1rem;">
            <a href="index.php" style="color: #FF6B35; text-decoration: none; font-weight: 500;">← Back to Login</a>
        </div>
    </div>
</body>
</html>
