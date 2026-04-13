/**
 * GOLDEN ERA CAFE - MODERN ENHANCEMENTS
 * Peak Level JavaScript Interactions
 */

// ============================================
// 1. SMOOTH SCROLL & NAVIGATION
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    
    // Smooth scroll for anchor links
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

    // Navbar scroll effect
    const navbar = document.querySelector('.modern-navbar');
    if (navbar) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }

});

// ============================================
// 2. ANIMATE ON SCROLL
// ============================================
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animated');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

document.querySelectorAll('.animate-on-scroll').forEach(el => {
    observer.observe(el);
});

// ============================================
// 3. TOAST NOTIFICATIONS
// ============================================
class ToastNotification {
    constructor() {
        this.container = this.createContainer();
    }

    createContainer() {
        let container = document.querySelector('.toast-container');
        if (!container) {
            container = document.createElement('div');
            container.className = 'toast-container';
            document.body.appendChild(container);
        }
        return container;
    }

    show(message, type = 'success', duration = 3000) {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        const icon = type === 'success' ? '✓' : '✕';
        toast.innerHTML = `
            <span style="font-size: 1.5rem;">${icon}</span>
            <span>${message}</span>
        `;

        this.container.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => toast.remove(), 300);
        }, duration);
    }
}

const toast = new ToastNotification();

// ============================================
// 4. MODERN MODAL
// ============================================
class ModernModal {
    constructor(modalId) {
        this.modal = document.getElementById(modalId);
        this.init();
    }

    init() {
        if (!this.modal) return;

        // Close on backdrop click
        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) {
                this.close();
            }
        });

        // Close on ESC key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal.classList.contains('active')) {
                this.close();
            }
        });
    }

    open() {
        this.modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    close() {
        this.modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// ============================================
// 5. SEARCH WITH AUTOCOMPLETE
// ============================================
class SearchAutocomplete {
    constructor(inputId, resultsId) {
        this.input = document.getElementById(inputId);
        this.results = document.getElementById(resultsId);
        this.debounceTimer = null;
        this.init();
    }

    init() {
        if (!this.input) return;

        this.input.addEventListener('input', (e) => {
            clearTimeout(this.debounceTimer);
            this.debounceTimer = setTimeout(() => {
                this.search(e.target.value);
            }, 300);
        });

        // Close results on outside click
        document.addEventListener('click', (e) => {
            if (!this.input.contains(e.target) && !this.results.contains(e.target)) {
                this.results.style.display = 'none';
            }
        });
    }

    async search(query) {
        if (query.length < 2) {
            this.results.style.display = 'none';
            return;
        }

        // Simulate API call - replace with actual AJAX call
        const mockResults = [
            { id: 1, name: 'Chicken Burger', price: 150 },
            { id: 2, name: 'Veg Pizza', price: 200 },
            { id: 3, name: 'Pasta', price: 180 }
        ].filter(item => item.name.toLowerCase().includes(query.toLowerCase()));

        this.displayResults(mockResults);
    }

    displayResults(results) {
        if (results.length === 0) {
            this.results.style.display = 'none';
            return;
        }

        this.results.innerHTML = results.map(item => `
            <div class="search-result-item" onclick="selectDish(${item.id})">
                <span>${item.name}</span>
                <span class="price">₹${item.price}</span>
            </div>
        `).join('');

        this.results.style.display = 'block';
    }
}

// ============================================
// 6. RATING SYSTEM
// ============================================
class RatingSystem {
    constructor(containerId) {
        this.container = document.getElementById(containerId);
        this.rating = 0;
        this.init();
    }

    init() {
        if (!this.container) return;

        const stars = this.container.querySelectorAll('.star');
        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                this.setRating(index + 1);
            });

            star.addEventListener('mouseenter', () => {
                this.highlightStars(index + 1);
            });
        });

        this.container.addEventListener('mouseleave', () => {
            this.highlightStars(this.rating);
        });
    }

    setRating(rating) {
        this.rating = rating;
        this.highlightStars(rating);
        // Trigger callback or save rating
        console.log('Rating set to:', rating);
    }

    highlightStars(count) {
        const stars = this.container.querySelectorAll('.star');
        stars.forEach((star, index) => {
            if (index < count) {
                star.classList.add('filled');
            } else {
                star.classList.remove('filled');
            }
        });
    }
}

// ============================================
// 7. CART MANAGEMENT (Enhanced)
// ============================================
class ModernCart {
    constructor() {
        this.items = this.loadCart();
        this.updateDisplay();
    }

    loadCart() {
        const saved = localStorage.getItem('cart');
        return saved ? JSON.parse(saved) : [];
    }

    saveCart() {
        localStorage.setItem('cart', JSON.stringify(this.items));
    }

    addItem(item) {
        const existing = this.items.find(i => i.id === item.id);
        if (existing) {
            existing.quantity += item.quantity;
        } else {
            this.items.push(item);
        }
        this.saveCart();
        this.updateDisplay();
        toast.show('Item added to cart!', 'success');
    }

    removeItem(itemId) {
        this.items = this.items.filter(i => i.id !== itemId);
        this.saveCart();
        this.updateDisplay();
        toast.show('Item removed from cart', 'success');
    }

