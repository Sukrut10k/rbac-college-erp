# RBAC (Role-Based Access Control) System

A comprehensive PHP-based Role-Based Access Control system with multi-tier user management, approval workflows, and secure authentication mechanisms.

## Project Overview

This RBAC system implements a sophisticated access control mechanism with three distinct user roles: **Students**, **Faculty**, and **Administrators**. The system features an approval-based registration process, secure authentication, and role-specific dashboards with tailored functionality for each user type.

### Key Highlights
- **Multi-Role Authentication**: Separate login flows for Students, Faculty, and Administrators
- **Approval Workflow**: Admin-controlled user registration approval system
- **Secure Admin Registration**: Special authorization codes required for admin account creation
- **Faculty Management**: Dedicated faculty portal with course and student management features
- **Responsive Design**: Modern, mobile-friendly interface with gradient styling

##  Project Structure

```
rbac-system/
├── 📁 css/
│   └── style.css                 # Custom styling and responsive design
├── 📄 admin_page.php            # Administrator dashboard
├── 📄 faculty_member_page.php   # Faculty portal and management
├── 📄 login_form.php            # Universal login interface
├── 📄 logout.php                # Session management and logout
├── 📄 register_form.php         # User registration with role selection
├── 📄 user_page.php             # Student dashboard
├── 📄 config.php                # Database configuration (not included)
├── 📄 user_db.sql               # Database schema and sample data
└── 📄 README.md                 # Project documentation
├── 📁 cybersecurity_attack_guides/
│   └── phishing attack guide               

```

##  Key Features

###  Authentication & Authorization
- **Secure Login System**: MD5 password hashing with SQL injection protection
- **Role-Based Redirection**: Automatic routing based on user roles
- **Session Management**: Secure PHP session handling
- **Admin Code Verification**: Special authorization codes for admin registration

###  User Management
- **Multi-Tier Registration**: Students, Faculty, and Administrator registration
- **Approval Workflow**: Admin approval required for student registrations
- **Status Tracking**: Pending, Approved, and Rejected user statuses
- **Faculty Addition**: Admin-controlled faculty member creation

###  Dashboard Features
- **Admin Dashboard**: User approval, statistics, faculty management, admin code generation
- **Faculty Portal**: Course management, student tracking, schedule overview
- **Student Interface**: Academic resources, announcements, profile management

###  Security Features
- **SQL Injection Protection**: Parameterized queries and input sanitization
- **Access Control**: Role-based page access restrictions
- **Session Security**: Proper session initialization and destruction
- **Admin Code System**: Secure administrator account creation

##  Technologies Used

- **Backend**: PHP 7.4+
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript
- **Server**: Apache (XAMPP)
- **Styling**: Custom CSS with gradient designs and responsive layouts

##  Installation Guide

### Prerequisites
- XAMPP (Apache + MySQL + PHP)
- Web browser
- Text editor:- VS Code

### Step 1: Download and Install XAMPP
1. Download XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Install XAMPP with default settings
3. Launch XAMPP Control Panel

### Step 2: Configure XAMPP Ports (Optional)
If you need to use port 8080 instead of default port 80:
1. Click **Config** next to Apache in XAMPP
2. Select **httpd.conf**
3. Find `Listen 80` and change to `Listen 8080`
4. Find `ServerName localhost:80` and change to `ServerName localhost:8080`
5. Save and restart Apache

### Step 3: Start Services
1. **Start Apache**: Click **Start** next to Apache
2. **Start MySQL**: Click **Start** next to MySQL

> **⚠️ MySQL Troubleshooting**: If MySQL fails to start:
> 1. Open Windows Services (`services.msc`)
> 2. Find and stop **MySQL80** service
> 3. Return to XAMPP and start MySQL

### Step 4: Project Setup
1. **Clone Repository**:
   ```bash
   git clone https://github.com/your-username/rbac-system.git
   ```

2. **Copy Project Files**:
   - Navigate to `XAMPP/htdocs/`
   - Create folder named `crud`
   - Copy all project files to `XAMPP/htdocs/crud/`

3. **Create Database Configuration**:
   Create `config.php` in the project root:
   ```php
   <?php
   $conn = mysqli_connect('localhost', 'root', '', 'user_db');
   
   if(!$conn){
       die('Connection failed: ' . mysqli_connect_error());
   }
   ?>
   ```

