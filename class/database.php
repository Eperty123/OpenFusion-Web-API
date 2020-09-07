<?php

class Database
{
    /**
     * https://www.youtube.com/watch?v=OEWXbpUMODk
     */

    public $host = "";
    public $db_name = "";
    public $db_user = "";
    public $db_password = "";
    public $db_port = 3306;
    private $connection;

    public function connect()
    {
        $this->connection = null;

        try {
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";port=" . $this->db_port, $this->db_user, $this->db_password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->connection;
    }

    public function setConnectionInfo($host, $db_name, $user, $password, $port = 3306)
    {
        $this->host = $host;
        $this->db_name = $db_name;
        $this->db_user = $user;
        $this->db_password = $password;
        $this->db_port = $port;
    }

    public function loadDbFromFile($file)
    {
        $this->connection = null;

        try {
            $this->connection = new PDO("sqlite:" . $file);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Load Db error: " . $e->getMessage();
        }
        return $this->connection;
    }
}