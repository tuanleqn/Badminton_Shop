# Shop-badminton

A web-based e-commerce platform for badminton equipment and accessories.

## Environment Requirements

- Operating System: Windows, macOS or Linux
- Web Server: XAMPP (compatible with PHP 8.2)
- PHP Version: PHP 8.2
- Database: MySQL

## Installation Steps

### Step 1: Download and Install XAMPP

1. Download XAMPP from official website
2. Install XAMPP and ensure PHP version 8.2 is included
3. Start Apache and MySQL from XAMPP Control Panel

### Step 2: Get Source Code

1. Access project repository on GitHub: Shop Badminton
2. Download source code by clicking Code > Download ZIP or using command:
```
git clone https://github.com/tuanleqn/Badminton_Shop.git
```
3. Extract (if downloaded as ZIP) and move project folder to XAMPP's htdocs directory (typically C:\xampp\htdocs)

### Step 3: Setup Database

1. Open browser and go to:
```
http://localhost/phpmyadmin/
```
2. Create new database by clicking New and enter database name (e.g. shop_badminton)
3. Open SQL file provided in source code (located in sql folder)
4. In phpMyAdmin interface, select the newly created database, go to SQL tab
5. Copy SQL file contents and paste into SQL command box, click Go to execute

### Step 4: Configure Database Connection

1. Navigate to:
```
/AssignmentWeb/app/helper
```
2. Open config.php in text editor
3. Find MySQL connection settings and adjust password, username and hostname according to your MySQL configuration:
```php
$dbConfig = [
    'host' => 'localhost', 
    'username' => 'root',
    'password' => '', // Configure MySQL password here
    'database' => 'shop_badminton'
];
```
4. Save file after editing

### Step 5: Test Application

1. Access URL:
```
http://localhost/Shop-badminton/AssignmentWeb/public/home/index
```
2. Verify website displays correctly and functions properly

## Notes

- Ensure required PHP modules (like pdo_mysql, mysqli) are enabled in XAMPP's php.ini configuration
- If issues occur when loading application, verify paths and Apache/MySQL configuration

## Project Structure

```
├── AssignmentWeb/
│   ├── app/
│   │   ├── controllers/
│   │   ├── core/
│   │   ├── helper/
│   │   ├── models/
│   │   ├── views/
│   │   └── init.php
│   ├── asset/
│   │   ├── AJAX/
│   │   ├── css/  
│   │   └── js/
│   ├── assets/
│   │   ├── css/
│   │   ├── images/
│   │   └── js/
│   ├── public/
│   │   └── index.php
│   ├── uploads/
│   └── shopVNB.sql
└── frontend/
    └── user/
```

## Description

Shop-badminton is an e-commerce web application built with a PHP MVC architecture. It provides a platform for selling badminton equipment and accessories online.

## Features

- MVC Architecture
- User Authentication
- Product Management 
- Shopping Cart
- Order Processing
- Image Upload System
- Admin Dashboard
- Responsive Design

## Technology Stack

- PHP
- MySQL
- HTML/CSS
- JavaScript
- AJAX
- Bootstrap

## License

MIT License

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.
