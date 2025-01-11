<?php

namespace App\Core;

use mysqli;
use mysqli_result;

class Database
{
    private $conn;

    public function __construct()
    {
        $this->conn = mysqli_connect(hostname: DB_HOST, username: DB_USER, password: DB_PASS, database: DB_NAME);

        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function getConnection(): mysqli
    {
        return $this->conn;
    }

    public function closeConnection(): void
    {
        mysqli_close(mysql: $this->conn);
    }

    public function query(string $query): bool|mysqli_result
    {
        $result = mysqli_query(mysql: $this->getConnection(), query: $query);

        if ($result === false) {
            die("MySQL Error: " . mysqli_error(mysql: $this->getConnection()));
        }

        return $result;
    }

    public function query_fetch_array(string $query): array|bool
    {
        $result = $this->query(query: $query);
        $rows = [];

        while ($row = mysqli_fetch_array(result: $result, mode: MYSQLI_ASSOC)) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function fetch_array(mysqli_result $result): array|null
    {
        return mysqli_fetch_array(result: $result, mode: MYSQLI_ASSOC);
    }

    public function query_num_rows(string $query): int
    {
        $result = $this->query(query: $query);
        return mysqli_num_rows(result: $result);
    }

    public function num_rows(mysqli_result $result): int
    {
        return mysqli_num_rows(result: $result);
    }

    public function filter(string $string): string
    {
        return mysqli_real_escape_string(mysql: $this->getConnection(), string: $string);
    }
}
