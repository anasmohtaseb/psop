# Setup Instructions

## Prerequisites

Before you begin, ensure you have:
1. XAMPP installed with Apache and MySQL
2. PHP 8.0+ (included with XAMPP)
3. Composer installed globally (download from https://getcomposer.org/)

## Step-by-Step Setup

### 1. Install Composer (if not already installed)

Download and install Composer from: https://getcomposer.org/download/

Verify installation:
```powershell
composer --version
```

### 2. Install Dependencies

Open PowerShell in the project directory and run:
```powershell
composer install
```

This will:
- Install any required packages
- Generate the PSR-4 autoloader
- Create `.env` file from `.env.example` (automatically)

### 3. Configure Environment

Edit the `.env` file with your database settings:
```
DB_HOST=localhost
DB_PORT=3306
DB_NAME=psop_db
DB_USER=root
DB_PASS=
```

### 4. Create Database

Open phpMyAdmin or MySQL command line and run:
```sql
CREATE DATABASE psop_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Then import the schema:
```powershell
mysql -u root -p psop_db < database/schema.sql
```

Or via phpMyAdmin:
1. Select `psop_db` database
2. Go to "Import" tab
3. Choose `database/schema.sql`
4. Click "Go"

### 5. Configure Apache (Optional)

For cleaner URLs without `/public`, add this to your Apache `httpd-vhosts.conf`:

```apache
<VirtualHost *:80>
    ServerName psop.local
    DocumentRoot "C:/xampp/htdocs/psop/public"
    
    <Directory "C:/xampp/htdocs/psop/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Then add to `C:\Windows\System32\drivers\etc\hosts`:
```
127.0.0.1 psop.local
```

Restart Apache and access via: http://psop.local

### 6. Access the Application

Without VirtualHost:
```
http://localhost/psop/public
```

With VirtualHost:
```
http://psop.local
```

### 7. Default Login

- **Email**: admin@psop.ps
- **Password**: admin123

**Important**: Change the admin password immediately after first login!

## Troubleshooting

### Composer not found
- Ensure Composer is installed and in your PATH
- Try running `php composer.phar install` instead
- Restart PowerShell after installing Composer

### Database connection failed
- Check MySQL is running in XAMPP Control Panel
- Verify database credentials in `.env`
- Ensure database `psop_db` exists

### 404 errors
- Ensure Apache mod_rewrite is enabled
- Check `.htaccess` files exist in `public/` directory
- Verify Apache is configured to allow `.htaccess` (AllowOverride All)

### Permission errors
- Ensure `public/uploads/` directory is writable
- On Windows, right-click folder → Properties → Security → Edit permissions

### Page shows PHP code instead of executing
- Ensure PHP is properly configured in Apache
- Check file has `.php` extension
- Verify Apache is loading PHP module

## Development Mode

For development, set in `.env`:
```
APP_ENV=development
APP_DEBUG=true
```

This will show detailed error messages and stack traces.

**Never use debug mode in production!**

## File Structure Verification

After setup, your structure should look like:
```
psop/
├── .env (created from .env.example)
├── vendor/ (created by composer install)
│   └── autoload.php
├── config/
├── database/
├── public/
├── src/
└── views/
```

## Next Steps

1. Login with admin credentials
2. Change admin password
3. Create competition editions
4. Configure announcements
5. Test student registration flow
6. Add schools and coordinators

## Support

For issues:
1. Check error logs in Apache error.log
2. Enable debug mode to see detailed errors
3. Verify all setup steps completed
4. Check database connection and schema
