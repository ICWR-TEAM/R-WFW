<?php

namespace App\Models;

use App\Core\Model;

class UpdaterModel extends Model
{

    public function getListFile()
    {

        $output = $this->updater->getList();

        return $output;
    }

}
