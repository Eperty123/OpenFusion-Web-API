<?php
// Include libs...
include_once "class/database.php";
include_once "class/user.php";
include_once "class/authtoken.php";

# Database configuration
$DB_IP = "127.0.0.1";
$DB_PORT = 3306;
$DB_USER = "root";
$DB_PASSWORD = "";

# Cookie configuration
// The name for the login cookie.
$LOGIN_COOKIE_NAME = "FFLogin";
$REMEMBER_COOKIE_NAME = "FFRemember";

# Encryption configuration
$ENC_SALT = "openFusion is open source! Hooray bois";

# Unity configuration
$UNITY_FILE = "http://localhost/ff/main.unity3d";

# Class configuration
// Database
$DB = new Database();
$DB_CONNECTION = $DB = $DB->loadDbFromFile("database.db");

// User
$USER = new User($DB_CONNECTION);
$USER->setTable("Accounts");
$USER->cookie_name = $LOGIN_COOKIE_NAME;

// Authentication / remember me
$AUTH = new AuthToken($DB_CONNECTION);
$AUTH->setTable("Auth_Tokens");
$AUTH->cookie_name = $REMEMBER_COOKIE_NAME;

# Bcrypt encryption configuration
$bcrypt_options = [
    // The salt for encrypting strings (passwords). Needs to be atleast 20 characters long.
    'salt' => $ENC_SALT,
    'cost' => 11
];
?>