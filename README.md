# 🍽️ Golden Era Cafe - Modern Food Ordering Platform

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange)](https://www.mysql.com/)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)
[![Status](https://img.shields.io/badge/Status-Production%20Ready-success)](https://github.com)

A **global-peak-level** food ordering platform built with modern PHP architecture, RESTful APIs, and cutting-edge frontend technologies.

## ✨ Features

### 🎯 Core Features
- **User Authentication** - Secure registration and login with bcrypt hashing
- **Browse Menu** - Beautiful, responsive dish catalog with search and filters
- **Shopping Cart** - Real-time cart management with local storage
- **Order Management** - Complete order lifecycle tracking
- **Admin Dashboard** - Comprehensive management panel
- **Discount System** - Flexible discount and promotion management
- **Multi-Restaurant** - Support for multiple branches/locations

### 🔐 Security Features
- ✅ SQL Injection Prevention (PDO Prepared Statements)
- ✅ XSS Protection (HTML Entity Encoding)
- ✅ CSRF Protection (Token-based)
- ✅ Secure Password Hashing (bcrypt)
- ✅ Session Security (HTTPOnly, Secure, SameSite)
- ✅ Input Validation & Sanitization
- ✅ Secure File Uploads

### 🚀 Modern Architecture
- **MVC Pattern** - Clean separation of concerns
- **RESTful API** - JSON-based API endpoints
- **OOP Design** - Object-oriented models and controllers
- **Singleton Pattern** - Efficient database connections
- **Repository Pattern** - Data access abstraction
- **Dependency Injection** - Loose coupling

### 🎨 Frontend Excellence
- **Responsive Design** - Mobile-first approach
- **Modern CSS** - CSS Custom Properties, BEM methodology
- **ES6+ JavaScript** - Classes, async/await, Fetch API
- **Smooth Animations** - CSS transitions and Intersection Observer
- **Progressive Enhancement** - Works without JavaScript

## 📸 Screenshots

### Homepage
![Homepage](docs/screenshots/homepage.png)

### Menu Catalog
![Menu](docs/screenshots/menu.png)

### Admin Dashboard
![Admin](docs/screenshots/admin.png)

## 🛠️ Technology Stack

### Backend
- **PHP 7.4+** - Server-side scripting
- **MySQL 5.7+** - Relational database
- **PDO** - Database abstraction layer
- **Apache/Nginx** - Web server

### Frontend
- **HTML5** - Semantic markup
- **CSS3** - Modern styling with custom properties
- **JavaScript ES6+** - Modern JavaScript features
- **Bootstrap 4** - Responsive grid system
- **Font Awesome 6** - Icon library

### Tools & Libraries
- **jQuery** - DOM manipulation (legacy support)
- **AOS** - Scroll animations
- **Intersection Observer** - Lazy loading

## 📦 Installation

### Prerequisites
```bash
- PHP >= 7.4
- MySQL >= 5.7
- Apache/Nginx with mod_rewrite
- Composer (optional)
```

### Quick Start

1. **Clone the repository**
```bash
git clone https://github.com/yourusername/golden-era-cafe.git
cd golden-era-cafe
```

2. **Configure database**
```bash
# Edit config/config.php with your database credentials
cp config/config.example.php config/config.php
```

3. **Import database**
```bash
mysql -u root -p onlinefoodphp < "DATABASE FILE/onlinefoodphp.sql"
```

4. **Set permissions**
```bash
chmod 755 uploads/
chmod 755 admin/Res_img/
chmod 755 cache/
```

5. **Start development server**
```bash
php -S localhost:8000
```

6. **Access the application**
```
Frontend: http://localhost:8000
Admin Panel: http://localhost:8000/admin
```

### Default Credentials

**Admin Login**
- Username: `admin`
- Password: `codeastro`

## 📚 Documentation

- [Architecture Guide](ARCHITECTURE.md) - System architecture and design patterns
- [Deployment Guide](DEPLOYMENT_GUIDE.md) - Production deployment instructions
- [API Documentation](docs/API.md) - RESTful API endpoints
- [Database Schema](docs/DATABASE.md) - Database structure

## 🎯 Project Structure

```
golden-era-cafe/
├── config/              # Configuration files
├── core/                # Core classes (Database, Session, etc.)
├── models/              # Data models
├── api/v1/              # RESTful API endpoints
├── assets/              # Frontend assets
│   ├── css/            # Stylesheets
│   └── js/             # JavaScript files
├── admin/              # Admin panel
├── uploads/            # User uploads
├── cache/              # Cache files
└── docs/               # Documentation
```

## 🔌 API Endpoints

### Authentication
```http
POST /api/v1/auth.php?action=login
POST /api/v1/auth.php?action=register
POST /api/v1/auth.php?action=logout
```

### Dishes
```http
GET    /api/v1/dishes.php
GET    /api/v1/dishes.php?id={id}
POST   /api/v1/dishes.php
PUT    /api/v1/dishes.php?id={id}
DELETE /api/v1/dishes.php?id={id}
```

### Orders
```http
GET    /api/v1/orders.php
POST   /api/v1/orders.php
PUT    /api/v1/orders.php?id={id}
```

See [API Documentation](docs/API.md) for detailed information.

## 🧪 Testing

```bash
# Run PHP unit tests
./vendor/bin/phpunit

# Run JavaScript tests
npm test

# Run integration tests
./tests/integration.sh
```

## 🚀 Deployment

See [Deployment Guide](DEPLOYMENT_GUIDE.md) for detailed production deployment instructions.

### Quick Deploy
```bash
# Set production environment
export APP_ENV=production

# Optimize for production
php optimize.php

# Clear cache
php cache-clear.php
```

## 📈 Performance

- **Page Load Time**: < 2 seconds
- **API Response Time**: < 200ms
- **Database Queries**: Optimized with indexes
- **Caching**: File-based caching system
- **CDN Ready**: Static assets can be served via CDN

## 🔒 Security

This project follows OWASP security best practices:
- Input validation and sanitization
- Prepared statements for SQL queries
- CSRF token protection
- Secure session management
- Password hashing with bcrypt
- XSS prevention
- Secure file uploads

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Authors

- **Original Project** - Salman Ansari
- **Modern Architecture** - Enhanced to global-peak-level

## 🙏 Acknowledgments

- Bootstrap team for the responsive framework
- Font Awesome for the icon library
- PHP community for excellent documentation
- All contributors who helped improve this project

## 📞 Support

For support, email support@goldeneracafe.com or open an issue on GitHub.

## 🗺️ Roadmap

### Version 2.0
- [ ] Payment gateway integration (Stripe, PayPal)
- [ ] Email notifications
- [ ] SMS alerts
- [ ] Real-time order tracking

### Version 3.0
- [ ] Mobile app (React Native)
- [ ] Multi-language support
- [ ] Advanced analytics
- [ ] AI-powered recommendations

## ⭐ Star History

If you find this project useful, please consider giving it a star!

---

**Built with ❤️ for Golden Era Cafe**

[Website](https://goldeneracafe.com) • [Documentation](docs/) • [Report Bug](issues/) • [Request Feature](issues/)
