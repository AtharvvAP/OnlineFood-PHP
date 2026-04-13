# Golden Era Cafe - Online Food Ordering System
## User Manual

---

## Table of Contents
1. [Introduction](#introduction)
2. [System Requirements](#system-requirements)
3. [Installation Guide](#installation-guide)
4. [Customer Guide](#customer-guide)
5. [Admin Guide](#admin-guide)
6. [Discount Management](#discount-management)
7. [Troubleshooting](#troubleshooting)

---

## 1. Introduction

Golden Era Cafe Online Food Ordering System is a web-based application that allows customers to browse menu items, place orders, and make payments online. The system includes an admin panel for managing restaurants, menu items, orders, and users.

### Key Features:
- User registration and login
- Browse cafe menu and dishes
- Add items to cart with quantity selection
- Apply discounts on dishes
- Order placement with payment options (COD/PayPal)
- Order tracking
- Admin dashboard for complete management

---

## 2. System Requirements

### Server Requirements:
- PHP 5.6 or higher
- MySQL 5.6 or higher
- Apache/Nginx web server
- XAMPP/WAMP (for local development)

### Browser Requirements:
- Google Chrome (recommended)
- Mozilla Firefox
- Microsoft Edge
- Safari

---

## 3. Installation Guide

### Step 1: Setup Database
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Create a new database named `onlinefoodphp`
3. Import the SQL file:
   - Click on the database
   - Go to "Import" tab
   - Choose file: `DATABASE FILE/onlinefoodphp.sql`
   - Click "Go"
4. Run the discount column SQL:
   - Go to "SQL" tab
   - Run the query from `DATABASE FILE/add_discount_column.sql`

### Step 2: Configure Database Connection
1. Open `connection/connect.php`
2. Update database credentials:
   ```php
   $db = mysqli_connect('localhost', 'root', '', 'onlinefoodphp');
   ```

### Step 3: Start the Application
1. Place project folder in `htdocs` (XAMPP) or `www` (WAMP)
2. Start Apache and MySQL
3. Access the application:
   - Customer Site: `http://localhost/OnlineFood-PHP/`
   - Admin Panel: `http://localhost/OnlineFood-PHP/admin/`

### Default Admin Login:
- **Username:** admin
- **Password:** admin (MD5 encrypted)
- **Email:** admin@mail.com

---

## 4. Customer Guide

### 4.1 Registration

1. Click on **"Register"** in the navigation menu
2. Fill in the registration form:
   - Username
   - First Name
   - Last Name
   - Email
   - Phone Number
   - Password
   - Address
3. Click **"Register"** button
4. You will be redirected to login page

### 4.2 Login

1. Click on **"Login"** in the navigation menu
2. Enter your username and password
3. Click **"Login"** button
4. You will be redirected to the home page

### 4.3 Browsing Menu

#### Home Page:
- View **"Our Popular Dishes"** section
- See top 6 dishes with prices
- Discounted items show:
  - Original price (strikethrough)
  - Discounted price (green)
  - Discount badge (e.g., "20% OFF")

#### Cafe Menu Page:
1. Click **"Cafe Menu"** in navigation
2. View all available cafe branches
3. Click **"View Menu"** on any branch

### 4.4 Adding Items to Cart

1. Browse dishes on the menu page
2. For each dish, you can see:
   - Dish image
   - Name and description
   - Price (with discount if applicable)
   - Discount badge (if applicable)
3. Enter quantity (default is 1)
4. Click **"Add To Cart"** button
5. Item appears in the cart sidebar (left side)

### 4.5 Managing Cart

#### View Cart:
- Cart is visible on the left sidebar
- Shows all added items with:
  - Dish name
  - Price per item
  - Quantity
  - Discount badge (if applicable)

#### Remove Items:
- Click the trash icon (🗑️) next to any item

#### Update Quantity:
- Remove item and add again with new quantity

#### Cart Total:
- Shows subtotal of all items
- Displays "Free Delivery!"
- Total amount in ₹ (Rupees)

### 4.6 Checkout Process

1. Click **"Checkout"** button in cart
2. Review your order summary:
   - Cart Subtotal
   - Delivery Charges (Free)
   - Total Amount
3. Select payment method:
   - **Cash on Delivery (COD)** - Default
   - **PayPal** - Online payment
4. Click **"Order Now"** button
5. Confirm your order in the popup
6. Order is placed successfully

### 4.7 Viewing Orders

1. Click **"My Orders"** in navigation menu
2. View all your orders with:
   - Order items
   - Quantity
   - Price
   - Order date
   - Status (In Process/Closed/Rejected)
3. Delete cancelled orders using delete button

### 4.8 Logout

- Click **"Logout"** in navigation menu
- You will be logged out and redirected to home page

---

## 5. Admin Guide

### 5.1 Admin Login

1. Go to `http://localhost/OnlineFood-PHP/admin/`
2. Enter admin credentials:
   - Username: `admin`
   - Password: `admin`
3. Click **"Login"** button

### 5.2 Dashboard

After login, you'll see the admin dashboard with:
- Total number of users
- Total number of restaurants
- Total number of dishes
- Total orders
- Recent orders overview

### 5.3 User Management

#### View All Users:
1. Click **"Users"** in sidebar
2. View user list with:
   - Username
   - Name
   - Email
   - Phone
   - Address
   - Registration date

#### Update User:
1. Click edit icon (✏️) next to user
2. Modify user details
3. Click **"Update"** button

#### Delete User:
1. Click delete icon (🗑️) next to user
2. Confirm deletion
3. User is removed from system

### 5.4 Restaurant/Branch Management

#### View All Branches:
1. Click **"Golden Era"** → **"All Branches"** in sidebar
2. View all cafe branches with details

#### Add New Branch:
1. Click **"Golden Era"** → **"Add Branch"**
2. Fill in the form:
   - Branch Name
   - Email
   - Phone
   - Website URL
   - Opening Hours
   - Closing Hours
   - Open Days
   - Address
   - Upload Image
   - Select Category
3. Click **"Save"** button

#### Update Branch:
1. Go to **"All Branches"**
2. Click edit icon (✏️)
3. Modify details
4. Click **"Update"** button

#### Delete Branch:
1. Go to **"All Branches"**
2. Click delete icon (🗑️)
3. Confirm deletion

### 5.5 Category Management

#### Add Category:
1. Click **"Golden Era"** → **"Add Category"**
2. Enter category name (e.g., Continental, Italian, Chinese)
3. Click **"Save"** button

#### Update Category:
1. View categories list
2. Click edit icon
3. Modify category name
4. Click **"Update"** button

### 5.6 Menu Management

#### View All Menu Items:
1. Click **"Menu"** → **"All Menues"** in sidebar
2. View all dishes with:
   - Cafe/Branch name
   - Dish name
   - Description
   - Price
   - Discount percentage
   - Image

#### Add New Dish:
1. Click **"Menu"** → **"Add Menu"**
2. Fill in the form:
   - **Dish Name:** Enter dish name
   - **Description:** Enter dish description
   - **Price:** Enter price in ₹
   - **Discount (%):** Enter discount (0-100)
     - Example: Enter `20` for 20% off
     - Enter `0` for no discount
   - **Image:** Upload dish image (JPG/PNG/GIF, max 1MB)
   - **Select Branch:** Choose which branch serves this dish
3. Click **"Save"** button
4. Dish is added successfully

#### Update Dish:
1. Go to **"All Menues"**
2. Click edit icon (✏️) next to dish
3. Modify any field:
   - Dish name
   - Description
   - Price
   - Discount percentage
   - Image (optional - leave empty to keep existing)
   - Branch
4. Click **"Save"** button
5. Changes are saved

**Note:** You can update without uploading a new image. The existing image will be preserved.

#### Delete Dish:
1. Go to **"All Menues"**
2. Click delete icon (🗑️)
3. Confirm deletion

### 5.7 Order Management

#### View All Orders:
1. Click **"Orders"** in sidebar
2. View all orders with:
   - User name
   - Dish name
   - Quantity
   - Price
   - Order date
   - Status

#### Update Order Status:
1. Click on any order
2. Select new status:
   - **In Process** - Order is being prepared
   - **Closed** - Order completed
   - **Rejected** - Order cancelled
3. Add remark (optional)
4. Click **"Submit"** button

#### Delete Order:
1. Click delete icon (🗑️) next to order
2. Confirm deletion

### 5.8 Admin Logout

1. Click on profile icon (top right)
2. Click **"Logout"**
3. You will be logged out

---

## 6. Discount Management

### 6.1 How Discounts Work

- Discounts are percentage-based (0-100%)
- Applied automatically when customers add items to cart
- Displayed prominently on:
  - Home page (popular dishes)
  - Menu page (all dishes)
  - Shopping cart
  - Checkout page

### 6.2 Adding Discounts

#### When Adding New Dish:
1. Go to **Admin Panel** → **Menu** → **Add Menu**
2. Fill in dish details
3. In **"Discount (%)"** field:
   - Enter `0` for no discount
   - Enter `10` for 10% off
   - Enter `25.5` for 25.5% off
   - Maximum: 100%
4. Click **"Save"**

#### When Updating Existing Dish:
1. Go to **Admin Panel** → **Menu** → **All Menues**
2. Click edit icon (✏️) on the dish
3. Update **"Discount (%)"** field
4. Click **"Save"**
5. Discount is applied immediately

### 6.3 Discount Display

#### Customer View:

**Home Page:**
- Discount badge on top-right of dish image
- Original price shown with strikethrough
- Discounted price in green color
- Example: ~~₹140.00~~ **₹112.00** with "20% OFF" badge

**Menu Page:**
- Original price (strikethrough)
- Discounted price (green, bold)
- Discount badge next to price
- Example: ~~₹260~~ **₹208.00** 20% OFF

**Shopping Cart:**
- Discount badge on item name
- Final discounted price shown
- Total reflects all discounts

**Checkout:**
- All prices include discounts
- Final total with discounts applied

#### Admin View:
- Discount column in "All Menues" table
- Shows percentage (e.g., "20%")
- Easy to identify discounted items

### 6.4 Discount Calculation

**Formula:**
```
Discounted Price = Original Price - (Original Price × Discount / 100)
```

**Examples:**
- Original: ₹100, Discount: 20% → Final: ₹80
- Original: ₹260, Discount: 15% → Final: ₹221
- Original: ₹50, Discount: 0% → Final: ₹50

### 6.5 Removing Discounts

1. Go to **Admin Panel** → **Menu** → **All Menues**
2. Click edit icon on the dish
3. Set **"Discount (%)"** to `0`
4. Click **"Save"**
5. Regular price will be displayed

---

## 7. Troubleshooting

### Common Issues and Solutions

#### Issue 1: Cannot Login
**Solution:**
- Check username and password
- Ensure database is running
- Verify user exists in database
- Clear browser cache

#### Issue 2: Images Not Displaying
**Solution:**
- Check image path is correct
- Ensure images are uploaded to correct folder
- Verify file permissions
- Check image file format (JPG/PNG/GIF)

#### Issue 3: Discount Not Showing
**Solution:**
- Verify discount column exists in database
- Run `add_discount_column.sql` if not done
- Check discount value is greater than 0
- Clear browser cache and refresh

#### Issue 4: Cart Not Working
**Solution:**
- Ensure session is started
- Check PHP session settings
- Clear browser cookies
- Try different browser

#### Issue 5: Orders Not Saving
**Solution:**
- Check database connection
- Verify users_orders table exists
- Ensure user is logged in
- Check PHP error logs

#### Issue 6: Admin Profile Icon Not Visible
**Solution:**
- Verify `admin/images/bookingSystem/user-icn.png` exists
- Check file permissions
- Clear browser cache
- Refresh the page

#### Issue 7: Payment Option Not Selectable
**Solution:**
- Ensure radio button is not disabled
- Check browser console for errors
- Verify form is properly structured
- Try different browser

#### Issue 8: Database Connection Error
**Solution:**
- Check MySQL is running
- Verify database credentials in `connection/connect.php`
- Ensure database name is correct
- Check user has proper permissions

#### Issue 9: Upload Failed
**Solution:**
- Check file size (max 1MB for images)
- Verify file format (JPG/PNG/GIF)
- Check folder permissions (Res_img folder)
- Ensure upload_max_filesize in php.ini

#### Issue 10: Discount Calculation Wrong
**Solution:**
- Verify discount value is correct (0-100)
- Check database discount column type (DECIMAL)
- Clear cart and add items again
- Check for JavaScript errors

---

## 8. Best Practices

### For Customers:
1. Always logout after placing orders
2. Double-check cart before checkout
3. Keep order confirmation for reference
4. Contact cafe for order issues

### For Admins:
1. Regularly backup database
2. Keep menu items updated
3. Respond to orders promptly
4. Monitor discount effectiveness
5. Update branch information as needed
6. Review and manage user accounts
7. Keep images optimized (under 1MB)
8. Test discounts before applying

---

## 9. Support and Contact

### Technical Support:
- Check troubleshooting section first
- Review error logs in browser console
- Check PHP error logs
- Verify database structure

### System Information:
- **Project Name:** Golden Era Cafe Online Food Ordering System
- **Version:** 1.0 with Discount Feature
- **Technology:** PHP, MySQL, Bootstrap
- **Database:** onlinefoodphp

---

## 10. Appendix

### File Structure:
```
OnlineFood-PHP/
├── admin/                  # Admin panel files
│   ├── css/               # Admin stylesheets
│   ├── images/            # Admin images
│   ├── js/                # Admin scripts
│   ├── Res_img/           # Restaurant & dish images
│   ├── dashboard.php      # Admin dashboard
│   ├── all_menu.php       # Menu management
│   ├── add_menu.php       # Add new dish
│   ├── update_menu.php    # Update dish
│   └── ...
├── connection/            # Database connection
│   └── connect.php        # DB config
├── css/                   # Customer site styles
├── images/                # Customer site images
├── js/                    # Customer site scripts
├── DATABASE FILE/         # SQL files
│   ├── onlinefoodphp.sql # Main database
│   └── add_discount_column.sql # Discount feature
├── index.php              # Home page
├── login.php              # Customer login
├── registration.php       # Customer registration
├── restaurants.php        # Cafe listing
├── dishes.php             # Menu page
├── checkout.php           # Checkout page
├── your_orders.php        # Order history
└── USER_MANUAL.md         # This file
```

### Database Tables:
- **admin** - Admin users
- **users** - Customer accounts
- **restaurant** - Cafe branches
- **res_category** - Restaurant categories
- **dishes** - Menu items (with discount column)
- **users_orders** - Customer orders
- **remark** - Order status updates

### Important Notes:
1. Always backup database before making changes
2. Test discount feature in development first
3. Keep admin credentials secure
4. Regular maintenance recommended
5. Monitor disk space for images

---

**End of User Manual**

For additional help or feature requests, please refer to the troubleshooting section or contact your system administrator.
