<?php

namespace App\Core;

class Updater
{

    public function __construct()
    {

        $this->true = false;

    }

    private function recursiveCopy(string $source, string $destination): void
    {

        if (is_dir(filename: $source)) {

            if (!is_dir(filename: $destination)) {

                $not_update = "app\/models\/|app\/controllers|app\/views";
            
                if (!preg_match(pattern: "/$not_update/", subject: $destination)) {

                    mkdir(directory: $destination, permissions: 0777, recursive: true);

                }

            }

            $dir_contents = scandir(directory: $source);

            foreach ($dir_contents as $item) {

                if ($item == '.' || $item == '..') {

                    continue;

                }

                $source_path = $source . '/' . $item;
                $destination_path = $destination . '/' . $item;
                $this->recursiveCopy(source: $source_path, destination: $destination_path);

            }

        } else {

            $not_update = "config\/Config.php|app\/models\/|app\/controllers|app\/views\/|Database\/test.sql";
            
            if (!preg_match(pattern: "/$not_update/", subject: $destination)) {

                if (copy(from: $source, to: $destination)) {

                    $this->true = true;

                } else {
                    
                    $this->true = false;

                }

            }

        }

    }

    public function install(): string
    {

        $url = "https://github.com/ICWR-TEAM/R-WFW/archive/refs/heads/main.zip";

        $zip_path = __DIR__ . '/../../tmp/update.zip';
        $extract_path = __DIR__ . "/../../tmp/";
        $extracted = __DIR__ . "/../../tmp/R-WFW-main";
        $to = __DIR__ . "/../../";

        try {

            if (file_put_contents(filename: $zip_path, data: file_get_contents(filename: $url))) {

                if ($this->unzip(zip_path: $zip_path, extract_path: $extract_path)) {
    
                    $this->recursiveCopy(source: $extracted, destination: $to);
    
                    if ($this->true) {
    
                        return 'Installation completed successfully.';
    
                    } else {
    
                        return 'Failed to copy files.';
                        
                    }
    
                } else {
    
                    return 'Installation failed!';
    
                }
    
            } else {
    
                return 'Failed to download ZIP file.';
    
            }

        } catch (Exception $e) {

            echo "Error: " . $e->getMessage();

        }

    }

    private function unzip(string $zip_path, string $extract_path): bool
    {

        $zip = new \ZipArchive;

        if ($zip->open(filename: $zip_path) === true) {

            if ($zip->extractTo(pathto: $extract_path)) {

                $zip->close();
                return true;

            } else {

                $zip->close();
                return false;

            }

        } else {

            return false;

        }

    }

}
