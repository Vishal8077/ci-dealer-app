<<<<<<< HEAD
# ci-dealer-app
=======
# CodeIgniter 3 Dealer Management System

## Requirements
- XAMPP Version 3.3.3.0
- PHP 7.4+
- MySQL/MariaDB

## Setup Instructions for XAMPP

### Step 1: Copy Project to XAMPP
1. Copy the `ci-dealer-app` folder to `C:\xampp\htdocs\` (Windows) or `/opt/lampp/htdocs/` (Linux)
2. Final path should be: `C:\xampp\htdocs\ci-dealer-app\`

### Step 2: Start XAMPP
1. Open XAMPP Control Panel
2. Start **Apache** and **MySQL** services

### Step 3: Create Database
1. Open MySQL Workbench or phpMyAdmin (http://localhost/phpmyadmin)
2. Create new connection (if using Workbench):
   - **Hostname:** localhost
   - **Port:** 3306
   - **Username:** root
   - **Password:** (leave empty)
3. Execute this SQL:

```sql
CREATE DATABASE IF NOT EXISTS ci_dealer_db;
USE ci_dealer_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_type ENUM('employee', 'dealer') NOT NULL,
    city VARCHAR(100),
    state VARCHAR(100),
    zip_code VARCHAR(20),
    is_first_login TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Step 4: Configure Application
The application is pre-configured for XAMPP with:
- Base URL: `http://localhost/ci-dealer-app/`
- Database: `ci_dealer_db`
- Username: `root`
- Password: (empty)

If your MySQL has a password, update: `application/config/database.php`

### Step 5: Access Application
Open browser and go to: **http://localhost/ci-dealer-app/**

## Features Implemented

### ✅ All Requirements Met

1. **CodeIgniter 3** - Using CI 3.1.13
2. **XAMPP Compatible** - Configured for XAMPP 3.3.3.0
3. **Server-Side Pagination** - 10 records per page with AJAX
4. **AJAX** - All forms and data loading use AJAX

### Registration Module
- 5 fields: First Name, Last Name, Email, Password, User Type
- JavaScript validation
- Server-side validation in controller
- AJAX email uniqueness check
- Rejects incomplete emails (e.g., test@gmail)
- AJAX form submission
- Success/Fail alerts

### Login Module
- Email and Password authentication
- JavaScript and server-side validation
- AJAX form submission
- Session management

### Dealer First Login
- Prompts for City, State, Zip Code
- JavaScript and server-side validation
- AJAX form submission

### Employee Features
- View all dealers with server-side pagination
- Search/filter by Zip Code (AJAX)
- Edit dealer information
- 10 records per page

### Dealer Features
- Dashboard after profile completion
- Edit own profile

## Application URLs

- **Home/Register:** http://localhost/ci-dealer-app/
- **Login:** http://localhost/ci-dealer-app/auth/login
- **Employee Dealers:** http://localhost/ci-dealer-app/employee/dealers
- **Dealer Dashboard:** http://localhost/ci-dealer-app/dealer/dashboard

## Testing the Application

### Test as Employee:
1. Register with User Type: **Employee**
2. Login
3. View dealers list
4. Search by zip code
5. Edit dealer information

### Test as Dealer:
1. Register with User Type: **Dealer**
2. Login
3. Complete profile (City, State, Zip)
4. Access dashboard

## Technical Implementation

### Server-Side Pagination
- Implemented in `Employee` controller
- `get_dealers()` method handles pagination
- 10 records per page
- AJAX-based page navigation

### AJAX Features
- Email uniqueness check during registration
- Form submissions (register, login, profile update)
- Dealer list loading with pagination
- Search/filter functionality

### Validation
- **JavaScript:** Client-side validation on all forms
- **Server-side:** CodeIgniter form validation in controllers
- Email format validation (rejects incomplete emails)

### Security
- Password hashing using `password_hash()`
- Session-based authentication
- Form validation on both client and server
- SQL injection protection (Query Builder)

## Database Schema

```
users table:
- id (Primary Key, Auto Increment)
- first_name (VARCHAR 100)
- last_name (VARCHAR 100)
- email (VARCHAR 255, Unique)
- password (VARCHAR 255, Hashed)
- user_type (ENUM: employee, dealer)
- city (VARCHAR 100)
- state (VARCHAR 100)
- zip_code (VARCHAR 20)
- is_first_login (TINYINT, Default 1)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

## Troubleshooting

### Issue: Page not found
- Ensure Apache is running in XAMPP
- Check if `.htaccess` file exists in project root
- Enable `mod_rewrite` in Apache

### Issue: Database connection error
- Verify MySQL is running in XAMPP
- Check database credentials in `application/config/database.php`
- Ensure database `ci_dealer_db` exists

### Issue: Session errors
- Check if `application/cache/sessions/` folder exists
- Ensure folder has write permissions (777)

## Project Structure

```
ci-dealer-app/
├── application/
│   ├── controllers/
│   │   ├── Auth.php (Registration & Login)
│   │   ├── Dealer.php (Dealer operations)
│   │   └── Employee.php (Employee operations with pagination)
│   ├── models/
│   │   └── User_model.php (Database operations)
│   ├── views/
│   │   ├── register.php
│   │   ├── login.php
│   │   ├── dealer_profile.php
│   │   ├── dealer_dashboard.php
│   │   ├── employee_dealers.php (with server-side pagination)
│   │   └── edit_dealer.php
│   └── config/
│       ├── config.php (Base URL, Session)
│       ├── database.php (DB credentials)
│       └── autoload.php (Auto-load libraries)
├── .htaccess (URL rewriting)
└── database.sql (Database schema)
```

## Notes

- All forms use AJAX for submission
- Server-side pagination implemented with AJAX
- Email validation prevents incomplete emails
- Bootstrap 5 for responsive UI
- Clean URLs (no index.php in URL)
- Session-based authentication
- Password hashing for security
>>>>>>> c12d61b (Initial commit: CodeIgniter 3 Dealer Management System with AJAX and server-side pagination)
