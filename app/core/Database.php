<?php

namespace App\Core;

class Database
{
    public $conn;

    public function __construct()
    {

        $this->conn = mysqli_connect(hostname: DB_HOST, username: DB_USER, password: DB_PASS, database: DB_NAME);

        if (!$this->conn) {

            die("Connection failed: " . mysqli_connect_error());

        }

    }

    public function getConnection(): bool|mysqli
    {

        return $this->conn;

    }

    public function closeConnection(): void
    {

        mysqli_close(mysql: $this->conn);

    }

    public function query($query): bool|mysqli_result
    {

        $sql['result'] = mysqli_query(mysql: $this->getConnection(), query: $query);

        if ($sql['result']) {

            return $sql['result'];

        } else {

            die("MySQL Error: " . mysqli_error(mysql: $this->getConnection()));

        }

    }

    public function query_fetch_array($query): array|bool|mysqli_result
    {

        $sql['query'] = $this->query(query: $query);
        $sql['result'] = [];

        $no = 1;

        while($row = mysqli_fetch_array(result: $sql['query'] )) 
        {

            $sql['result'][$no++] = $row;
            
        }

        return $sql['result'];

    }

    public function fetch_array($query): array|bool|null
    {

        $sql['result'] = mysqli_fetch_array(result: $query);

        return $sql['result'];

    }

    public function query_num_rows($query): int|string
    {

        $sql['result'] = mysqli_num_rows(result: $this->query(query: $query));

        return $sql['result'];

    }

    public function num_rows($query): int|string
    {

        $sql['result'] = mysqli_num_rows(result: $query);

        return $sql['result'];

    }

    public function filter($string): string
    {

        $sql['result'] = mysqli_real_escape_string(mysql: $this->getConnection(), $string);

        return $sql['result'];

    }

}
