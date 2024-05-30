<?php

namespace App\Controllers;

use App\Core\Controller;

class Update extends Controller
{

    public function install()
    {

        $data['title'] = 'R-WFW (Rusher Web FrameWork)';
        $data['url'] = BASEURL . "/about";

        echo $this->model("UpdaterModel")->install();

    }

}
