# R-WFW (Rusher Web FrameWork)

R-WFW (Rusher Web FrameWork) is a backend framework designed to simplify web application development. It follows the Model-View-Controller (MVC) architecture, which separates the application logic, presentation, and data layers, facilitating the creation of clean and maintainable code. Additionally, R-WFW provides a powerful routing system, making it easy to define URL routes and map them to specific controller actions. It also includes a built-in template engine for managing application views, which enhances the separation of logic and presentation. Overall, R-WFW is a versatile framework that streamlines web application development, improving development speed and efficiency.

---

## Installation

1. Clone this repository to your local directory.
2. Create a new database on your MySQL server.
3. Open `Config.php`.
4. Edit the `Config.php` file.
5. The application is ready to use.

## Configuration

### `app/config/Config.php`

```php
<?php

namespace App\Config\Config;

define(constant_name: 'BASEURL', value: 'http://localhost:8080');

// Database

define(constant_name: 'DB_HOST', value: 'incrustwerush.org');
define(constant_name: 'DB_USER', value: 'incrustwerush.org');
define(constant_name: 'DB_PASS', value: 'incrustwerush.org');
define(constant_name: 'DB_NAME', value: 'incrustwerush.org');

// Configuration

define(constant_name: 'UPDATER', value: false); // true or false
define(constant_name: 'UPDATER_PASSWD', value: 'incrustwerush.org'); // Change Password for Update
define(constant_name: 'DEV_MODE', value: true); // true or false
define(constant_name: 'DB_USE', value: false); // true or false
define(constant_name: 'ALLOW_ALL_CORS', value: false); // true or false

// Security

define(constant_name: 'ALL_SECURITY_HEADERS', value: false); // true or false
define(constant_name: 'ANTI_XSS', value: false); // true or false

// JWT Secret Key

define(constant_name: 'SECRET_KEY_JWT', value: 'incrustwerush.org'); // Change JWT Secret Key

```

Use this for mysqli query :

You Must Active USE Database on Config

```php
define(constant_name: 'DB_USE', value: true);
```

On Model Function Use

```php
$sql['query'] = "SELECT test FROM example";
$sql['result'] = $this->db->query(query: $query);
```

---

## Documentation Status

The documentation for R-WFW is currently under development and will be available soon.

---

## License

R-WFW (Rusher Web FrameWork) uses the MIT license. See the `LICENSE` file for more information.
