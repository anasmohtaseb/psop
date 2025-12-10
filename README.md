# Palestine Science Olympiad Portal

A national system to manage international science olympiad competitions (IMO, IOI, IOAI, ACPC Schools, Cyber Security Olympiad, IPO) for Palestinian students.

## Requirements

- PHP 8.0 or higher
- MySQL 5.7 or higher
- Apache with mod_rewrite enabled
- Composer

## Installation

1. Clone this repository to your XAMPP htdocs folder:
   ```bash
   cd c:\xampp\htdocs
   git clone <repository-url> psop
   ```

2. Install Composer dependencies:
   ```bash
   cd psop
   composer install
   ```

3. Create database and import schema:
   ```bash
   mysql -u root -p < database/schema.sql
   ```

4. Copy `.env.example` to `.env` and configure your database settings:
   ```bash
   copy .env.example .env
   ```

5. Edit `.env` file with your database credentials:
   ```
   DB_HOST=localhost
   DB_NAME=psop_db
   DB_USER=root
   DB_PASS=
   ```

6. Access the application:
   ```
   http://localhost/psop/public
   ```

## Default Login

- Email: `admin@psop.ps`
- Password: `admin123`

**Important:** Change the admin password immediately after first login.

## Project Structure

```
psop/
├── config/              # Configuration files
│   ├── config.php       # Main configuration
│   └── database.php     # Database connection
├── database/            # Database schemas
│   └── schema.sql       # Database structure
├── public/              # Public web root
│   ├── assets/          # CSS, JS, images
│   │   ├── css/
│   │   └── js/
│   ├── uploads/         # User uploads
│   └── index.php        # Front controller
├── src/                 # Application source code
│   ├── Core/            # Core framework classes
│   │   ├── Router.php
│   │   ├── Controller.php
│   │   ├── View.php
│   │   ├── Auth.php
│   │   └── Validator.php
│   ├── Controllers/     # Application controllers
│   └── Models/          # Data models
├── views/               # View templates
│   ├── layouts/         # Page layouts
│   ├── auth/            # Authentication views
│   ├── dashboard/       # Dashboard views
│   └── errors/          # Error pages
├── .env.example         # Environment template
├── .gitignore
├── composer.json
└── README.md
```

## Features

### User Types
- **Students**: Register for competitions, view training resources
- **School Coordinators**: Manage school students and registrations
- **Trainers**: Access training resources
- **Competition Managers**: Manage specific competitions
- **Administrators**: Full system access

### Core Functionality
- User registration and authentication with RBAC
- Competition and edition management
- Student registration for competitions (individual and team-based)
- Multi-stage registration workflow (draft → submitted → under_review → accepted)
- School management with coordinator linking
- Announcements system with targeted audiences
- Training resources management

### Security Features
- Password hashing with bcrypt
- CSRF token protection
- Prepared statements (SQL injection prevention)
- Session security (HttpOnly, Secure, SameSite)
- Role-based access control (RBAC)

## Development

### Adding New Routes

Edit `public/index.php`:
```php
$router->get('/path', 'ControllerName', 'methodName');
$router->post('/path', 'ControllerName', 'methodName');
```

### Creating Controllers

Controllers extend `App\Core\Controller` and are located in `src/Controllers/`:
```php
namespace App\Controllers;
use App\Core\Controller;

class MyController extends Controller {
    public function index(): void {
        $this->render('view/path', ['data' => $value]);
    }
}
```

### Creating Models

Models extend `App\Models\BaseModel` and are located in `src/Models/`:
```php
namespace App\Models;

class MyModel extends BaseModel {
    protected string $table = 'table_name';
}
```

### Creating Views

Views are PHP templates in `views/` directory using layouts from `views/layouts/`.

## Database

The database schema includes:
- Users and roles (RBAC)
- Schools and coordinators
- Student profiles
- Competitions and editions
- Competition tracks (age groups, difficulty levels)
- Teams and team members
- Registrations with status workflow
- Training resources
- Announcements and notifications

## License

This project is proprietary software for the Palestine Science Olympiad.

## Support

For support, contact the development team.
