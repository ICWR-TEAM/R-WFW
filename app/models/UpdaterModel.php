<?php

namespace App\Models;

use App\Core\Model;

class UpdaterModel extends Model
{

    public function install(): mixed
    {

        $output = $this->updater->install();

        return $output;
    }

}
