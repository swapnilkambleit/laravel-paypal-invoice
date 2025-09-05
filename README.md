# Laravel PayPal Invoice Service (Laravel 10 / PHP 8)

This project is a Laravel-based API-first application with **PayPal Invoice integration**.  
Follow the steps below to set up the project locally.

---

## 🚀 Installation & Setup

### 1) Install Dependencies
```bash
composer install
# or
composer update
```

### 2) Run Migrations
Make sure your database is configured in `.env`, then run:
```bash
php artisan migrate
```

### 3) Configure PayPal Credentials
Update your `.env` file with the correct PayPal mode and credentials:

```env
PAYPAL_MODE=sandbox   # or live
PAYPAL_CLIENT_ID=sandbox-id
PAYPAL_CLIENT_SECRET=sandbox-secret
```

### 4) Update Business Details
Edit the file:  
`app/Services/PayPalInvoiceService.php`

Update your business information:

```php
"business_name"   => "ABC Business",                 // Business Name
"email"           => "abc@xyz.com",                  // Business Email
"email_address"   => "abc-xyz@business.example.com", // PayPal Business Email
"website"         => "https://abc-dummy-xyz.com",    // Business Website
```

### 5) Start the Development Server
```bash
php artisan serve
```

Your application will be available at:  
👉 http://127.0.0.1:8000

---

## ✅ Notes
- Use **sandbox** mode for testing and switch to **live** for production.  
- Make sure your database is running before migrations.  
- Keep your PayPal client secret safe and **do not commit it** to Git.  

---

## 🔧 Useful Commands
```bash
# Run tests
php artisan test

# Clear config & cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
``` 
