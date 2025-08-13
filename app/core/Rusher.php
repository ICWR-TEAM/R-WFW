<?php

namespace App\Core;

class Rusher
{
    private string $DB_HOST;
    private string $DB_USER;
    private string $DB_PASS;
    private string $DB_NAME;

    private string $path;
    private array $opt;

    public function __construct($path)
    {
        if (defined(constant_name: 'DB_USE') && DB_USE) {
            if (defined(constant_name: 'DEV_MODE') && DEV_MODE) {
                $this->DB_HOST = DEV_DB_HOST;
                $this->DB_USER = DEV_DB_USER;
                $this->DB_PASS = DEV_DB_PASS;
                $this->DB_NAME = DEV_DB_NAME;
            } else {
                $this->DB_HOST = DB_HOST;
                $this->DB_USER = DB_USER;
                $this->DB_PASS = DB_PASS;
                $this->DB_NAME = DB_NAME;
            }
        }

        $this->path = $path . '/app/';
        // $this->opt = getopt(short_options: "c:p:", long_options: ["component::", "path::", "page::", "help"]);
        $this->opt = getopt(short_options: "c:p:", long_options: ["component::", "path::", "page::", "backup", "migrate", "type::", "help"]);
    }

    public function displayHelp(): void
    {
        echo "Usage: php rusher [options]\n\n";
        echo "Options:\n";
        echo "  -c, --component     Specify a component (controller, model, view, route)\n";
        echo "  -p, --prefix        Specify a component prefix routes\n";
        echo "  --path              Specify a component path routes\n";
        echo "  --backup            Backup the database (structure, data, or both)\n";
        echo "  --migrate           Restore database from backups\n";
        echo "  --type=structure|data|both  Specify type of backup\n";
        echo "  --help              Display this help message\n";
    }

    public function execute(): void
    {
        if (isset($this->opt['help'])) {
            $this->displayHelp();
            return;
        }

        if (isset($this->opt['backup'])) {
            if (!defined(constant_name: 'DB_USE') || !DB_USE) die("Database Disabled!\n");
            $this->backupDatabase(type: $this->opt['type'] ?? 'both');
            return;
        }

        if (isset($this->opt['migrate'])) {
            if (!defined(constant_name: 'DB_USE') || !DB_USE) die("Database Disabled!\n");
            $this->migrateDatabase();
            return;
        }

        if (isset($this->opt['component']) || isset($this->opt['c'])) {
            $component = $this->opt['component'] ?? $this->opt['c'] ?? null;
            $this->createController(name: $component);
            $this->createModel(name: $component);
            $this->createView(name: $component);
            $this->addRoute(name: $component);
        } else {
            echo "No component specified. Use --help for usage information.\n";
        }
    }

    public function writeFile(string $filename, string $content, int $chmod = 0755): void
    {
        $dirPath = dirname(path: $filename);

        if (!is_dir(filename: $dirPath)) {
            mkdir(directory: $dirPath, permissions: 0777, recursive: true);
            echo "Directory created: $dirPath\n";
        }

        $file = fopen(filename: $filename, mode: "w");

        if ($file) {
            fwrite(stream: $file, data: $content);
            fclose(stream: $file);
            chmod(filename: $filename, permissions: $chmod);
            echo "File created: $filename\n";
        } else {
            echo "Error creating file: $filename\n";
        }
    }

    public function createController(string $name): bool
    {
        $path = $this->path . "controllers/" . $name . ".php";
        $parts = explode(separator: '/', string: $name);
        $className = end(array: $parts);

        $content = "<?php\n\n";
        $content .= "namespace App\Controllers;\n\n";
        $content .= "use App\Core\Controller;\n\n";
        $content .= "class " . $className . " extends Controller\n";
        $content .= "{\n\n";
        $content .= "    public function index(\$parameters): void\n";
        $content .= "    {\n";
        $content .= "        \$data['title'] = 'Print JSON Parameters'; \n";
        $content .= "        \$data['result'] = \$this->model(model: '" . $name . "Model')->index(\$parameters); \n";
        $content .= "        \$this->view(view: 'templates/header', data: \$data);\n";
        $content .= "        \$this->view(view: '" . $name . "', data: \$data);\n";
        $content .= "        \$this->view(view: 'templates/footer', data: \$data);\n";
        $content .= "    }\n";
        $content .= "}\n";

        $this->writeFile(filename: $path, content: $content);
        return true;
    }

