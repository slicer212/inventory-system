<?php

class Database {
    private mysqli $con;
    private string $servername = "localhost";
    private string $username = "root";
    private string $password = "";
    private string $database = "inventory_system";

    public function connect(): mysqli {
        $this->con = new mysqli($this->servername, $this->username, $this->password);

        if ($this->con->connect_error) {
            die("Connection failed: " . $this->con->connect_error);
        }

        if (!$this->con->select_db($this->database)) {
            die("Could not select database: " . $this->con->error);
        }

        return $this->con;
    }
    
}
?>