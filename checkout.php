<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php");
include_once 'product-action.php';
error_reporting(0);
session_start();

function function_alert() { 
    echo "<script>alert('Thank you. Your Order has been placed!');</script>"; 
    echo "<script>window.location.replace('your_orders.php');</script>"; 
} 

if(empty($_SESSION["user_id"])) {
	header('location:login.php');
	exit;
}

$item_total = 0;
if(isset($_SESSION["cart_item"])) {
    foreach ($_SESSION["cart_item"] as $item) {
        $item_total += ($item["price"]*$item["quantity"]);
        
        if($_POST['submit']) {
            $SQL = "insert into users_orders(u_id,title,quantity,price) values('".$_SESSION["user_id"]."','".$item["title"]."','".$item["quantity"]."','".$item["price"]."')";
            mysqli_query($db,$SQL);
            unset($_SESSION["cart_item"]);
            $success = "Thank you. Your order has been placed!";
            function_alert();
        }
    }
}
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - Golden Era Cafe</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="css/peak-design.css" rel="stylesheet">
    <style>
        .checkout-container { max-width: 600px; margin: 0 auto; }
        .checkout-card { background: white; border-radius: 20px; padding: 2rem; box-shadow: 0 10px 40px rgba(0,0,0,0.08); margin-bottom: 2rem; }
        .checkout-title { font-size: 1.5rem; font-weight: 700; color: #1A202C; margin-bottom: 1.5rem; }
        .order-item { display: flex; justify-content: space-between; padding: 1rem 0; border-bottom: 1px solid #E2E8F0; }
        .order-item:last-child { border-bottom: none; }
        .order-total { display: flex; justify-content: space-between; padding-top: 1.5rem; margin-top: 1.5rem; border-top: 2px solid #E2E8F0; font-size: 1.25rem; font-weight: 700; }
        .payment-option { padding: 1rem; border: 2px solid #E2E8F0; border-radius: 12px; margin-bottom: 1rem; cursor: pointer; transition: all 0.3s ease; }
        .payment-option:hover { border-color: #667eea; background: #F7FAFC; }
        .payment-option input[type="radio"] { margin-right: 0.75rem; }
        .payment-option.selected { border-color: #667eea; background: #EBF4FF; }
    </style>
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
                <button class="peak-nav-toggle" id="navToggle"><i class="fas fa-bars"></i></button>
                <ul class="peak-nav-menu" id="navMenu">
                    <li><a href="index.php" class="peak-nav-link"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="restaurants.php" class="peak-nav-link"><i class="fas fa-utensils"></i> Menu</a></li>
                    <li><a href="your_orders.php" class="peak-nav-link"><i class="fas fa-shopping-bag"></i> My Orders</a></li>
                    <li><a href="logout.php" class="peak-btn-primary"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="peak-section" style="padding-top: 120px;">
        <div class="checkout-container">
            <div class="peak-section-header">
                <h2 class="peak-section-title">Checkout</h2>
                <p class="peak-section-subtitle">Review your order and complete payment</p>
            </div>

            <?php if(isset($success)) { ?>
                <div style="background: #C6F6D5; color: #2F855A; padding: 1rem; border-radius: 12px; margin-bottom: 2rem;">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php } ?>

            <div class="checkout-card">
                <h3 class="checkout-title"><i class="fas fa-shopping-cart"></i> Order Summary</h3>
                <?php
                if(isset($_SESSION["cart_item"])) {
                    foreach ($_SESSION["cart_item"] as $item) {
                ?>
                    <div class="order-item">
                        <div>
                            <strong><?php echo $item["title"]; ?></strong>
                            <div style="color: #718096; font-size: 0.875rem;">Qty: <?php echo $item["quantity"]; ?></div>
                        </div>
                        <div style="font-weight: 600;">₹<?php echo number_format($item["price"]*$item["quantity"], 2); ?></div>
                    </div>
                <?php }} ?>
                
                <div class="order-total">
                    <span>Total Amount</span>
                    <span style="color: #FF6B35;">₹<?php echo number_format($item_total, 2); ?></span>
                </div>
            </div>

            <form method="post" action="">
                <div class="checkout-card">
                    <h3 class="checkout-title"><i class="fas fa-credit-card"></i> Payment Method</h3>
                    
                    <label class="payment-option">
                        <input type="radio" name="mod" value="COD" checked>
                        <i class="fas fa-money-bill-wave"></i> Cash on Delivery
                    </label>
                    
                    <label class="payment-option">
                        <input type="radio" name="mod" value="paypal">
                        <i class="fab fa-paypal"></i> PayPal
                    </label>
                </div>

                <button type="submit" name="submit" onclick="return confirm('Do you want to confirm the order?');" 
                        class="peak-btn-primary" style="width: 100%; padding: 1.25rem; font-size: 1.125rem;">
                    <i class="fas fa-check-circle"></i> Place Order
                </button>
            </form>
        </div>
    </section>

    <footer class="peak-footer">
        <div class="container">
            <div class="peak-footer-bottom">
                <p>&copy; 2024 Golden Era Cafe. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('navToggle').addEventListener('click', function() {
            document.getElementById('navMenu').classList.toggle('active');
        });
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.payment-option').forEach(o => o.classList.remove('selected'));
                this.classList.add('selected');
                this.querySelector('input[type="radio"]').checked = true;
            });
        });
    </script>
</body>
</html>
