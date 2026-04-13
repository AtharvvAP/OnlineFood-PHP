/**
 * Modern JavaScript Application
 * ES6+ with async/await, fetch API, and modern patterns
 */

class App {
    constructor() {
        this.apiBase = '/api/v1';
        this.csrfToken = this.getCSRFToken();
        this.cart = this.loadCart();
        this.init();
    }
    
    init() {
        this.initEventListeners();
        this.initAnimations();
        this.updateCartUI();
    }
    
    initEventListeners() {
        // Add to cart buttons
        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', (e) => this.handleAddToCart(e));
        });
        
        // Cart actions
        document.querySelectorAll('.remove-from-cart').forEach(btn => {
            btn.addEventListener('click', (e) => this.handleRemoveFromCart(e));
        });
        
        // Checkout button
        const checkoutBtn = document.querySelector('#checkout-btn');
        if (checkoutBtn) {
            checkoutBtn.addEventListener('click', () => this.handleCheckout());
        }
        
        // Search functionality
        const searchInput = document.querySelector('#search-input');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => this.handleSearch(e.target.value));
        }
        
        // Filter functionality
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', (e) => this.handleFilter(e));
        });
    }
    
    initAnimations() {
        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });
    }
    
    async handleAddToCart(e) {
        e.preventDefault();
        const btn = e.currentTarget;
        const dishId = btn.dataset.dishId;
        
        try {
            const dish = await this.fetchDish(dishId);
            this.addToCart(dish);
            this.showNotification('Added to cart!', 'success');
            this.animateButton(btn);
        } catch (error) {
            this.showNotification('Failed to add to cart', 'error');
        }
    }
    
    handleRemoveFromCart(e) {
        const dishId = e.currentTarget.dataset.dishId;
        this.removeFromCart(dishId);
        this.showNotification('Removed from cart', 'info');
    }
    
    async handleCheckout() {
        if (this.cart.length === 0) {
            this.showNotification('Cart is empty', 'warning');
            return;
        }
        
        try {
            const response = await this.apiRequest('/orders.php', 'POST', {
                items: this.cart
            });
            
            if (response.success) {
                this.clearCart();
                this.showNotification('Order placed successfully!', 'success');
                setTimeout(() => {
                    window.location.href = '/your_orders.php';
                }, 1500);
            }
        } catch (error) {
            this.showNotification('Failed to place order', 'error');
        }
    }
    
    async handleSearch(query) {
        if (query.length < 2) return;
        
        try {
            const response = await this.apiRequest(`/dishes.php?search=${encodeURIComponent(query)}`);
            this.renderDishes(response.data);
        } catch (error) {
            console.error('Search failed:', error);
        }
    }
    
    async handleFilter(e) {
        const filterType = e.currentTarget.dataset.filter;
        const filterValue = e.currentTarget.dataset.value;
        
        try {
            const response = await this.apiRequest(`/dishes.php?${filterType}=${filterValue}`);
            this.renderDishes(response.data);
        } catch (error) {
            console.error('Filter failed:', error);
        }
    }
    
    async fetchDish(dishId) {
        const response = await this.apiRequest(`/dishes.php?id=${dishId}`);
        return response.data;
    }
    
    async apiRequest(endpoint, method = 'GET', data = null) {
        const options = {
            method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': this.csrfToken
            }
        };
        
        if (data) {
            options.body = JSON.stringify(data);
        }
        
        const response = await fetch(this.apiBase + endpoint, options);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return await response.json();
    }
    
    addToCart(dish) {
        const existingItem = this.cart.find(item => item.d_id === dish.d_id);
        
        if (existingItem) {
            existingItem.quantity++;
        } else {
            this.cart.push({
                d_id: dish.d_id,
                title: dish.title,
                price: dish.discounted_price || dish.price,
                quantity: 1,
                img: dish.img
            });
        }
        
        this.saveCart();
        this.updateCartUI();
    }
    
    removeFromCart(dishId) {
        this.cart = this.cart.filter(item => item.d_id != dishId);
        this.saveCart();
        this.updateCartUI();
    }
    
    clearCart() {
        this.cart = [];
        this.saveCart();
        this.updateCartUI();
    }
    
    updateCartUI() {
        const cartCount = document.querySelector('.cart-count');
        const cartTotal = document.querySelector('.cart-total');
        
        if (cartCount) {
            const totalItems = this.cart.reduce((sum, item) => sum + item.quantity, 0);
            cartCount.textContent = totalItems;
            cartCount.style.display = totalItems > 0 ? 'inline-block' : 'none';
        }
        
        if (cartTotal) {
            const total = this.cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            cartTotal.textContent = `₹${total.toFixed(2)}`;
        }
    }
    
    loadCart() {
        const cartData = localStorage.getItem('cart');
        return cartData ? JSON.parse(cartData) : [];
    }
    
    saveCart() {
        localStorage.setItem('cart', JSON.stringify(this.cart));
    }
    
    getCSRFToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta ? meta.getAttribute('content') : '';
    }
    
    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
    
    animateButton(btn) {
        btn.classList.add('btn-animate');
        setTimeout(() => btn.classList.remove('btn-animate'), 600);
    }
    
    renderDishes(dishes) {
        const container = document.querySelector('#dishes-container');
        if (!container) return;
        
        container.innerHTML = dishes.map(dish => this.createDishCard(dish)).join('');
        this.initEventListeners();
    }
    
    createDishCard(dish) {
        const discountBadge = dish.discount > 0 
            ? `<div class="discount-badge-modern">${dish.discount}% OFF</div>` 
            : '';
        
        const priceHTML = dish.discount > 0
            ? `<div>
                <span class="price-original-modern">₹${dish.price}</span>
                <span class="price-current-modern">₹${dish.discounted_price}</span>
               </div>`
            : `<span class="price-current-modern">₹${dish.price}</span>`;
        
        return `
            <div class="col-md-4 mb-4 animate-on-scroll">
                <div class="dish-card-modern">
                    <div class="dish-image-modern">
                        ${discountBadge}
                        <img src="admin/Res_img/dishes/${dish.img}" alt="${dish.title}">
                    </div>
                    <div class="dish-content-modern">
                        <h3 class="dish-title-modern">${dish.title}</h3>
                        <p class="dish-description-modern">${dish.slogan || ''}</p>
                        <div class="price-wrapper-modern">
                            ${priceHTML}
                            <button class="order-btn-modern add-to-cart" data-dish-id="${dish.d_id}">
                                <i class="fas fa-shopping-cart"></i> Add
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
}

// Initialize app when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => new App());
} else {
    new App();
}
