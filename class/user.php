<?php

class User
{
    public $id;
    public $username;
    public $password;
    public $email;

    public $table;
    private $connection;

    // Login cookie name.
    public $cookie_name = "FFLogin";

    // Login cookie lifetime in hours.
    public $cookie_lifetime = 5;

    public function __construct($db_connection)
    {
        $this->connection = $db_connection;
    }

    public function getAllUserInfo()
    {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function setUserInfo($user, $password, $email)
    {
        $this->username = $user;
        $this->password = $password;
        $this->email = $email;
    }

    public function setTable($tableName)
    {
        $this->table = $tableName;
    }

    public function createUser()
    {
        if (!$this->userExists()) {
            $query = "INSERT INTO $this->table (Login, Password, Selected, Created, LastLogin) VALUES (?,?,?,?,?)";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(1, $this->username, PDO::PARAM_STR);
            $stmt->bindValue(2, $this->password, PDO::PARAM_STR);
            $stmt->bindValue(3, 0, PDO::PARAM_INT);
            $stmt->bindValue(4, time(), PDO::PARAM_INT);
            $stmt->bindValue(5, time(), PDO::PARAM_INT);
            $stmt->execute();

            return $stmt;
        }
    }

    public function getUser()
    {
        $query = "SELECT * FROM $this->table WHERE Login = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(1, $this->username, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser()
    {
        if ($this->userExists()) {
            $query = "UPDATE $this->table SET Login = ?, Password = ?, LastLogin = ? WHERE Login = ?";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(1, $this->username, PDO::PARAM_STR);
            $stmt->bindValue(2, $this->password, PDO::PARAM_STR);
            $stmt->bindValue(3, $this->username, PDO::PARAM_STR);
            $stmt->bindValue(4, time(), PDO::PARAM_INT);
            $stmt->execute();

            return $stmt;
        }
    }

    public function updateUserLoginSession() {
        if ($this->userExists()) {
            $query = "UPDATE $this->table SET LastLogin = ? WHERE Login = ?";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(1, time(), PDO::PARAM_INT);
            $stmt->bindValue(2, $this->username, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt;
        }
    }

    public function deleteUser()
    {
        if ($this->userExists()) {
            $query = "DELETE FROM $this->table WHERE Login = ?";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(1, $this->username, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt;
        }
    }

    public function userExists()
    {
        $query = "SELECT * FROM $this->table WHERE Login = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(1, $this->username, PDO::PARAM_STR);
        $stmt->execute();

        return isVariableSet($stmt->fetch(PDO::FETCH_ASSOC));
    }

    public function getUserTokenAsJson() {
        //$response = json_encode(array("action" => "login", "username" => $this->username, "password" => $this->password, "error"));
        $response = json_encode(array("action" => "login", "username" => $this->username, "error"));
        return $response;
    }

    public function setuserTokenSession()
    {
        $response = $this->getUserTokenAsJson();
        // Set the cookie for the client to login properly.
        setcookie($this->cookie_name, $response, time() + (60 * $this->cookie_lifetime), "/");
    }
}