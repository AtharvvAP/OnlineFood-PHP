<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");  
error_reporting(0);  
session_start(); 
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">   
    <meta name="description" content="Order delicious food online from Golden Era Cafe">
    <meta name="author" content="Golden Era Cafe">
    <link rel="icon" href="images/gelogo2.png">
    <title>Golden Era Cafe - Order Delicious Food Online</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Peak Design CSS -->
    <link href="css/peak-design.css" rel="stylesheet">
</head>

<body>
    
    <!-- Modern Navigation -->
    <nav class="peak-nav" id="mainNav">
        <div class="container">
            <div class="peak-nav-inner">
                <a href="index.php" class="peak-logo">
                    <img src="images/gelogo2.png" alt="Golden Era Cafe">
                </a>
                
                <button class="peak-nav-toggle" id="navToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <ul class="peak-nav-menu" id="navMenu">
                    <li><a href="index.php" class="peak-nav-link active"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="restaurants.php" class="peak-nav-link"><i class="fas fa-utensils"></i> Menu</a></li>
                    
                    <?php if(empty($_SESSION["user_id"])) { ?>
                        <li><a href="login.php" class="peak-nav-link"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                        <li><a href="registration.php" class="peak-btn-primary"><i class="fas fa-user-plus"></i> Sign Up</a></li>
                    <?php } else { ?>
                        <li><a href="your_orders.php" class="peak-nav-link"><i class="fas fa-shopping-bag"></i> My Orders</a></li>
                        <li><a href="logout.php" class="peak-btn-primary"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="peak-hero">
        <div class="container">
            <div class="peak-hero-content">
                <h1 class="peak-hero-title">Welcome to Golden Era Cafe</h1>
                <p class="peak-hero-subtitle">
                    Experience the finest cuisine delivered right to your doorstep. 
                    Fresh ingredients, authentic flavors, and exceptional service.
                </p>
                
                <div class="peak-hero-steps">
                    <div class="peak-step">
                        <div class="peak-step-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h4 class="peak-step-title">Choose Your Food</h4>
                    </div>
                    
                    <div class="peak-step">
                        <div class="peak-step-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h4 class="peak-step-title">Place Your Order</h4>
                    </div>
                    
                    <div class="peak-step">
                        <div class="peak-step-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <h4 class="peak-step-title">Fast Delivery</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Dishes Section -->
    <section class="peak-section">
        <div class="container">
            <div class="peak-section-header">
                <h2 class="peak-section-title">Our Popular Dishes</h2>
                <p class="peak-section-subtitle">
                    Discover our most loved dishes, crafted with passion and served with care
                </p>
            </div>
            
            <div class="peak-dishes-grid">
                <?php 					
                $query_res = mysqli_query($db, "SELECT * FROM dishes LIMIT 6"); 
                while($r = mysqli_fetch_array($query_res)) {
                    $discount = isset($r['discount']) ? floatval($r['discount']) : 0;
                    $original_price = floatval($r['price']);
                    $discounted_price = $original_price;
                    
                    if($discount > 0) {
                        $discounted_price = $original_price - ($original_price * $discount / 100);
                    }
                ?>
                    <div class="peak-dish-card">
                        <div class="peak-dish-image">
                            <?php if($discount > 0) { ?>
                                <div class="peak-discount-badge">
                                    <?php echo $discount; ?>% OFF
                                </div>
                            <?php } ?>
                            <img src="admin/Res_img/dishes/<?php echo $r['img']; ?>" alt="<?php echo $r['title']; ?>">
                        </div>
                        
                        <div class="peak-dish-content">
                            <h3 class="peak-dish-title">
                                <a href="dishes.php?res_id=<?php echo $r['rs_id']; ?>">
                                    <?php echo $r['title']; ?>
                                </a>
                            </h3>
                            
                            <p class="peak-dish-description">
                                <?php echo $r['slogan']; ?>
                            </p>
                            
                            <div class="peak-dish-footer">
                                <div class="peak-price-wrapper">
                                    <?php if($discount > 0) { ?>
                                        <span class="peak-price-original">₹<?php echo number_format($original_price, 2); ?></span>
                                        <span class="peak-price-current">₹<?php echo number_format($discounted_price, 2); ?></span>
                                    <?php } else { ?>
                                        <span class="peak-price-current">₹<?php echo number_format($original_price, 2); ?></span>
                                    <?php } ?>
                                </div>
                                
                                <a href="dishes.php?res_id=<?php echo $r['rs_id']; ?>" class="peak-order-btn">
                                    <i class="fas fa-shopping-cart"></i> Order Now
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="peak-footer">
        <div class="container">
            <div class="peak-footer-content">
                <div class="peak-footer-section">
                    <h5>About Us</h5>
                    <p>Golden Era Cafe brings you the finest dining experience with authentic flavors and exceptional service.</p>
                </div>
                
                <div class="peak-footer-section">
                    <h5>Contact</h5>
                    <p>Near Rankala, Kolhapur</p>
                    <p>Phone: 9112348220</p>
                </div>
                
                <div class="peak-footer-section">
                    <h5>Quick Links</h5>
                    <p><a href="index.php">Home</a></p>
                    <p><a href="restaurants.php">Menu</a></p>
                    <p><a href="login.php">Login</a></p>
                </div>
                
                <div class="peak-footer-section">
                    <h5>Payment Options</h5>
                    <div class="peak-payment-icons">
                        <img src="images/paypal.png" alt="Paypal">
                        <img src="images/mastercard.png" alt="Mastercard">
                        <img src="images/maestro.png" alt="Maestro">
                        <img src="images/stripe.png" alt="Stripe">
                    </div>
                </div>
            </div>
            
            <div class="peak-footer-bottom">
                <p>&copy; 2024 Golden Era Cafe. All rights reserved. | Designed with ❤️</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile Navigation Toggle
        document.getElementById('navToggle').addEventListener('click', function() {
            document.getElementById('navMenu').classList.toggle('active');
        });
        
        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('mainNav');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });
        
        // Smooth Scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
