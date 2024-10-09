<?php

namespace App\Core;

// R-CRUD ( Rusher CRUD ) - Fast & Instant CRUD
// Copyright ©2021 - Afrizal F.A - ICWR-TEAM

class r_crud
{

    public $connection;

    public function __construct($connection)
    {
        
        $this->connection = $connection;

    }

    public function data_create($table, $data): bool
    {

        $table = mysqli_real_escape_string(mysql: $this->connection, string: $table);
        $index = implode(separator: ", ", array: array_map(callback: function ($v, $k): mixed { unset($v); return $k; }, array: $data, arrays: array_keys($data)));
        $value = implode(separator: ", ", array: array_map(callback: function ($v, $k): string { unset($k); return "\"$v\""; }, array: $data, arrays: array_keys($data)));
        $query = "INSERT INTO $table ($index) VALUES ($value)";
        $execute = mysqli_query(mysql: $this->connection, query: $query);

        if ($execute) {

            return true;

        } else {

            return false;

        }

    }

    public function data_read_all($table): array|bool
    {

        $table = mysqli_real_escape_string(mysql: $this->connection, string: $table);
        $query = "SELECT * FROM $table";
        $execute = mysqli_query(mysql: $this->connection, query: $query);
        $data = [];
        $no = 1;

        if ($execute) {

            while ($raw_data = mysqli_fetch_array(result: $execute)) {

                $data[$no++] = $raw_data;
    
            }
    
            return $data;

        } else {
            
            return false;

        }

    }

    public function data_read_where($table, $where): array|bool|null
    {

        if (!empty($where)) {

            $table = mysqli_real_escape_string(mysql: $this->connection, string: $table);
            $structure_where = implode(separator: "AND ", array: array_map(callback: function ($v, $k): string { return "$k = \"$v\""; }, array: $where, arrays: array_keys($where)));
            $query = "SELECT * FROM $table WHERE $structure_where";
            $execute = mysqli_query(mysql: $this->connection, query: $query);

            if ($execute) {

                if (mysqli_num_rows(result: $execute) > 0) {

                    $data = mysqli_fetch_array(result: $execute);
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

    public function data_update($table, $data, $where): bool
    {

        $table = mysqli_real_escape_string(mysql: $this->connection, string: $table);
        $struct_data = implode(separator: ", ", array: array_map(callback: function ($v, $k): string { return "$k = \"$v\""; }, array: $data, arrays: array_keys($data)));
        $structure_where = implode(separator: "AND ", array: array_map(callback: function ($v, $k): string { return "$k = \"$v\""; }, array: $where, arrays: array_keys($where)));
        $query = "UPDATE $table SET $struct_data WHERE $structure_where";
        $execute = mysqli_query(mysql: $this->connection, query: $query);

        if ($execute) {

            return true;

        } else {

            return false;

        }

    }

    public function data_delete($table, $where): bool
    {

        $table = mysqli_real_escape_string(mysql: $this->connection, string: $table);
        $structure_where = implode(separator: "AND ", array: array_map(callback: function ($v, $k): string { return "$k = \"$v\""; }, array: $where, arrays: array_keys($where)));
        $query = "DELETE FROM $table WHERE $structure_where";
        $execute = mysqli_query(mysql: $this->connection, query: $query);

        if ($execute) {

            return true;

        } else {

            return false;

        }

    }

}