    public function createModel(string $name): bool
    {
        $path = $this->path . "models/" . $name . "Model.php";
        $parts = explode(separator: '/', string: $name);
        $className = end(array: $parts);

        $content = "<?php\n\n";
        $content .= "namespace App\Models;\n\n";
        $content .= "use App\Core\Model;\n\n";
        $content .= "class " . $className . "Model extends Model\n";
        $content .= "{\n\n";
        $content .= "    public function __construct()\n";
        $content .= "    {\n";
        $content .= "        parent::__construct();\n";
        $content .= "    }\n\n";
        $content .= "    public function index(array \$parameters): string\n";
        $content .= "    {\n";
        $content .= "        \$output = json_encode(value: \$parameters);\n";
        $content .= "        return \$output;\n";
        $content .= "    }\n";
        $content .= "}\n";

        $this->writeFile(filename: $path, content: $content);
        return true;
    }

    public function createView(string $name): bool
    {
        $path = $this->path . "views/" . $name . ".php";
        $content = '';
        $content .= "<div class=\"container mt-5 p-5 shadow\" style=\"font-size: 15px;\">\n";
        $content .= "    <div>\n";
        $content .= "        <span style=\"font-weight: bold;\">Print JSON Parameters</span>\n";
        $content .= "        <hr class=\"mb-3\" />\n";
        $content .= "        <span>\n";
        $content .= "           Output:\n";
        $content .= "           <br />\n";
        $content .= "           <?=\$data['result']; ?>\n";
        $content .= "        </span>\n";
        $content .= "        <hr class=\"mb-3\" />\n";
        $content .= "    </div>\n";
        $content .= "</div>\n";

        $this->writeFile(filename: $path, content: $content);
        return true;
    }

    public function addRoute(string $name): bool
    {
        $component = $this->opt['component'] ?? $this->opt['c'] ?? null;
        $prefix = $this->opt['prefix'] ?? $this->opt['p'] ?? "/";
        $urlpath = $this->opt['path'] ?? "/";

        $path = $this->path . "config/Routes/" . $name . ".php";
        $content = "<?php\n\n";
        $content .= "\$route->Group(prefix: \"$prefix\", middlewares: [\n";
        $content .= "    [\n";
        $content .= "        'middleware' => 'Auth',\n";
        $content .= "        'constructParams' => [SECRET_KEY_JWT, SIGNATURE_PRIVATE_KEY, SIGNATURE_PUBLIC_KEY],\n";
        $content .= "        'function' => 'generateSignature',\n";
        $content .= "        'params' => [\"Hello World\"]\n";
        $content .= "    ]\n";
        $content .= "], callback: function() use (\$route): void {\n";
        $content .= "    \$route->Route(method: 'GET', url: '$urlpath', handler: \"$component::index\");\n";
        $content .= "    \$route->Route(method: 'GET', url: '$urlpath/closure', handler: function(\$request, \$response, \$parameters): mixed {\n";
        $content .= "        \$body = \$request->getBody();\n";
        $content .= "        return \$response->json([\n";
        $content .= "            'status' => true,\n";
        $content .= "            'parameters' => \$parameters,\n";
        $content .= "            'body' => \$body\n";
        $content .= "        ]);\n";
        $content .= "    });\n";
        $content .= "});\n";

        $this->writeFile(filename: $path, content: $content);
        return true;
    }

    private function getDbConnection(): mixed
    {
        if (!defined(constant_name: 'DB_USE') || !DB_USE) return false;
        return mysqli_connect(hostname: $this->DB_HOST, username: $this->DB_USER, password: $this->DB_PASS, database: $this->DB_NAME);
    }

