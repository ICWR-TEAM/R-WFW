<?php

namespace App\Core;

class Response
{
    private int $status = 200;
    private array $headers = [];

    public function withStatus(int $code): static
    {
        $this->status = $code;
        return $this;
    }

    public function withHeader(string $name, string $value): static
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function json(array $data): void
    {
        http_response_code(response_code: $this->status);
        foreach ($this->headers as $name => $value) {
            header(header: "$name: $value");
        }
        header(header: 'Content-Type: application/json');
        echo json_encode(value: $data);
    }

    public function raw(string $data): void
    {
        http_response_code(response_code: $this->status);
        foreach ($this->headers as $name => $value) {
            header(header: "$name: $value");
        }
        echo $data;
    }
}
