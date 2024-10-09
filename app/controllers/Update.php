<?php

namespace App\Controllers;

use App\Core\Controller;

class Update extends Controller
{

    public function install()
    {

        $data['title'] = 'R-WFW (Rusher Web FrameWork)';
        $data['url'] = BASEURL . "/about";

        if (UPDATER) {

            if (UPDATER_PASSWD === $_GET['passwd']) {

                echo $this->model("UpdaterModel")->install();
            
            } else {

                echo "Password Incorrect!";

            }

        } else {

            echo "Sorry Updater OFF!";

        }

    }

}
