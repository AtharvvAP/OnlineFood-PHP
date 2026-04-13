<?php
/**
 * Production Optimization Script
 * Prepares application for production deployment
 */

echo "=== Golden Era Cafe - Production Optimization ===\n\n";

// 1. Minify CSS
echo "1. Optimizing CSS files...\n";
$cssFiles = glob(__DIR__ . '/../assets/css/*.css');
foreach ($cssFiles as $file) {
    if (strpos($file, '.min.css') === false) {
        $css = file_get_contents($file);
        // Remove comments
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
        // Remove whitespace
        $css = str_replace(["\r\n", "\r", "\n", "\t", '  ', '    ', '    '], '', $css);
        $minFile = str_replace('.css', '.min.css', $file);
        file_put_contents($minFile, $css);
        echo "   ✓ Minified " . basename($file) . "\n";
    }
}

// 2. Minify JavaScript
echo "\n2. Optimizing JavaScript files...\n";
$jsFiles = glob(__DIR__ . '/../assets/js/*.js');
foreach ($jsFiles as $file) {
    if (strpos($file, '.min.js') === false) {
        $js = file_get_contents($file);
        // Remove comments
        $js = preg_replace('!/\*.*?\*/!s', '', $js);
        $js = preg_replace('/\n\s*\n/', "\n", $js);
        // Remove single-line comments
        $js = preg_replace('![ \t]*//.*[ \t]*[\r\n]!', '', $js);
        $minFile = str_replace('.js', '.min.js', $file);
        file_put_contents($minFile, $js);
        echo "   ✓ Minified " . basename($file) . "\n";
    }
}

// 3. Clear cache
echo "\n3. Clearing cache...\n";
$cacheDir = __DIR__ . '/../cache';
if (is_dir($cacheDir)) {
    $files = glob($cacheDir . '/*.cache');
    foreach ($files as $file) {
        unlink($file);
    }
    echo "   ✓ Cleared " . count($files) . " cache files\n";
} else {
    echo "   ✓ No cache to clear\n";
}

// 4. Generate sitemap
echo "\n4. Generating sitemap...\n";
$sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

$pages = [
    '' => ['priority' => '1.0', 'changefreq' => 'daily'],
    'restaurants.php' => ['priority' => '0.9', 'changefreq' => 'daily'],
    'login.php' => ['priority' => '0.7', 'changefreq' => 'monthly'],
    'registration.php' => ['priority' => '0.7', 'changefreq' => 'monthly'],
];

foreach ($pages as $page => $meta) {
    $sitemap .= '  <url>' . "\n";
    $sitemap .= '    <loc>' . APP_URL . '/' . $page . '</loc>' . "\n";
    $sitemap .= '    <changefreq>' . $meta['changefreq'] . '</changefreq>' . "\n";
    $sitemap .= '    <priority>' . $meta['priority'] . '</priority>' . "\n";
    $sitemap .= '  </url>' . "\n";
}

$sitemap .= '</urlset>';
file_put_contents(__DIR__ . '/../sitemap.xml', $sitemap);
echo "   ✓ Generated sitemap.xml\n";

// 5. Generate robots.txt
echo "\n5. Generating robots.txt...\n";
$robots = "User-agent: *\n";
$robots .= "Allow: /\n";
$robots .= "Disallow: /admin/\n";
$robots .= "Disallow: /api/\n";
$robots .= "Disallow: /config/\n";
$robots .= "Disallow: /core/\n";
$robots .= "Disallow: /models/\n";
$robots .= "Disallow: /cache/\n";
$robots .= "Disallow: /logs/\n";
$robots .= "\nSitemap: " . APP_URL . "/sitemap.xml\n";
file_put_contents(__DIR__ . '/../robots.txt', $robots);
echo "   ✓ Generated robots.txt\n";

// 6. Create .htaccess for security
echo "\n6. Generating security .htaccess...\n";
$htaccess = "# Security Headers\n";
$htaccess .= "<IfModule mod_headers.c>\n";
$htaccess .= "    Header set X-Content-Type-Options \"nosniff\"\n";
$htaccess .= "    Header set X-Frame-Options \"SAMEORIGIN\"\n";
$htaccess .= "    Header set X-XSS-Protection \"1; mode=block\"\n";
$htaccess .= "    Header set Referrer-Policy \"strict-origin-when-cross-origin\"\n";
$htaccess .= "</IfModule>\n\n";
$htaccess .= "# Disable Directory Browsing\n";
$htaccess .= "Options -Indexes\n\n";
$htaccess .= "# Protect sensitive files\n";
$htaccess .= "<FilesMatch \"^\\.(htaccess|htpasswd|ini|log|sh|sql)$\">\n";
$htaccess .= "    Order allow,deny\n";
$htaccess .= "    Deny from all\n";
$htaccess .= "</FilesMatch>\n";
file_put_contents(__DIR__ . '/../.htaccess', $htaccess);
echo "   ✓ Generated .htaccess\n";

// 7. Check file permissions
echo "\n7. Checking file permissions...\n";
$dirs = ['uploads', 'cache', 'logs', 'admin/Res_img'];
foreach ($dirs as $dir) {
    $path = __DIR__ . '/../' . $dir;
    if (is_dir($path)) {
        chmod($path, 0755);
        echo "   ✓ Set permissions for {$dir}\n";
    }
}

// 8. Generate manifest.json for PWA
echo "\n8. Generating PWA manifest...\n";
$manifest = [
    'name' => APP_NAME,
    'short_name' => 'Golden Era',
    'description' => 'Order delicious food online',
    'start_url' => '/',
    'display' => 'standalone',
    'background_color' => '#ffffff',
    'theme_color' => '#FF6B35',
    'icons' => [
        [
            'src' => '/images/icon-192.png',
            'sizes' => '192x192',
            'type' => 'image/png'
        ],
        [
            'src' => '/images/icon-512.png',
            'sizes' => '512x512',
            'type' => 'image/png'
        ]
    ]
];
file_put_contents(__DIR__ . '/../manifest.json', json_encode($manifest, JSON_PRETTY_PRINT));
echo "   ✓ Generated manifest.json\n";

echo "\n=== Optimization Complete! ===\n";
echo "\nProduction Checklist:\n";
echo "☐ Update config.php with production database credentials\n";
echo "☐ Set APP_ENV to 'production' in config.php\n";
echo "☐ Disable error display in php.ini\n";
echo "☐ Enable HTTPS\n";
echo "☐ Configure backup schedule\n";
echo "☐ Set up monitoring\n";
echo "☐ Test all functionality\n\n";
