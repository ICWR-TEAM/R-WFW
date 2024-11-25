<?php

namespace App\Models;

use App\Core\Model;

class CorsModel extends Model
{
    public $header;

    public function Test(): void
    {
        $this->header->cors(['OPTIONS', 'GET'], ['https://example.com', 'https://another-domain.com'], ['*']);
    }
}
