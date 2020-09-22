<?php

class Encrypter {

    public $salt = "Justin Bieber";
    public $cost = 11;

    public function __construct()
    {
    }

    public function encryptString($str) {
        $BCRYPT_OPTIONS = [
            // The salt for encrypting strings (passwords). Needs to be atleast 22 characters long.
            'salt' => $this->fixSalt($this->salt, "+"),
            'cost' => $this->cost
        ];

        return password_hash($str, PASSWORD_BCRYPT, $BCRYPT_OPTIONS);
    }

    private function fixSalt($salt, $delimeter) {
        $temp_salt = $salt;
        $length = strlen($salt);
        if($length < 22) {
            for($i = $length; $i < 22; $i++) {
                $temp_salt += $delimeter;
            }
        }
        else $temp_salt = substr($temp_salt, 0, 22);
        return $temp_salt;
    }
}