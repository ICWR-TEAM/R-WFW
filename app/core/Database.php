<?php

namespace App\Core;

class Database
{
    public $conn;

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

    public function query($query)
    {

        $sql['result'] = mysqli_query($this->getConnection(), $query);

        if ($sql['result']) {

            return $sql['result'];

        } else {

            die("MySQL Error: " . mysqli_error($this->getConnection()));

        }

    }

    public function query_fetch_array($query)
    {

        $sql['query'] = $this->query($query);
        $sql['result'] = [];

        $no = 1;

        while($row = mysqli_fetch_array($sql['query'] )) 
        {

            $sql['result'][$no++] = $row;
            
        }

        return $sql['result'];

    }

    public function fetch_array($query)
    {

        $sql['result'] = mysqli_fetch_array($query);

        return $sql['result'];

    }

    public function query_num_rows($query)
    {

        $sql['result'] = mysqli_num_rows($this->query($query));

        return $sql['result'];

    }

    public function num_rows($query)
    {

        $sql['result'] = mysqli_num_rows($query);

        return $sql['result'];

    }

    public function filter($string)
    {

        $sql['result'] = mysqli_real_escape_string($this->getConnection(), $string);

        return $sql['result'];

    }

}
