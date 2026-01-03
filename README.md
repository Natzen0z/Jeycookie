# 🍪 Jeycookie

E-commerce platform built with Laravel 12 for selling cookies and baked goods.

## ✨ Features

- Product catalog with categories
- Shopping cart & checkout
- QRIS payment integration
- Order confirmation emails
- Admin dashboard for managing products, categories, and orders

## 🚀 Quick Start

### Prerequisites
- PHP 8.2+
- Composer
- Node.js 20+
- SQLite or MySQL

### Installation

```bash
# Clone the repository
git clone https://github.com/YOUR_USERNAME/Jeycookie.git
cd Jeycookie

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations and seed data
php artisan migrate --seed

# Build assets
npm run build

# Start the server
php artisan serve
```

### Development

```bash
# Run with hot reload (requires concurrently)
composer dev
```

### Running Tests

```bash
php artisan test
```

## 👥 Admin Access

After running seeders, you can login to admin with:
- **Email:** `admin@jeycookie.com`
- **Password:** `password`

## 📁 Project Structure

```
app/
├── Http/Controllers/
│   ├── Admin/          # Admin panel controllers
│   ├── CartController
│   ├── CheckoutController
│   └── ProductController
├── Models/             # Eloquent models
└── Mail/               # Email templates

database/
├── migrations/         # Database schema
└── seeders/           # Sample data
```

## 🔧 CI/CD

This project uses GitHub Actions for continuous integration:
- **Lint** - Code style check with Laravel Pint
- **Test** - PHPUnit tests on PHP 8.2 & 8.3
- **Build** - Asset compilation with Vite

## 📄 License

MIT License
