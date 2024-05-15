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

define('BASEURL', 'http://localhost:8080');

// Database

define('DB_HOST', 'incrustwerush.org');
define('DB_USER', 'incrustwerush.org');
define('DB_PASS', 'incrustwerush.org');
define('DB_NAME', 'incrustwerush.org');

// Configuration

define('DEV_MODE', true); // true or false
define('USE_DB', false); // true or false

// ---

(DEV_MODE) ? (error_reporting(E_ALL) && ini_set("display_errors", 1)) : (error_reporting(0) && ini_set("display_errors", 0));
```
Use this for mysqli query :
####
You Must Active USE Database on Config
```php
define('USE_DB', true);
```
####
On Model Function Use
```php
$sql['query'] = "SELECT test FROM example";
$sql['result'] = $this->db->query($query);
```

---

## Documentation Status

The documentation for R-WFW is currently under development and will be available soon.

---

## License

R-WFW (Rusher Web FrameWork) uses the MIT license. See the `LICENSE` file for more information.
