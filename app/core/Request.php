<?php

namespace App\Core;

class Request
{
    private array $get;
    private array $post;
    private array $server;
    private array $headers;
    public $body;

    public function __construct()
    {
        $this->get = $_GET;
        $this->post = $_POST;
        $this->server = $_SERVER;
        $this->headers = getallheaders();
        $this->body = file_get_contents(filename: 'php://input');
    }

    public function getQuery(): array
    {
        return $this->get;
    }

    public function getPost(): array
    {
        return $this->post;
    }

    public function getHeader(string $name): ?string
    {
        return $this->headers[$name] ?? null;
    }

    public function getMethod(): string
    {
        return $this->server['REQUEST_METHOD'] ?? 'GET';
    }

    public function getUri(): string
    {
        return $this->server['REQUEST_URI'] ?? '/';
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
