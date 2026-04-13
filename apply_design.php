<?php
/**
 * Peak Design Applicator
 * This script helps apply the peak design to all pages
 */

echo "<!DOCTYPE html>
<html>
<head>
    <title>Apply Peak Design</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f7fafc;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        h1 {
            color: #1a202c;
            margin-bottom: 10px;
        }
        .status {
            padding: 10px 15px;
            border-radius: 8px;
            margin: 10px 0;
        }
        .success {
            background: #c6f6d5;
            color: #2f855a;
        }
        .info {
            background: #bee3f8;
            color: #2c5282;
        }
        .warning {
            background: #feebc8;
            color: #c05621;
        }
        .btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
        }
        .btn:hover {
            opacity: 0.9;
        }
        .file-list {
            list-style: none;
            padding: 0;
        }
        .file-list li {
            padding: 10px;
            border-bottom: 1px solid #e2e8f0;
        }
        .file-list li:last-child {
            border-bottom: none;
        }
        .check {
            color: #48bb78;
            margin-right: 10px;
        }
        .cross {
            color: #f56565;
            margin-right: 10px;
        }
    </style>
</head>
<body>";

echo "<div class='card'>";
echo "<h1>🎨 Peak Design System</h1>";
echo "<p>Apply modern design to all pages in your project</p>";
echo "</div>";

// Check if peak-design.css exists
$cssExists = file_exists('css/peak-design.css');

echo "<div class='card'>";
echo "<h2>Status Check</h2>";

if ($cssExists) {
    echo "<div class='status success'>✅ Peak Design CSS is installed</div>";
} else {
    echo "<div class='status warning'>⚠️ Peak Design CSS not found</div>";
}

// Check pages
$pages = [
    'index.php' => 'Homepage',
    'login.php' => 'Login Page',
    'registration.php' => 'Registration Page',
    'restaurants.php' => 'Restaurants/Menu',
    'dishes.php' => 'Dishes Page',
    'your_orders.php' => 'Orders Page',
    'checkout.php' => 'Checkout Page'
];

echo "<h3>Pages Status:</h3>";
echo "<ul class='file-list'>";

foreach ($pages as $file => $name) {
    $exists = file_exists($file);
    $content = $exists ? file_get_contents($file) : '';
    $hasPeakDesign = strpos($content, 'peak-design.css') !== false;
    
    echo "<li>";
    if ($hasPeakDesign) {
        echo "<span class='check'>✅</span> <strong>$name</strong> - Peak design applied";
    } else if ($exists) {
        echo "<span class='cross'>❌</span> <strong>$name</strong> - Needs update";
    } else {
        echo "<span class='cross'>❌</span> <strong>$name</strong> - File not found";
    }
    echo "</li>";
}

echo "</ul>";
echo "</div>";

// Instructions
echo "<div class='card'>";
echo "<h2>How to Apply</h2>";
echo "<div class='status info'>";
echo "<strong>Method 1: Automatic (Recommended)</strong><br>";
echo "1. I've created <code>index.php</code> with peak design<br>";
echo "2. I've created <code>login_modern.php</code> as example<br>";
echo "3. Copy the navigation and CSS links from these files to other pages";
echo "</div>";

echo "<div class='status info' style='margin-top: 15px;'>";
echo "<strong>Method 2: Manual Update</strong><br>";
echo "Add these lines to the &lt;head&gt; of each page:<br><br>";
echo "<code style='background: #f7fafc; padding: 10px; display: block; border-radius: 4px;'>";
echo htmlspecialchars('<link href="css/peak-design.css" rel="stylesheet">');
echo "</code>";
echo "</div>";

echo "<h3 style='margin-top: 20px;'>Quick Links:</h3>";
echo "<a href='index.php' class='btn'>View Homepage</a>";
echo "<a href='login_modern.php' class='btn'>View Modern Login</a>";
echo "<a href='ALL_PAGES_UPDATED.md' class='btn'>Read Guide</a>";

echo "</div>";

echo "<div class='card'>";
echo "<h2>Need Help?</h2>";
echo "<p>If you need me to create a modern version of any specific page, just ask!</p>";
echo "<p><strong>Example:</strong> 'Create modern version of restaurants.php'</p>";
echo "</div>";

echo "</body></html>";
?>
