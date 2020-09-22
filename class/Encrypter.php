<?php

class Encrypter {

    public $salt = "Justin Bieber";
    public $cost = 11;

    public function __construct()
    {
    }

    /**
     * Encrypt the string.
     * @param $str The string to encrypt.
     * @return bool|string
     */
    public function encryptString($str) {
        $BCRYPT_OPTIONS = [
            // The salt for encrypting strings (passwords). Needs to be atleast 22 characters long.
            'salt' => $this->fixSalt($this->salt, "+"),
            'cost' => $this->cost
        ];

        return password_hash($str, PASSWORD_BCRYPT, $BCRYPT_OPTIONS);
    }

    /**
     * Set encrypter info.
     * @param $salt The salt (encryption key) to use.
     * @param $cost The cost for BCRYPT.
     */
    public function setEncryptInfo($salt, $cost) {
        $this->salt = $salt;
        $this->cost = $cost;
    }

    /**
     * Fix salt length.
     * @param $salt The salt to fix.
     * @param $delimeter The delimeter to add.
     * @return bool|string Returns the fixed salt.
     */
    public function fixSalt($salt, $delimeter) {
        $temp_salt = $salt;
        $length = strlen($temp_salt);
        if($length < 22) {
            for($i = 0; $i < 22 - $length; $i++) {
                $temp_salt .= $delimeter;
            }
        }
        else $temp_salt = substr($temp_salt, 0, 22);
        return $temp_salt;
    }
}