<?php

class Connection
{

    private $servername = "localhost";
    private $username = "ruslan";
    private $password = "20122012sw_SW";
    private $database = "ruslan";

    private $connection;

    public function getConnection(){
        return this->$connection;
    }


}


?>