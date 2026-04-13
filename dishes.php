<!DOCTYPE html>
<html lang="en">
<?php
include("connection/connect.php"); 
error_reporting(0);
session_start();
include_once 'product-action.php'; 

$ress = mysqli_query($db,"select * from restaurant where rs_id='$_GET[res_id]'");
$rows = mysqli_fetch_array($ress);
?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dishes - Golden Era Cafe</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="css/peak-design.css" rel="stylesheet">
    <style>
        .cart-sidebar { position: sticky; top: 100px; background: white; border-radius: 20px; padding: 2rem; box-shadow: 0 10px 40px rgba(0,0,0,0.08); }
        .cart-title { font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem; color: #1A202C; }
        .cart-item { padding: 1rem 0; border-bottom: 1px solid #E2E8F0; }
        .cart-item:last-child { border-bottom: none; }
        .cart-item-title { font-weight: 600; color: #2D3748; margin-bottom: 0.5rem; display: flex; justify-content: space-between; align-items: center; }
        .cart-item-details { display: flex; justify-content: space-between; align-items: center; gap: 0.5rem; }
        .cart-total { margin-top: 1.5rem; padding-top: 1.5rem; border-top: 2px solid #E2E8F0; }
        .cart-total-label { font-size: 1.125rem; font-weight: 600; color: #2D3748; }
        .cart-total-value { font-size: 1.5rem; font-weight: 700; color: #FF6B35; }
        .dish-list { display: grid; gap: 1.5rem; }
        .dish-item { background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 20px rgba(0,0,0,0.06); transition: all 0.3s ease; }
        .dish-item:hover { box-shadow: 0 8px 30px rgba(0,0,0,0.12); transform: translateY(-2px); }
        .dish-item-content { display: grid; grid-template-columns: 100px 1fr auto; gap: 1.5rem; align-items: center; }
        .dish-item-img { width: 100px; height: 100px; border-radius: 12px; overflow: hidden; }
        .dish-item-img img { width: 100%; height: 100%; object-fit: cover; }
        .dish-item-info h4 { font-size: 1.25rem; font-weight: 600; color: #1A202C; margin-bottom: 0.5rem; }
        .dish-item-info p { color: #718096; font-size: 0.9375rem; }
        .dish-item-actions { display: flex; flex-direction: column; gap: 0.75rem; align-items: flex-end; }
        .dish-price { font-size: 1.5rem; font-weight: 700; color: #FF6B35; }
        .dish-price-original { text-decoration: line-through; color: #A0AEC0; font-size: 1rem; }
        .add-to-cart-form { display: flex; gap: 0.5rem; align-items: center; }
        .qty-input { width: 60px; padding: 0.5rem; border: 2px solid #E2E8F0; border-radius: 8px; text-align: center; }
        @media (max-width: 768px) { .dish-item-content { grid-template-columns: 1fr; text-align: center; } .dish-item-actions { align-items: center; } }
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
            <div style="background: linear-gradient(135deg, #FF6B35, #FF8C42); padding: 2rem; border-radius: 20px; margin-bottom: 2rem; color: white;">
                <h2 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;"><?php echo $rows['title']; ?></h2>
                <p style="opacity: 0.9;"><i class="fas fa-map-marker-alt"></i> <?php echo $rows['address']; ?></p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 350px; gap: 2rem;">
                <div class="dish-list">
                    <?php  
                    $stmt = $db->prepare("select * from dishes where rs_id='$_GET[res_id]'");
                    $stmt->execute();
                    $products = $stmt->get_result();
                    if (!empty($products)) {
                        foreach($products as $product) {
                            $discount = isset($product['discount']) ? $product['discount'] : 0;
                            $original_price = $product['price'];
                            $discounted_price = $discount > 0 ? $original_price - ($original_price * $discount / 100) : $original_price;
                    ?>
                        <div class="dish-item">
                            <div class="dish-item-content">
                                <div class="dish-item-img">
                                    <img src="admin/Res_img/dishes/<?php echo $product['img']; ?>" alt="<?php echo $product['title']; ?>">
                                </div>
                                <div class="dish-item-info">
                                    <h4><?php echo $product['title']; ?></h4>
                                    <p><?php echo $product['slogan']; ?></p>
                                </div>
                                <div class="dish-item-actions">
                                    <div>
                                        <?php if($discount > 0) { ?>
                                            <div class="dish-price-original">₹<?php echo $original_price; ?></div>
                                            <div class="dish-price">₹<?php echo number_format($discounted_price, 2); ?></div>
                                            <span style="background: #48BB78; color: white; padding: 4px 8px; border-radius: 6px; font-size: 0.75rem; font-weight: 600;"><?php echo $discount; ?>% OFF</span>
                                        <?php } else { ?>
                                            <div class="dish-price">₹<?php echo $original_price; ?></div>
                                        <?php } ?>
                                    </div>
                                    <form method="post" action="dishes.php?res_id=<?php echo $_GET['res_id'];?>&action=add&id=<?php echo $product['d_id']; ?>" class="add-to-cart-form">
                                        <input type="number" name="quantity" value="1" min="1" class="qty-input">
                                        <button type="submit" class="peak-order-btn" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                            <i class="fas fa-cart-plus"></i> Add
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php }} ?>
                </div>

                <div class="cart-sidebar">
                    <h3 class="cart-title"><i class="fas fa-shopping-cart"></i> Your Cart</h3>
                    <?php
                    $item_total = 0;
                    if(isset($_SESSION["cart_item"]) && !empty($_SESSION["cart_item"])) {
                        foreach ($_SESSION["cart_item"] as $item) {
                            $item_total += ($item["price"]*$item["quantity"]);
                    ?>
                        <div class="cart-item">
                            <div class="cart-item-title">
                                <span><?php echo $item["title"]; ?></span>
                                <a href="dishes.php?res_id=<?php echo $_GET['res_id']; ?>&action=remove&id=<?php echo $item["d_id"]; ?>" style="color: #F56565;">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                            <div class="cart-item-details">
                                <span>₹<?php echo number_format($item["price"], 2); ?> × <?php echo $item["quantity"]; ?></span>
                                <strong>₹<?php echo number_format($item["price"]*$item["quantity"], 2); ?></strong>
                            </div>
                        </div>
                    <?php }} else { ?>
                        <p style="text-align: center; color: #A0AEC0; padding: 2rem 0;">Cart is empty</p>
                    <?php } ?>
                    
                    <div class="cart-total">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <span class="cart-total-label">Total</span>
                            <span class="cart-total-value">₹<?php echo number_format($item_total, 2); ?></span>
                        </div>
                        <?php if($item_total > 0) { ?>
                            <a href="checkout.php?res_id=<?php echo $_GET['res_id'];?>&action=check" class="peak-btn-primary" style="display: block; text-align: center; text-decoration: none; padding: 1rem;">
                                <i class="fas fa-check-circle"></i> Checkout
                            </a>
                        <?php } else { ?>
                            <button class="peak-btn-primary" style="width: 100%; opacity: 0.5; cursor: not-allowed;" disabled>
                                <i class="fas fa-check-circle"></i> Checkout
                            </button>
                        <?php } ?>
                    </div>
                </div>
            </div>
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
    </script>
</body>
</html>
