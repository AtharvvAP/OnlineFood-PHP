# 🎨 Apply Peak Design to All Pages

## Quick Update Guide

I've created the peak design system. Here's how to apply it to all pages:

### Step 1: Update Main Pages

Run these commands in your terminal:

```bash
# Backup originals first
copy login.php login_old.php
copy registration.php registration_old.php  
copy restaurants.php restaurants_old.php
copy dishes.php dishes_old.php
copy your_orders.php your_orders_old.php
copy checkout.php checkout_old.php

# Apply new designs
copy login_modern.php login.php
copy registration_modern.php registration.php
copy restaurants_modern.php restaurants.php
copy dishes_modern.php dishes.php
copy your_orders_modern.php your_orders.php
copy checkout_modern.php checkout.php
```

### Step 2: Files I'm Creating

I'm creating modern versions of:

1. ✅ **index.php** - Already done!
2. ✅ **login.php** - Modern auth page
3. 🔄 **registration.php** - Modern signup
4. 🔄 **restaurants.php** - Menu listing
5. 🔄 **dishes.php** - Dish details
6. 🔄 **your_orders.php** - Order history
7. 🔄 **checkout.php** - Checkout page

### Step 3: What's Included

Each page will have:
- ✅ Modern navigation (from peak-design.css)
- ✅ Consistent styling
- ✅ Responsive design
- ✅ Professional layout
- ✅ Smooth animations

### Step 4: Manual Update (If Needed)

If automatic copy doesn't work, manually update each file:

1. Open the `*_modern.php` file
2. Copy all content
3. Paste into the original `.php` file
4. Save

### Files Created:

- `css/peak-design.css` - Main design system
- `index.php` - Homepage (✅ Done)
- `login_modern.php` - Login page (✅ Done)
- `registration_modern.php` - Coming next
- `restaurants_modern.php` - Coming next
- `dishes_modern.php` - Coming next
- `your_orders_modern.php` - Coming next
- `checkout_modern.php` - Coming next

### Testing:

After applying, test each page:
1. http://localhost/OnlineFood-PHP/
2. http://localhost/OnlineFood-PHP/login.php
3. http://localhost/OnlineFood-PHP/registration.php
4. http://localhost/OnlineFood-PHP/restaurants.php

All pages should have:
- Same navigation style
- Consistent colors
- Professional look
- Mobile responsive

---

**Note**: I'm creating all the modern versions now. You can apply them one by one or all at once!
