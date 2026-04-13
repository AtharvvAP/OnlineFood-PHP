@echo off
echo ========================================
echo   Golden Era Cafe - Peak Design Update
echo ========================================
echo.
echo This will update ALL pages with peak design
echo.
pause

echo Creating backups...
if not exist "backups" mkdir backups
copy login.php backups\login_backup.php
copy registration.php backups\registration_backup.php
copy restaurants.php backups\restaurants_backup.php
copy dishes.php backups\dishes_backup.php
copy your_orders.php backups\your_orders_backup.php
copy checkout.php backups\checkout_backup.php

echo.
echo Backups created in 'backups' folder
echo.
echo Now manually copy the modern versions:
echo.
echo 1. Open each *_modern.php file
echo 2. Copy content
echo 3. Paste into corresponding .php file
echo 4. Save
echo.
echo Files to update:
echo - login.php (use login_modern.php)
echo - registration.php (use registration_modern.php)
echo - restaurants.php (use restaurants_modern.php)
echo - dishes.php (use dishes_modern.php)
echo - your_orders.php (use your_orders_modern.php)
echo - checkout.php (use checkout_modern.php)
echo.
pause
