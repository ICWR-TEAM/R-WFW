<?php

namespace App\Middleware;

class Logger
{
    private string $logFile;
    private int $maxFileSize;
    private array $allowedLevels;

    public function __construct(string $logFile, int $maxFileSize = 1048576, array $allowedLevels = ['info', 'error', 'debug', 'warn'])
    {
        $this->logFile = $logFile;
        $this->maxFileSize = $maxFileSize;
        $this->allowedLevels = $allowedLevels;
    }

    public function write(string $message = '-', string $level = 'info', array $context = []): void
    {
        $level = strtolower(string: $level);
        if (!in_array(needle: $level, haystack: $this->allowedLevels, strict: true)) {
            return;
        }

        $this->rotateIfNeeded();

        $remoteAddr = $_SERVER['REMOTE_ADDR'] ?? '-';
        $remoteUser = $_SERVER['REMOTE_USER'] ?? '-';
        $timeLocal = date(format: 'd/M/Y:H:i:s O');
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? '-';
        $requestUri = $_SERVER['REQUEST_URI'] ?? '-';
        $serverProtocol = $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.1';
        $status = $context['status'] ?? 200;
        $bodyBytesSent = $context['bytes'] ?? 0;
        $referer = $_SERVER['HTTP_REFERER'] ?? '-';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '-';

        $entry = sprintf(
            '%s - %s [%s] "%s %s %s" %d %d "%s" "%s" "%s" %s' . PHP_EOL,
            $remoteAddr,
            $remoteUser,
            $timeLocal,
            $requestMethod,
            $requestUri,
            $serverProtocol,
            $status,
            $bodyBytesSent,
            $referer,
            $userAgent,
            strtoupper(string: $level),
            json_encode(value: $message, flags: JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        );

        try {
            file_put_contents(filename: $this->logFile, data: $entry, flags: FILE_APPEND | LOCK_EX);
        } catch (\Throwable $e) {
            error_log(message: 'Logger middleware error: ' . $e->getMessage());
        }
    }

    private function rotateIfNeeded(): void
    {
        if (!is_file(filename: $this->logFile)) {
            return;
        }

        clearstatcache(clear_realpath_cache: true, filename: $this->logFile);
        $size = filesize(filename: $this->logFile);

        if ($size !== false && $size >= $this->maxFileSize) {
            $timestamp = date(format: 'Ymd_His');
            $rotated = $this->logFile . '.' . $timestamp . '.log';
            rename(from: $this->logFile, to: $rotated);
        }
    }
}
