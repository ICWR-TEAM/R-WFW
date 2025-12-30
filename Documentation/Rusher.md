# **Rusher Documentation**

The `Rusher` class automates the creation of PHP components in an MVC-style application, with support for controllers, models, views, and routes, and customizable paths and route parameters.

---

### **Usage**

1. **Command-line options**:

   * `-c`, `--component`: Specify the component to generate (controller, model, view, route).
   * `-p`, `--prefix`: Set a prefix for the route (must start with `/`).
   * `--path`: Define the route path with placeholders (e.g., `/test/{param1}/second/{param2}`).
   * `--backup`: Trigger a database backup (structure, data, or both).
   * `--migrate`: Apply all `.sql` backups found in the backup directory.
   * `--type`: Specify backup type (`structure`, `data`, or `both`).
   * `--help`: Display the usage instructions.

2. **Example**:

   ```bash
   php rusher -c="TestComponent" -p="/api" --path="/test/{param1}/second/{param2}"
   ```

   Or

   ```bash
   php rusher -c="Test/TestComponent" -p="/api" --path="/test/{param1}/second/{param2}"
   ```

   This will generate:

   * `controllers/TestComponent.php`
   * `models/TestComponentModel.php`
   * `views/TestComponent.php`
   * `config/Routes/TestComponent.php` with the route `/api/test/{param1}/second/{param2}`

---

### **Directory Structure**

* `controllers/`: Stores controller files.
* `models/`: Stores model files.
* `views/`: Stores view files.
* `config/Routes/`: Stores route definition files.

---

### **Example Output**

Running the command to create a controller, model, view, and route will generate files in the respective directories, with feedback on the creation of directories and files.

---

### **Note on Prefix and Path**

* The `--prefix` option **must** start with `/`. For example: `-p "/api"` or `--prefix="/api"`.
* The `--path` option defines the route with placeholders. For example: `--path="/test/{param1}/second/{param2}"`.

---

### **Database Backup and Migration**

* Use `--backup` to export SQL dump files into `data/backup/{timestamp}/`
* Use `--migrate` to import all `.sql` files from the backup directory
* Use `--type` to control the scope: `structure`, `data`, or `both` (default)

**Backup examples**:

```bash
php rusher --backup --type=structure
php rusher --backup --type=data
php rusher --backup --type=both
```

**Migrate examples**:

```bash
php rusher --migrate
```

---

This class helps streamline the process of generating core components for a PHP web application, enabling easy customization of routes with dynamic parameters like `{param1}` and `{param2}`.
