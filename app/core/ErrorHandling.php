<?php

namespace App\Core;

class ErrorHandling
{
    public function __construct()
    {
        set_error_handler(callback: [$this, 'customError']);
        set_exception_handler(callback: [$this, 'customException']);
    }

    public function customError(string $errno, string $errstr, string $errfile, int $errline): void
    {
        $errorMessage = "<b>Error:</b> [$errno] $errstr <br> in <b>$errfile</b> on line <b>$errline</b>";
        error_log(message: "Error: [$errno] $errstr in $errfile on line $errline\n", message_type: 3, destination: '../tmp/' . date(format: "Y-m-d") . '_errors.log');
        echo $this->formatError(message: $errorMessage);
    }

    public function customException(\Throwable $exception): void
    {
        $errorMessage = "<b>Uncaught exception:</b> " . $exception->getMessage() . "<br> in <b>" . $exception->getFile() . "</b> on line <b>" . $exception->getLine() . "</b>";
        error_log(message: "Uncaught exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine() . "\n", message_type: 3, destination: '../tmp/' . date(format: "Y-m-d") . '_errors.log');
        echo $this->formatError(message: $errorMessage);
    }

    private function formatError(string $message): string
    {
        return "<div style='color: red; border: 1px solid red; padding: 10px; margin: 10px 0;'>$message</div>";
    }
}