    updateQuantity(itemId, quantity) {
        const item = this.items.find(i => i.id === itemId);
        if (item) {
            item.quantity = quantity;
            if (quantity <= 0) {
                this.removeItem(itemId);
            } else {
                this.saveCart();
                this.updateDisplay();
            }
        }
    }

    getTotal() {
        return this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    }

    getItemCount() {
        return this.items.reduce((sum, item) => sum + item.quantity, 0);
    }

    updateDisplay() {
        // Update cart badge
        const badge = document.querySelector('.cart-badge');
        if (badge) {
            badge.textContent = this.getItemCount();
            badge.style.display = this.getItemCount() > 0 ? 'block' : 'none';
        }

        // Update cart total
        const total = document.querySelector('.cart-total');
        if (total) {
            total.textContent = `₹${this.getTotal().toFixed(2)}`;
        }
    }

    clear() {
        this.items = [];
        this.saveCart();
        this.updateDisplay();
    }
}

// Initialize cart
const modernCart = new ModernCart();

// ============================================
// 8. IMAGE LAZY LOADING
// ============================================
const lazyImages = document.querySelectorAll('img[data-src]');
const imageObserver = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            img.classList.add('loaded');
            observer.unobserve(img);
        }
    });
});

lazyImages.forEach(img => imageObserver.observe(img));

// ============================================
// 9. FORM VALIDATION
// ============================================
class FormValidator {
    constructor(formId) {
        this.form = document.getElementById(formId);
        this.init();
    }

    init() {
        if (!this.form) return;

        this.form.addEventListener('submit', (e) => {
            if (!this.validate()) {
                e.preventDefault();
            }
        });

        // Real-time validation
        const inputs = this.form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                this.validateField(input);
            });
        });
    }

    validate() {
        let isValid = true;
        const inputs = this.form.querySelectorAll('[required]');
        
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isValid = false;
            }
        });

        return isValid;
    }

    validateField(field) {
        const value = field.value.trim();
        let isValid = true;
        let message = '';

        // Required check
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            message = 'This field is required';
        }

        // Email validation
        if (field.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                message = 'Please enter a valid email';
            }
        }

        // Phone validation
        if (field.type === 'tel' && value) {
            const phoneRegex = /^[0-9]{10}$/;
            if (!phoneRegex.test(value)) {
                isValid = false;
                message = 'Please enter a valid 10-digit phone number';
            }
        }

        // Password strength
        if (field.type === 'password' && value) {
            if (value.length < 6) {
                isValid = false;
                message = 'Password must be at least 6 characters';
            }
        }

        this.showFieldError(field, isValid, message);
        return isValid;
    }

    showFieldError(field, isValid, message) {
        const errorDiv = field.parentElement.querySelector('.error-message') || 
                        this.createErrorDiv(field);

        if (!isValid) {
            field.classList.add('error');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
        } else {
            field.classList.remove('error');
            errorDiv.style.display = 'none';
        }
    }

    createErrorDiv(field) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.style.color = '#dc3545';
        errorDiv.style.fontSize = '0.875rem';
        errorDiv.style.marginTop = '0.25rem';
        field.parentElement.appendChild(errorDiv);
        return errorDiv;
    }
}

// ============================================
// 10. COUNTDOWN TIMER (for offers)
// ============================================
class CountdownTimer {
    constructor(elementId, endDate) {
        this.element = document.getElementById(elementId);
        this.endDate = new Date(endDate).getTime();
        this.start();
    }

    start() {
        if (!this.element) return;

        const updateTimer = () => {
            const now = new Date().getTime();
            const distance = this.endDate - now;

            if (distance < 0) {
                this.element.innerHTML = 'EXPIRED';
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            this.element.innerHTML = `
                <div class="countdown-item">
                    <span class="countdown-value">${days}</span>
                    <span class="countdown-label">Days</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-value">${hours}</span>
                    <span class="countdown-label">Hours</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-value">${minutes}</span>
                    <span class="countdown-label">Minutes</span>
                </div>
                <div class="countdown-item">
                    <span class="countdown-value">${seconds}</span>
                    <span class="countdown-label">Seconds</span>
                </div>
            `;
        };

        updateTimer();
        setInterval(updateTimer, 1000);
    }
}

// ============================================
// 11. UTILITY FUNCTIONS
// ============================================

// Debounce function
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Format currency
function formatCurrency(amount) {
    return `₹${parseFloat(amount).toFixed(2)}`;
}

// Format date
function formatDate(date) {
    return new Date(date).toLocaleDateString('en-IN', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
}

// Copy to clipboard
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        toast.show('Copied to clipboard!', 'success');
    });
}

// ============================================
// 12. PERFORMANCE MONITORING
// ============================================
if ('performance' in window) {
    window.addEventListener('load', () => {
        const perfData = performance.timing;
        const pageLoadTime = perfData.loadEventEnd - perfData.navigationStart;
        console.log(`Page load time: ${pageLoadTime}ms`);
    });
}

// ============================================
// 13. EXPORT FOR GLOBAL USE
// ============================================
window.ModernEnhancements = {
    toast,
    ModernModal,
    SearchAutocomplete,
    RatingSystem,
    modernCart,
    FormValidator,
    CountdownTimer,
    debounce,
    formatCurrency,
    formatDate,
    copyToClipboard
};

console.log('🚀 Modern Enhancements Loaded Successfully!');
