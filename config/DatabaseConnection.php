<?php

class DatabaseConnection
{
    public function openConnection()
    {
        $db_host = "localhost";
        $db_username = "root";
        $db_password = "";
        $db_name = "hospital_appointment";
        $db_port = 4306;

       

        $connection = new mysqli(
            $db_host,
            $db_username,
            $db_password,
            $db_name,
            $db_port
        );

        if ($connection->connect_error) {
            die("Database connection failed: " . $connection->connect_error);
        }

        return $connection;
    }
}

?>
