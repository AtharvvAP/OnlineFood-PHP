<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php"); 
error_reporting(0); 
session_start(); 

if(isset($_POST['submit'])) {
    $username = $_POST['username'];  
    $password = $_POST['password'];
    
    if(!empty($_POST["submit"])) {
        $loginquery = "SELECT * FROM users WHERE username='$username' && password='".md5($password)."'";
        $result = mysqli_query($db, $loginquery);
        $row = mysqli_fetch_array($result);
        
        if(is_array($row)) {
            $_SESSION["user_id"] = $row['u_id']; 
            header("refresh:1;url=index.php"); 
        } else {
            $message = "Invalid Username or Password!"; 
        }
    }
}
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Golden Era Cafe</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Peak Design CSS -->
    <link href="css/peak-design.css" rel="stylesheet">
    
    <style>
        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 2rem 0;
        }
        
        .auth-container {
            max-width: 450px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .auth-card {
            background: white;
            border-radius: 24px;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        
        .auth-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .auth-logo img {
            height: 60px;
            margin-bottom: 1rem;
        }
        
        .auth-title {
            font-family: 'Poppins', sans-serif;
            font-size: 1.875rem;
            font-weight: 700;
            color: #1A202C;
            text-align: center;
            margin-bottom: 0.5rem;
        }
        
        .auth-subtitle {
            text-align: center;
            color: #718096;
            margin-bottom: 2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            font-weight: 500;
            color: #2D3748;
            margin-bottom: 0.5rem;
            font-size: 0.9375rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            border: 2px solid #E2E8F0;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }
        
        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .form-input-icon {
            position: relative;
        }
        
        .form-input-icon i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #A0AEC0;
        }
        
        .form-input-icon .form-input {
            padding-left: 3rem;
        }
        
        .btn-auth {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }
        
        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }
        
        .auth-divider {
            text-align: center;
            margin: 1.5rem 0;
            color: #A0AEC0;
            position: relative;
        }
        
        .auth-divider::before,
        .auth-divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 45%;
            height: 1px;
            background: #E2E8F0;
        }
        
        .auth-divider::before {
            left: 0;
        }
        
        .auth-divider::after {
            right: 0;
        }
        
        .auth-link {
            text-align: center;
            margin-top: 1.5rem;
            color: #718096;
        }
        
        .auth-link a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
        }
        
        .auth-link a:hover {
            text-decoration: underline;
        }
        
        .alert {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9375rem;
        }
        
        .alert-error {
            background: #FED7D7;
            color: #C53030;
            border: 1px solid #FC8181;
        }
        
        .alert-success {
            background: #C6F6D5;
            color: #2F855A;
            border: 1px solid #68D391;
        }
        
        .back-home {
            text-align: center;
            margin-top: 2rem;
        }
        
        .back-home a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .back-home a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="auth-page">
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-logo">
                    <img src="images/gelogo2.png" alt="Golden Era Cafe">
                    <h1 class="auth-title">Welcome Back</h1>
                    <p class="auth-subtitle">Login to your account</p>
                </div>
                
                <?php if(isset($message)) { ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $message; ?>
                    </div>
                <?php } ?>
                
                <form method="post" action="">
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <div class="form-input-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" name="username" class="form-input" placeholder="Enter your username" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="form-input-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" class="form-input" placeholder="Enter your password" required>
                        </div>
                    </div>
                    
                    <button type="submit" name="submit" class="btn-auth">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </button>
                </form>
                
                <div class="auth-link">
                    Don't have an account? <a href="registration.php">Sign up</a>
                </div>
            </div>
            
            <div class="back-home">
                <a href="index.php">
                    <i class="fas fa-arrow-left"></i> Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>
