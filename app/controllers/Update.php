<?php

namespace App\Controllers;

use App\Core\Controller;

class Update extends Controller
{

    public function list()
    {

        $data['title'] = 'R-WFW (Rusher Web FrameWork)';
        $data['url'] = BASEURL . "/about";

        echo $this->model("UpdaterModel")->getListFile();

    }

}
