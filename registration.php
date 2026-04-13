<!DOCTYPE html>
<html lang="en">
<?php
session_start(); 
error_reporting(0); 
include("connection/connect.php"); 

if(isset($_POST['submit'])) {
    if(empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['password']) || empty($_POST['cpassword'])) {
        $message = "All fields must be Required!";
    } else {
        $check_username = mysqli_query($db, "SELECT username FROM users where username = '".$_POST['username']."'");
        $check_email = mysqli_query($db, "SELECT email FROM users where email = '".$_POST['email']."'");
        
        if($_POST['password'] != $_POST['cpassword']) {  
            $message = "Password not match";
        } elseif(strlen($_POST['password']) < 6) {
            $message = "Password Must be >=6";
        } elseif(strlen($_POST['phone']) < 10) {
            $message = "Invalid phone number!";
        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $message = "Invalid email address!";
        } elseif(mysqli_num_rows($check_username) > 0) {
            $message = "Username Already exists!";
        } elseif(mysqli_num_rows($check_email) > 0) {
            $message = "Email Already exists!";
        } else {
            $mql = "INSERT INTO users(username,f_name,l_name,email,phone,password,address) VALUES('".$_POST['username']."','".$_POST['firstname']."','".$_POST['lastname']."','".$_POST['email']."','".$_POST['phone']."','".md5($_POST['password'])."','".$_POST['address']."')";
            mysqli_query($db, $mql);
            $success = "Registration successful! Redirecting to login...";
            header("refresh:2;url=login.php");
        }
    }
}
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up - Golden Era Cafe</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; overflow-x: hidden; }
        
        .auth-container { display: grid; grid-template-columns: 1fr 1fr; min-height: 100vh; }
        
        .auth-left {
            background: linear-gradient(135deg, #FF6B35 0%, #FF8C42 50%, #FFA552 100%);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem;
            overflow: hidden;
        }
        
        .auth-left::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
            background-size: cover;
            background-position: bottom;
            animation: wave 20s ease-in-out infinite;
        }
        
        @keyframes wave {
            0%, 100% { transform: translateX(0) translateY(0); }
            50% { transform: translateX(-30px) translateY(-15px); }
        }
        
        .auth-brand { position: relative; z-index: 10; text-align: center; color: white; }
        .auth-brand h1 { font-family: 'Playfair Display', serif; font-size: 3rem; font-weight: 900; margin-bottom: 1rem; text-shadow: 0 4px 20px rgba(0,0,0,0.2); animation: fadeInUp 0.8s ease; }
        .auth-brand p { font-size: 1.25rem; opacity: 0.95; line-height: 1.8; max-width: 400px; animation: fadeInUp 0.8s ease 0.2s both; }
        
        .auth-features { position: relative; z-index: 10; margin-top: 3rem; display: grid; gap: 1.5rem; }
        .auth-feature { display: flex; align-items: center; gap: 1rem; color: white; animation: fadeInUp 0.8s ease 0.4s both; }
        .auth-feature-icon { width: 50px; height: 50px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; }
        .auth-feature-text { text-align: left; }
        .auth-feature-text h4 { font-weight: 600; margin-bottom: 0.25rem; }
        .auth-feature-text p { font-size: 0.875rem; opacity: 0.9; }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .auth-right { background: #F7FAFC; display: flex; align-items: center; justify-content: center; padding: 3rem; overflow-y: auto; }
        .auth-form-container { width: 100%; max-width: 500px; }
        .auth-form-header { margin-bottom: 2rem; }
        .auth-form-header h2 { font-family: 'Poppins', sans-serif; font-size: 2.25rem; font-weight: 700; color: #1A202C; margin-bottom: 0.5rem; }
        .auth-form-header p { color: #718096; font-size: 1.0625rem; }
        
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-group { margin-bottom: 1.25rem; }
        .form-label { display: block; font-weight: 600; color: #2D3748; margin-bottom: 0.5rem; font-size: 0.9375rem; }
        .form-input-wrapper { position: relative; }
        .form-input-wrapper i { position: absolute; left: 1.25rem; top: 50%; transform: translateY(-50%); color: #A0AEC0; font-size: 1.125rem; }
        .form-input, .form-textarea { width: 100%; padding: 1rem 1rem 1rem 3.5rem; font-size: 1rem; border: 2px solid #E2E8F0; border-radius: 12px; transition: all 0.3s ease; font-family: 'Inter', sans-serif; background: white; }
        .form-textarea { resize: vertical; min-height: 80px; padding: 1rem; }
        .form-input:focus, .form-textarea:focus { outline: none; border-color: #FF6B35; box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.1); }
        
        .btn-submit { width: 100%; padding: 1.125rem; background: linear-gradient(135deg, #FF6B35, #FF8C42); color: white; border: none; border-radius: 12px; font-weight: 600; font-size: 1.0625rem; cursor: pointer; transition: all 0.3s ease; margin-top: 0.5rem; box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3); }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 25px rgba(255, 107, 53, 0.4); }
        
        .auth-divider { text-align: center; margin: 1.5rem 0; color: #A0AEC0; position: relative; }
        .auth-divider::before, .auth-divider::after { content: ''; position: absolute; top: 50%; width: 45%; height: 1px; background: #E2E8F0; }
        .auth-divider::before { left: 0; }
        .auth-divider::after { right: 0; }
        
        .auth-link { text-align: center; color: #718096; font-size: 0.9375rem; }
        .auth-link a { color: #FF6B35; font-weight: 600; text-decoration: none; transition: all 0.3s ease; }
        .auth-link a:hover { color: #FF8C42; text-decoration: underline; }
        
        .alert { padding: 1rem 1.25rem; border-radius: 12px; margin-bottom: 1.5rem; font-size: 0.9375rem; display: flex; align-items: center; gap: 0.75rem; }
        .alert-error { background: #FED7D7; color: #C53030; border: 1px solid #FC8181; }
        .alert-success { background: #C6F6D5; color: #2F855A; border: 1px solid #68D391; }
        
        .back-home { position: absolute; top: 2rem; right: 2rem; z-index: 100; }
        .back-home a { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); color: white; text-decoration: none; border-radius: 50px; font-weight: 500; transition: all 0.3s ease; }
        .back-home a:hover { background: rgba(255,255,255,0.3); transform: translateY(-2px); }
        
        @media (max-width: 968px) {
            .auth-container { grid-template-columns: 1fr; }
            .auth-left { min-height: 40vh; padding: 2rem; }
            .auth-brand h1 { font-size: 2rem; }
            .auth-features { display: none; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
    <div class="back-home">
        <a href="index.php"><i class="fas fa-arrow-left"></i> Back to Home</a>
    </div>

    <div class="auth-container">
        <div class="auth-left">
            <div class="auth-brand">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #FF6B35, #FF8C42); border-radius: 20px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 30px rgba(255, 107, 53, 0.4); margin: 0 auto 1.5rem; position: relative; overflow: hidden;">
                    <div style="position: absolute; width: 100%; height: 100%; background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.3), transparent);"></div>
                    <span style="font-family: 'Playfair Display', serif; font-size: 2.5rem; font-weight: 900; color: white; letter-spacing: -3px; text-shadow: 0 2px 10px rgba(0,0,0,0.2);">AP</span>
                </div>
                <p>Join thousands of food lovers and start your culinary adventure today</p>
            </div>
            
            <div class="auth-features">
                <div class="auth-feature">
                    <div class="auth-feature-icon"><i class="fas fa-gift"></i></div>
                    <div class="auth-feature-text">
                        <h4>Exclusive Offers</h4>
                        <p>Get special discounts on first order</p>
                    </div>
                </div>
                
                <div class="auth-feature">
                    <div class="auth-feature-icon"><i class="fas fa-clock"></i></div>
                    <div class="auth-feature-text">
                        <h4>Quick Ordering</h4>
                        <p>Save time with easy reordering</p>
                    </div>
                </div>
                
                <div class="auth-feature">
                    <div class="auth-feature-icon"><i class="fas fa-heart"></i></div>
                    <div class="auth-feature-text">
                        <h4>Track Orders</h4>
                        <p>Real-time order status updates</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="auth-right">
            <div class="auth-form-container">
                <div class="auth-form-header">
                    <h2>Create Account</h2>
                    <p>Start your delicious journey with us</p>
                </div>
                
                <?php if(isset($message)) { ?>
                    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i><span><?php echo $message; ?></span></div>
                <?php } ?>
                <?php if(isset($success)) { ?>
                    <div class="alert alert-success"><i class="fas fa-check-circle"></i><span><?php echo $success; ?></span></div>
                <?php } ?>
                
                <form method="post" action="">
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <div class="form-input-wrapper">
                            <i class="fas fa-user"></i>
                            <input type="text" name="username" class="form-input" placeholder="Choose a username" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-user"></i>
                                <input type="text" name="firstname" class="form-input" placeholder="First name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-user"></i>
                                <input type="text" name="lastname" class="form-input" placeholder="Last name" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" class="form-input" placeholder="your@email.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone</label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-phone"></i>
                                <input type="tel" name="phone" class="form-input" placeholder="1234567890" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" class="form-input" placeholder="Min 6 characters" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="cpassword" class="form-input" placeholder="Confirm password" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Delivery Address</label>
                        <textarea name="address" class="form-textarea" placeholder="Enter your delivery address" required></textarea>
                    </div>
                    
                    <button type="submit" name="submit" class="btn-submit">
                        <i class="fas fa-user-plus"></i> Create Account
                    </button>
                </form>
                
                <div class="auth-divider">or</div>
                
                <div class="auth-link">
                    Already have an account? <a href="login.php">Login now</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
