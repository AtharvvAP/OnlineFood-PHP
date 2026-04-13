<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
error_reporting(0);
session_start();
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu - Golden Era Cafe</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="css/peak-design.css" rel="stylesheet">
</head>

<body>
    <nav class="peak-nav" id="mainNav">
        <div class="container">
            <div class="peak-nav-inner">
                <a href="index.php" class="peak-logo" style="text-decoration: none; display: flex; align-items: center; gap: 8px;">
                    <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #FF6B35, #FF8C42); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3); position: relative; overflow: hidden;">
                        <div style="position: absolute; width: 100%; height: 100%; background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.3), transparent); pointer-events: none;"></div>
                        <span style="font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 900; color: white; letter-spacing: -2px; text-shadow: 0 2px 8px rgba(0,0,0,0.2);">AP</span>
                    </div>
                </a>
                <button class="peak-nav-toggle" id="navToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <ul class="peak-nav-menu" id="navMenu">
                    <li><a href="index.php" class="peak-nav-link"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="restaurants.php" class="peak-nav-link active"><i class="fas fa-utensils"></i> Menu</a></li>
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

    <section class="peak-section" style="padding-top: 120px;">
        <div class="container">
            <div class="peak-section-header">
                <h2 class="peak-section-title">Our Menu</h2>
                <p class="peak-section-subtitle">Choose from our delicious selection</p>
            </div>
            
            <style>
                .menu-grid {
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    gap: 24px;
                    padding: 20px 0;
                }
                .menu-card {
                    background: white;
                    border-radius: 20px;
                    overflow: hidden;
                    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
                    transition: all 0.4s ease;
                    cursor: pointer;
                }
                .menu-card:hover {
                    transform: translateY(-8px);
                    box-shadow: 0 20px 60px rgba(255, 107, 53, 0.2);
                }
                .menu-card-image {
                    height: 220px;
                    overflow: hidden;
                    background: #F7FAFC;
                    position: relative;
                }
                .menu-card-image img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    transition: transform 0.6s ease;
                }
                .menu-card:hover .menu-card-image img {
                    transform: scale(1.1);
                }
                .menu-card-content {
                    padding: 24px;
                }
                .menu-card-title {
                    font-size: 1.4rem;
                    font-weight: 600;
                    color: #1A202C;
                    margin-bottom: 12px;
                    line-height: 1.3;
                }
                .menu-card-title a {
                    color: #1A202C;
                    text-decoration: none;
                    transition: color 0.3s ease;
                }
                .menu-card-title a:hover {
                    color: #FF6B35;
                }
                .menu-card-address {
                    color: #718096;
                    font-size: 0.95rem;
                    margin-bottom: 16px;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                }
                .menu-card-footer {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding-top: 16px;
                    border-top: 2px solid #F7FAFC;
                }
                .menu-card-hours {
                    color: #718096;
                    font-size: 0.9rem;
                    display: flex;
                    align-items: center;
                    gap: 6px;
                }
                @media (max-width: 1200px) {
                    .menu-grid {
                        grid-template-columns: repeat(2, 1fr);
                    }
                }
                @media (max-width: 768px) {
                    .menu-grid {
                        grid-template-columns: 1fr;
                        gap: 20px;
                    }
                }
            </style>
            
            <div class="menu-grid">
                <?php 
                $ress = mysqli_query($db, "select * from restaurant");
                while($rows = mysqli_fetch_array($ress)) {
                ?>
                    <div class="menu-card" onclick="window.location.href='dishes.php?res_id=<?php echo $rows['rs_id']; ?>'">
                        <div class="menu-card-image">
                            <img src="admin/Res_img/<?php echo $rows['image']; ?>" alt="<?php echo $rows['title']; ?>">
                        </div>
                        <div class="menu-card-content">
                            <h3 class="menu-card-title">
                                <a href="dishes.php?res_id=<?php echo $rows['rs_id']; ?>">
                                    <?php echo $rows['title']; ?>
                                </a>
                            </h3>
                            <p class="menu-card-address">
                                <i class="fas fa-map-marker-alt"></i> <?php echo $rows['address']; ?>
                            </p>
                            <div class="menu-card-footer">
                                <span class="menu-card-hours">
                                    <i class="fas fa-clock"></i> <?php echo $rows['o_hr']; ?> - <?php echo $rows['c_hr']; ?>
                                </span>
                                <a href="dishes.php?res_id=<?php echo $rows['rs_id']; ?>" class="peak-order-btn" onclick="event.stopPropagation();">
                                    <i class="fas fa-arrow-right"></i> Order
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <footer class="peak-footer">
        <div class="container">
            <div class="peak-footer-content">
                <div class="peak-footer-section">
                    <h5>About Us</h5>
                    <p>Golden Era Cafe brings you the finest dining experience.</p>
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
                </div>
                <div class="peak-footer-section">
                    <h5>Payment Options</h5>
                    <div class="peak-payment-icons">
                        <img src="images/paypal.png" alt="Paypal">
                        <img src="images/mastercard.png" alt="Mastercard">
                    </div>
                </div>
            </div>
            <div class="peak-footer-bottom">
                <p>&copy; 2024 Golden Era Cafe. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('navToggle').addEventListener('click', function() {
            document.getElementById('navMenu').classList.toggle('active');
        });
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('mainNav');
            if (window.scrollY > 50) nav.classList.add('scrolled');
            else nav.classList.remove('scrolled');
        });
    </script>
</body>
</html>
