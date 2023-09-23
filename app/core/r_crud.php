<?php

// R-CRUD ( Rusher CRUD ) - Fast & Instant CRUD
// Copyright ©2021 - Afrizal F.A - ICWR-TEAM

class r_crud
{

    public $connection;

    public function __construct($connection)
    {
        
        $this->connection = $connection;

    }

    public function data_create($table, $data)
    {

        $table = mysqli_real_escape_string($this->connection, $table);
        $index = implode(", ", array_map(function ($v, $k) { unset($v); return $k; }, $data, array_keys($data)));
        $value = implode(", ", array_map(function ($v, $k) { unset($k); return "\"$v\""; }, $data, array_keys($data)));
        $query = "INSERT INTO $table ($index) VALUES ($value)";
        $execute = mysqli_query($this->connection, $query);

        if ($execute) {

            return true;

        } else {

            return false;

        }

    }

    public function data_read_all($table)
    {

        $table = mysqli_real_escape_string($this->connection, $table);
        $query = "SELECT * FROM $table";
        $execute = mysqli_query($this->connection, $query);
        $data = [];
        $no = 1;

        if ($execute) {

            while ($raw_data = mysqli_fetch_array($execute)) {

                $data[$no++] = $raw_data;
    
            }
    
            return $data;

        } else {
            
            return false;

        }

    }

    public function data_read_where($table, $where)
    {

        if (!empty($where)) {

            $table = mysqli_real_escape_string($this->connection, $table);
            $structure_where = implode("AND ", array_map(function ($v, $k) { return "$k = \"$v\""; }, $where, array_keys($where)));
            $query = "SELECT * FROM $table WHERE $structure_where";
            $execute = mysqli_query($this->connection, $query);

            if ($execute) {

                if (mysqli_num_rows($execute) > 0) {

                    $data = mysqli_fetch_array($execute);
                    return $data;
                        
                } else {
                    
                    return true;
    
                }

            } else {

                return false;

            }

        } else {

            return false;

        }

    }

    public function data_update($table, $data, $where)
    {

        $table = mysqli_real_escape_string($this->connection, $table);
        $struct_data = implode(", ", array_map(function ($v, $k) { return "$k = \"$v\""; }, $data, array_keys($data)));
        $structure_where = implode("AND ", array_map(function ($v, $k) { return "$k = \"$v\""; }, $where, array_keys($where)));
        $query = "UPDATE $table SET $struct_data WHERE $structure_where";
        $execute = mysqli_query($this->connection, $query);

        if ($execute) {

            return true;

        } else {

            return false;

        }

    }

    public function data_delete($table, $where)
    {

        $table = mysqli_real_escape_string($this->connection, $table);
        $structure_where = implode("AND ", array_map(function ($v, $k) { return "$k = \"$v\""; }, $where, array_keys($where)));
        $query = "DELETE FROM $table WHERE $structure_where";
        $execute = mysqli_query($this->connection, $query);

        if ($execute) {

            return true;

        } else {

            return false;

        }

    }

}