### Step 5: Database Setup
1. **Access phpMyAdmin**: 
   - Visit: `http://localhost:8080/phpmyadmin/` (or `http://localhost/phpmyadmin/` for default port)
   
2. **Import Database**:
   - Click **Import** tab
   - Choose `user_db.sql` file
   - Click **Go** to import

3. **Verify Tables**:
   Ensure these tables are created:
   - `user_form` - User accounts and roles
   - `admin_codes` - Administrator authorization codes
   - `faculty_table` - Faculty member credentials

##  Usage Guide

###  Accessing the System
- **Main Application**: `http://localhost:8080/crud/`
- **Direct Login**: `http://localhost:8080/crud/login_form.php`
- **Registration**: `http://localhost:8080/crud/register_form.php`

###  User Registration Process

#### Student Registration
1. Visit registration page
2. Fill in personal details
3. Select **Student** role
4. Submit registration
5. **Wait for admin approval** before logging in

#### Faculty Registration
Faculty accounts are created by administrators through the admin dashboard.

#### Administrator Registration
1. Visit registration page
2. Fill in personal details
3. Select **Administrator** role
4. **Enter valid admin authorization code**
5. Submit registration (auto-approved)

###  Default Login Credentials

Based on the sample data in `user_db.sql`:

#### Administrator
- **Email**: `k.sukrut1010@gmail.com`
- **Password**: `Encrypted` (MD5: 81dc9bdb52d04dc20036dbd8313ed055)

#### Student
- **Email**: `sukrut12345@gmail.com`
- **Password**: `Encrypted` (MD5: 25d55ad283aa400af464c76d713c07ad)

#### Faculty
- **Email**: `faculty1@gmail.com`
- **Password**: `Encrypted` (MD5: 81dc9bdb52d04dc20036dbd8313ed055)

##  System Workflows

### Admin Workflow
1. **Login** → Admin Dashboard
2. **Review Pending Users** → Approve/Reject registrations
3. **Generate Admin Codes** → Create authorization codes
4. **Add Faculty** → Create faculty accounts
5. **Monitor Statistics** → View system metrics

### Faculty Workflow
1. **Login** → Faculty Portal
2. **Course Management** → View and manage courses
3. **Student Tracking** → Monitor student progress
4. **Schedule Management** → View daily schedule

### Student Workflow
1. **Register** → Submit registration form
2. **Wait for Approval** → Admin reviews application
3. **Login** → Access student dashboard
4. **Access Resources** → Use academic tools

##  Configuration Options

### Database Configuration
Modify `config.php` for different database settings:
```php
$conn = mysqli_connect('hostname', 'username', 'password', 'database_name');
```

### Security Settings
- **Password Hashing**: Currently uses MD5 
- **Session Timeout**: Configure in PHP settings
- **SQL Injection Protection**: Built-in with `mysqli_real_escape_string()`

##  Security Considerations

### Current Security Measures
- ✅ SQL injection protection via input sanitization
- ✅ Session-based authentication
- ✅ Role-based access control
- ✅ Admin authorization codes

## Troubleshooting

### Common Issues

#### Apache Won't Start
- **Port Conflict**: Change Apache port in XAMPP config
- **Skype Conflict**: Disable Skype's port 80/443 usage

#### MySQL Won't Start
- **Service Conflict**: Stop MySQL80 service in Windows Services
- **Port Conflict**: Change MySQL port in XAMPP config

#### Database Connection Failed
- **Check Config**: Verify `config.php` database credentials
- **MySQL Status**: Ensure MySQL service is running
- **Database Exists**: Confirm `user_db` database is created

#### Login Issues
- **Account Status**: Check if user account is approved
- **Password**: Verify password matches database hash
- **Role Access**: Ensure accessing correct dashboard for user role

## 🤝 Contributing

We welcome contributions to improve the RBAC system! Please follow these guidelines:

### How to Contribute
1. **Fork** the repository
2. **Create** a feature branch (`git checkout -b feature/NewFeature`)
3. **Commit** your changes (`git commit -m 'Add some NewFeature'`)
4. **Push** to the branch (`git push origin feature/NewFeature`)
5. **Open** a Pull Request


##  Author

**Sukrut Kulkarni**
- Email: k.sukrut1010@gmail.com

## Support

If you encounter any issues or have questions:

1. **Check Troubleshooting Section** above
2. **Review Database Setup** in Installation Guide
3. **Open an Issue** on GitHub
4. **Contact**: k.sukrut1010@gmail.com

---

**⭐ Star this repository if you find it helpful!**