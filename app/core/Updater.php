<?php

namespace App\Core;

class Updater
{

    private function install()
    {

        $url = "https://github.com/ICWR-TEAM/R-WFW/archive/refs/heads/main.zip";

        $zip_path = __DIR__ . '/main.zip';

        if (file_put_contents($zip_path, file_get_contents($url))) {

            $this->unzip($zip_path, __DIR__);
            return 'Installation completed successfully.';

        } else {

            return 'Failed to download ZIP file.';

        }

    }

    private function unzip($zip_path, $extract_path)
    {

        $zip = zip_open($zip_path);

        if ($zip) {

            if (!file_exists($extract_path)) {

                mkdir($extract_path, 0755, true);

            }
            
            while ($zip_entry = zip_read($zip)) {

                $entry_name = zip_entry_name($zip_entry);
                $entry_size = zip_entry_filesize($zip_entry);

                if (zip_entry_open($zip, $zip_entry, "r")) {

                    $file_content = zip_entry_read($zip_entry, $entry_size);
                    $extracted_file = $extract_path . '/' . basename($entry_name);
                    file_put_contents($extracted_file, $file_content);
                    zip_entry_close($zip_entry);

                }

            }

            zip_close($zip);
            return 'ZIP file extracted successfully.';

        } else {

            return 'Failed to open ZIP file.';

        }

    }

}

?>
