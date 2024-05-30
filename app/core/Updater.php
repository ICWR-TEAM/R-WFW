<?php

namespace App\Core;

class Updater
{

    public function __construct()
    {

        $this->true = false;

    }

    private function recursiveCopy($source, $destination)
    {

        if (is_dir($source)) {

            if (!is_dir($destination)) {

                mkdir($destination, 0777, true);

            }

            $dir_contents = scandir($source);

            foreach ($dir_contents as $item) {

                if ($item == '.' || $item == '..') {

                    continue;

                }

                $source_path = $source . '/' . $item;
                $destination_path = $destination . '/' . $item;
                $this->recursiveCopy($source_path, $destination_path);

            }

        } else {

            $not_update = "config\/Config.php|app\/models\/|app\/controllers|app\/views/|Database\/test.sql";
            
            if (!preg_match("/$not_update/", $destination)) {

                if (copy($source, $destination)) {

                    $this->true = true;

                } else {
                    
                    $this->true = false;

                }

            }

        }

    }

    public function install()
    {

        $url = "https://github.com/ICWR-TEAM/R-WFW/archive/refs/heads/main.zip";

        $zip_path = __DIR__ . '/../../tmp/update.zip';
        $extract_path = __DIR__ . "/../../tmp/";
        $extracted = __DIR__ . "/../../tmp/R-WFW-main";
        $to = __DIR__ . "/../../";

        try {

            if (file_put_contents($zip_path, file_get_contents($url))) {

                if ($this->unzip($zip_path, $extract_path)) {
    
                    $this->recursiveCopy($extracted, $to);
    
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

    private function unzip($zip_path, $extract_path)
    {

        $zip = new \ZipArchive;

        if ($zip->open($zip_path) === true) {

            if ($zip->extractTo($extract_path)) {

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
