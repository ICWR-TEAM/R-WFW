<?php

class TestDBModel
{

    public function testFunc()
    {

        $db = new Database();
        $sql = mysqli_query($db->getConnection(), "SELECT * FROM test");
        $output = $sql;

        return $output;
    }

}