    public function backupDatabase(string $type = 'both'): void
    {
        $conn = $this->getDbConnection();
        if (!$conn) {
            echo "Connection to database failed!\n";
            return;
        }

        $timestamp = date(format: 'Ymd_His');
        $backupDir = realpath(path: __DIR__ . '/../..') . "/data/backup/$timestamp";
        if (!is_dir(filename: $backupDir)) mkdir(directory: $backupDir, permissions: 0777, recursive: true);

        $filename = "$backupDir/{$type}_backup.sql";
        $sql = '';
        $tables = [];
        $res = mysqli_query(mysql: $conn, query: 'SHOW TABLES');
        while ($row = mysqli_fetch_array(result: $res)) $tables[] = $row[0];

        foreach ($tables as $table) {
            if ($type === 'structure' || $type === 'both') {
                $res = mysqli_query(mysql: $conn, query: "SHOW CREATE TABLE `$table`");
                $row = mysqli_fetch_assoc(result: $res);
                $sql .= "-- Table structure for `$table`\n" . $row['Create Table'] . ";\n\n";
            }

            if ($type === 'data' || $type === 'both') {
                $res = mysqli_query(mysql: $conn, query: "SELECT * FROM `$table`");
                if (mysqli_num_rows(result: $res) > 0) {
                    $fields = [];
                    $meta = mysqli_fetch_fields(result: $res);
                    foreach ($meta as $f) $fields[] = "`" . $f->name . "`";
                    $columns = implode(separator: ", ", array: $fields);

                    while ($row = mysqli_fetch_assoc(result: $res)) {
                        $values = [];
                        foreach ($row as $v) {
                            $values[] = is_null(value: $v) ? "NULL" : "'" . mysqli_real_escape_string(mysql: $conn, string: $v) . "'";
                        }
                        $sql .= "INSERT INTO `$table` ($columns) VALUES (" . implode(separator: ", ", array: $values) . ");\n";
                    }
                    $sql .= "\n";
                }
            }
        }

        file_put_contents(filename: $filename, data: $sql);
        mysqli_close(mysql: $conn);
        echo "Backup stored in: $filename\n";
    }

    public function migrateDatabase(): void
    {
        $backupRoot = realpath(path: __DIR__ . '/../..') . "/data/backup";
        if (!is_dir(filename: $backupRoot)) {
            echo "No backup directory found\n";
            return;
        }

        $dirs = array_filter(array: glob(pattern: "$backupRoot/*"), callback: fn($f): bool => is_dir(filename: $f));
        sort(array: $dirs);

        $conn = $this->getDbConnection();
        if (!$conn) {
            echo "Connection to database failed!\n";
            return;
        }

        mysqli_query(mysql: $conn, query: 'SET FOREIGN_KEY_CHECKS=0');

        foreach ($dirs as $dir) {
            $files = glob(pattern: "$dir/*.sql");
            sort(array: $files);
            foreach ($files as $file) {
                $sql = file_get_contents(filename: $file);
                $queries = array_filter(array: array_map(callback: 'trim', array: explode(separator: ';', string: $sql)));
                foreach ($queries as $query) {
                    if (preg_match(pattern: '/CREATE\s+TABLE\s+`?(\w+)`?/i', subject: $query, matches: $match)) {
                        $table = $match[1];
                        mysqli_query(mysql: $conn, query: "DROP TABLE IF EXISTS `$table`");
                    }
                    if ($query !== '') {
                        $exec = mysqli_query(mysql: $conn, query: $query);
                        if (!$exec) echo "Error in $file: " . mysqli_error(mysql: $conn) . "\n";
                    }
                }
                echo "Migrated from: $file\n";
            }
        }

        mysqli_query(mysql: $conn, query: 'SET FOREIGN_KEY_CHECKS=1');
        mysqli_close(mysql: $conn);
    }
}
