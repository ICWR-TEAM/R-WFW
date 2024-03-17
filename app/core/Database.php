<?php

class Database
{

    private $conn;

    public function __construct()
    {

        $this->conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if (!$this->conn) {

            die("Connection failed: " . mysqli_connect_error());

        }

    }

    public function getConnection()
    {

        return $this->conn;

    }

    public function closeConnection()
    {

        mysqli_close($this->conn);

    }

}
