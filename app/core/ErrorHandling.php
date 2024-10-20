<?php

namespace App\Core;

class ErrorHandling
{
    public function __construct()
    {
        set_error_handler([$this, 'customError']);
        set_exception_handler([$this, 'customException']);
    }

    public function customError($errno, $errstr, $errfile, $errline)
    {
        $errorMessage = "<b>Error:</b> [$errno] $errstr <br> in <b>$errfile</b> on line <b>$errline</b>";
        error_log("Error: [$errno] $errstr in $errfile on line $errline\n", 3, '../tmp/errors.log');
        echo $this->formatError($errorMessage);
    }

    public function customException($exception)
    {
        $errorMessage = "<b>Uncaught exception:</b> " . $exception->getMessage() . "<br> in <b>" . $exception->getFile() . "</b> on line <b>" . $exception->getLine() . "</b>";
        error_log("Uncaught exception: " . $exception->getMessage() . " in " . $exception->getFile() . " on line " . $exception->getLine() . "\n", 3, '../tmp/errors.log');
        echo $this->formatError($errorMessage);
    }

    private function formatError($message)
    {
        return "<div style='color: red; border: 1px solid red; padding: 10px; margin: 10px 0;'>$message</div>";
    }
}
