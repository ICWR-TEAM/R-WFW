<?php

namespace App\Core;

use mysqli;
use mysqli_result;

class Database
{
    private $conn;

    public function __construct(string $db_host, string $db_user, string $db_pass, string $db_name)
    {
        $this->conn = mysqli_connect(hostname: $db_host, username: $db_user, password: $db_pass, database: $db_name);

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

    public function query(string $query, array $params = []): bool|mysqli_result
    {
        foreach ($params as $key => $value) {
            $safeValue = "'" . $this->filter(string: (string) $value) . "'";
            $query = str_replace(search: ':' . $key, replace: $safeValue, subject: $query);
        }

        $result = mysqli_query(mysql: $this->getConnection(), query: $query);

        if ($result === false) {
            die("MySQL Error: " . mysqli_error(mysql: $this->getConnection()));
        }

        return $result;
    }

    public function query_fetch_array(string $query, array $params = []): array|bool
    {
        $result = $this->query(query: $query, params: $params);
        $rows = [];

        if ($result instanceof mysqli_result) {
            while ($row = mysqli_fetch_array(result: $result, mode: MYSQLI_ASSOC)) {
                $rows[] = $row;
            }
        }

        return $rows;
    }

    public function fetch_array(mysqli_result $result): array|null
    {
        return mysqli_fetch_array(result: $result, mode: MYSQLI_ASSOC);
    }

    public function query_num_rows(string $query, array $params = []): int
    {
        $result = $this->query(query: $query, params: $params);
        return ($result instanceof mysqli_result) ? mysqli_num_rows(result: $result) : 0;
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
