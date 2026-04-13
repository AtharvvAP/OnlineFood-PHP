<!-- Sidebar -->
<aside class="admin-sidebar">
    <div class="admin-sidebar-logo">
        <div class="admin-sidebar-logo-icon">
            <span>AP</span>
        </div>
        <span class="admin-sidebar-logo-text">Admin Panel</span>
    </div>
    
    <ul class="admin-sidebar-menu">
        <li class="admin-menu-label">Main</li>
        <li class="admin-menu-item">
            <a href="dashboard.php" class="admin-menu-link <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        
        <li class="admin-menu-label">Management</li>
        <li class="admin-menu-item">
            <a href="all_users.php" class="admin-menu-link <?php echo basename($_SERVER['PHP_SELF']) == 'all_users.php' ? 'active' : ''; ?>">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a>
        </li>
        <li class="admin-menu-item">
            <a href="all_restaurant.php" class="admin-menu-link <?php echo basename($_SERVER['PHP_SELF']) == 'all_restaurant.php' ? 'active' : ''; ?>">
                <i class="fas fa-store"></i>
                <span>Restaurants</span>
            </a>
        </li>
        <li class="admin-menu-item">
            <a href="add_category.php" class="admin-menu-link <?php echo basename($_SERVER['PHP_SELF']) == 'add_category.php' ? 'active' : ''; ?>">
                <i class="fas fa-tags"></i>
                <span>Add Category</span>
            </a>
        </li>
        <li class="admin-menu-item">
            <a href="add_restaurant.php" class="admin-menu-link <?php echo basename($_SERVER['PHP_SELF']) == 'add_restaurant.php' ? 'active' : ''; ?>">
                <i class="fas fa-plus-circle"></i>
                <span>Add Restaurant</span>
            </a>
        </li>
        
        <li class="admin-menu-label">Menu</li>
        <li class="admin-menu-item">
            <a href="all_menu.php" class="admin-menu-link <?php echo basename($_SERVER['PHP_SELF']) == 'all_menu.php' ? 'active' : ''; ?>">
                <i class="fas fa-utensils"></i>
                <span>All Menu Items</span>
            </a>
        </li>
        <li class="admin-menu-item">
            <a href="add_menu.php" class="admin-menu-link <?php echo basename($_SERVER['PHP_SELF']) == 'add_menu.php' ? 'active' : ''; ?>">
                <i class="fas fa-plus"></i>
                <span>Add Menu Item</span>
            </a>
        </li>
        
        <li class="admin-menu-label">Orders</li>
        <li class="admin-menu-item">
            <a href="all_orders.php" class="admin-menu-link <?php echo basename($_SERVER['PHP_SELF']) == 'all_orders.php' ? 'active' : ''; ?>">
                <i class="fas fa-shopping-cart"></i>
                <span>All Orders</span>
            </a>
        </li>
    </ul>
</aside>

<!-- Header -->
<header class="admin-header">
    <h1 class="admin-header-title"><?php echo isset($page_title) ? $page_title : 'Admin Panel'; ?></h1>
    <div class="admin-header-user">
        <div class="admin-header-avatar">
            <i class="fas fa-user"></i>
        </div>
        <a href="logout.php" style="text-decoration: none; color: #4A5568; font-weight: 500;">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</header>
