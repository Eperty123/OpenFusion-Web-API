<?php

// Include encrypter.
include_once "Encrypter.php";

/**
 * The class that's primarily responsible for handling accounts.
 */
class User
{
    /**
     * @var The id of the user.
     */
    public $id;

    /**
     * @var The username of the user.
     */
    public $username;

    /**
     * @var The password of this user.
     */
    public $password;

    /**
     * @var The email of this user.
     */
    public $email;

    /**
     * @var The table for the accounts.
     */
    public $table;

    /**
     * @var The connection to the database.
     */
    private $connection;

    /**
     * @var string The login cookie name.
     */
    public $cookie_name = "FFLogin";

    /**
     * @var int The cookie life time for the login cookie.
     */
    public $cookie_lifetime = 5;

    /**
     * @var Encrypter The encrypter class.
     */
    private $Encrypter;


    /**
     * Create a new instance of User.
     * @param $db_connection The database connection.
     */
    public function __construct($db_connection)
    {
        $this->connection = $db_connection;
        $this->Encrypter = new Encrypter();
    }

    /**
     * Get all users.
     * @return mixed All users.
     */
    public function getAllUserInfo()
    {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    /**
     * Set userinfo.
     * @param $user Username.
     * @param $password Password.
     * @param $email Email.
     */
    public function setUserInfo($user, $password, $email)
    {
        $this->username = $user;
        $this->password = $password;
        $this->email = $email;
    }

    /**
     * Sets the table name for accounts.
     * @param $tableName Table name for the accounts.
     */
    public function setTable($tableName)
    {
        $this->table = $tableName;
    }

    /**
     * Create user.
     * @return mixed Result.
     */
    public function createUser()
    {
        if (!$this->userExists()) {
            $query = "INSERT INTO $this->table (Login, Password, Selected, Created, LastLogin) VALUES (?,?,?,?,?)";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(1, $this->username, PDO::PARAM_STR);
            $stmt->bindValue(2, $this->getHashedPassword(), PDO::PARAM_STR);
            $stmt->bindValue(3, 0, PDO::PARAM_INT);
            $stmt->bindValue(4, time(), PDO::PARAM_INT);
            $stmt->bindValue(5, time(), PDO::PARAM_INT);
            $stmt->execute();

            return $stmt;
        }
    }

    /**
     * Get the user.
     * @return mixed User|null.
     */
    public function getUser()
    {
        $query = "SELECT * FROM $this->table WHERE Login = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(1, $this->username, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Update user.
     * @return mixed User|null
     */
    public function updateUser()
    {
        if ($this->userExists()) {
            $query = "UPDATE $this->table SET Password = ? WHERE Login = ?";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(1, $this->getHashedPassword(), PDO::PARAM_STR);
            $stmt->bindValue(2, $this->username, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt;
        }
    }

    /**
     * Updte the user login session.
     * @return mixed
     */
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

    /**
     * Delete user.
     * @return mixed
     */
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

    /**
     * Check if the user exists.
     * @return bool Returns if the user exists.
     */
    public function userExists()
    {
        $query = "SELECT * FROM $this->table WHERE Login = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(1, $this->username, PDO::PARAM_STR);
        $stmt->execute();

        return isVariableSet($stmt->fetch(PDO::FETCH_ASSOC));
    }

    /**
     * Get the user token as json.
     * @return false|string Returns the user token in json format.
     */
    public function getUserTokenAsJson() {
        //$response = json_encode(array("action" => "login", "username" => $this->username, "password" => $this->password, "error"));
        $response = json_encode(array("action" => "login", "username" => $this->username, "error"));
        return $response;
    }

    /**
     * Set the user token.
     */
    public function setuserTokenSession()
    {
        $response = $this->getUserTokenAsJson();
        // Set the cookie for the client to login properly.
        setcookie($this->cookie_name, $response, time() + (60 * $this->cookie_lifetime), "/");
    }

    /**
     * Set the encryption key.
     * @param $key The encryption key to use for encrypting strings.
     */
    public function setEncryptionKey($key) {
        $this->Encrypter->setEncryptionKey($key);
    }

    /**
     * Get the hashed password.
     */
    public function getHashedPassword() {
        return $this->Encrypter->encryptString($this->password);
    }
}