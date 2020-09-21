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

    /**
     * Connect to the database.
     *
     * @return PDO|null Returns the connection.
     */
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

    /**
     * Set connection info.
     *
     * @param $host The host.
     * @param $db_name Database name.
     * @param $user Database user.
     * @param $password Database user password.
     * @param int $port Database port.
     */
    public function setConnectionInfo($host, $db_name, $user, $password, $port = 3306)
    {
        $this->host = $host;
        $this->db_name = $db_name;
        $this->db_user = $user;
        $this->db_password = $password;
        $this->db_port = $port;
    }

    /**
     * Load a database from file.
     *
     * @param $file Database file.
     * @return PDO|SQLite3.
     */
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

    /**
     * Import a sql file.
     *
     * @param $sql_file The sql file.
     */
    public function importSql($sql_file) {

        // If no database is loaded, don't do anything.
        if($this->connection == null) return;

        // Temporary variable, used to store current query
        $templine = '';

        // Read in entire file
        $lines = file($sql_file);

        // Loop through each line
        foreach ($lines as $line) {

            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;

            // Add this line to the current segment
            $templine .= $line;

            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {

                // Perform the query
                $this->connection->exec($templine);

                // Reset temp variable to empty
                $templine = '';
            }
        }
    }
}