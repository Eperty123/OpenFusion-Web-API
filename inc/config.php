<?php
// Include libs...
include_once "class/AuthToken.php";
include_once "class/Database.php";
include_once "class/User.php";

# Database configuration
$DB_IP = "127.0.0.1";
$DB_PORT = 3306;
$DB_USER = "root";
$DB_PASSWORD = "";

# Cookie configuration
// The name for the login cookie.
$LOGIN_COOKIE_NAME = "FFLogin";
$REMEMBER_ME_COOKIE_NAME = "FFRemember";

# Server configuration
$SERVER_NAME = "Local Server";
$GAMEFILES_LINK = "http://localhost/ff";
$LOGIN_IP = "127.0.0.1:8001";
$UNITY_FILE = $GAMEFILES_LINK . "main.unity3d";

# Encryption configuration
$ENC_SALT = "openFusion is open source! Hooray bois";

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
$AUTH->cookie_name = $REMEMBER_ME_COOKIE_NAME;

# Bcrypt encryption configuration
$BCRYPT_OPTIONS = [
    // The salt for encrypting strings (passwords). Needs to be atleast 20 characters long.
    'salt' => $ENC_SALT,
    'cost' => 11
];
