<?php

namespace App\Core;

class Request
{
    public $body;

    public function __construct()
    {
        $this->body = file_get_contents(filename: 'php://input');
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getJSON(): array
    {
        $decoded = json_decode(json: $this->body, associative: true);
        $json = is_array(value: $decoded) ? $decoded : [];
        return $json;
    }
}
