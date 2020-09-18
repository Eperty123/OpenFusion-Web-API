<?php

class AuthToken
{
    public $id;
    public $authenticator;
    public $expiration;
    public $selector;
    public $token;
    public $username;

    // Remember me cookie name.
    public $cookie_name = "FFRemember";
    // Remember me cookie lifetime in hours.
    public $cookie_lifetime = 4;

    public $table;
    private $connection;

    public function __construct($db_connection)
    {
        $this->connection = $db_connection;
    }

    public function setAuthToken($user, $selector, $token, $expiration)
    {
        $this->username = $user;
        $this->selector = $selector;
        $this->token = $token;
        $this->expiration = $expiration;
    }

    public function setTable($tableName)
    {
        $this->table = $tableName;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function createauthToken()
    {
        if (!$this->authTokenExists()) {
            // Generate new token for this session.
            $this->generateToken();

            // Continue on with the query.
            $query = "INSERT INTO $this->table (Selector, Token, UserId, Expires) VALUES(?,?,?,?)";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(1, $this->selector, PDO::PARAM_STR);
            $stmt->bindValue(2, $this->token, PDO::PARAM_STR);
            $stmt->bindValue(3, $this->username, PDO::PARAM_STR);
            $stmt->bindValue(4, $this->expiration, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt;
        }
    }

    private function generateToken()
    {
        // Generate selector & authenticator.
        $this->selector = base64_encode(random_bytes(9));
        $this->authenticator = random_bytes(33);
        $this->token = hash('sha256', $this->authenticator);
        $this->expiration = date('Y-m-d\TH:i:s', time() + (60 * $this->cookie_lifetime));
    }

    public function getauthToken()
    {
        $query = "SELECT * FROM $this->table WHERE UserId = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(1, $this->username, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateauthToken()
    {
        if ($this->authTokenExists()) {
            // Generate new token for this session.
            $this->generateToken();

            // Continue on with the query.
            $query = "UPDATE $this->table SET Selector = ?, Token = ?, Expires = ? WHERE UserId = ?";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(1, $this->selector, PDO::PARAM_STR);
            $stmt->bindValue(2, $this->token, PDO::PARAM_STR);
            $stmt->bindValue(3, $this->expiration, PDO::PARAM_STR);
            $stmt->bindValue(4, $this->username, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt;
        }
    }

    public function deleteauthToken()
    {
        if (!$this->authTokenExists()) {
            $query = "DELETE FROM $this->table WHERE UserId = ?";
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(1, $this->username, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt;
        }
    }

    public function authTokenExists()
    {
        $query = "SELECT * FROM $this->table WHERE UserId = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bindValue(1, $this->username, PDO::PARAM_STR);
        $stmt->execute();

        return isVariableSet($stmt->fetch(PDO::FETCH_ASSOC));
    }

    public function setauthTokenSession()
    {
        // Set our remember cookie.
        setcookie(
            $this->cookie_name,
            $this->selector . ":" . base64_encode($this->authenticator),
            time() + (60 * 10 * $this->cookie_lifetime),
            "/"
        );
    }
}