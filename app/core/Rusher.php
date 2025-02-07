<?php

namespace App\Core;

class Rusher
{
    private string $path;
    private array $opt;

    public function __construct($path)
    {
        $this->path = $path . '/app/';
        $this->opt = getopt(short_options: "c:p:", long_options: ["component::", "path::", "page::", "help"]);
    }

    public function displayHelp(): void
    {
        echo "Usage: php rusher [options]\n\n";
        echo "Options:\n";
        echo "  -c, --component   Specify a component (controller, model, view, route)\n";
        echo "  -p, --prefix   Specify a component prefix routes\n";
        echo "  --path   Specify a component path routes\n";
        echo "  --help            Display this help message\n";
    }

    public function execute(): void
    {
        if (isset($this->opt['help'])) {
            $this->displayHelp();
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
        $content .= "    \$route->Route(method: 'get', url: '$urlpath', handler: \"$component::index\");\n";
        $content .= "});\n";

        $this->writeFile(filename: $path, content: $content);
        return true;
    }
}
