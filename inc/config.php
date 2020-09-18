<?php
// Include libs...
require_once "class/AuthToken.php";
require_once "class/Database.php";
require_once "class/User.php";

# General configuration
$BASE_PATH = "/";
$API_PATH = "/api/";

// Define base path.
define("BASEPATH", $BASE_PATH);
// Define virtual api path.
define("APIPATH", $API_PATH);

# API configuration

# Database configuration
$DB_IP = "127.0.0.1";
$DB_PORT = 3306;
$DB_USER = "root";
$DB_PASSWORD = "";

# Cookie configuration

// 0 - Api
// 1 - In-game client
$LOGIN_TYPE = 1;
// The name for the login cookie.
$LOGIN_COOKIE_NAME = "FFLogin";
// The name for the remember me cookie.
$REMEMBER_ME_COOKIE_NAME = "FFRemember";

# Server configuration
// Name of the server.
$SERVER_NAME = "Local Server";
// Link to the game files.
$GAMEFILES_LINK = "http://ht.cdn.turner.com/ff/big/beta-20100104/";
// Login server ip and port.
$LOGIN_IP = "127.0.0.1:8001";
// Link to the game loader Unity file.
$UNITY_FILE = $GAMEFILES_LINK . "main.unity3d";

# Encryption configuration
$ENC_SALT = "openFusion is open source! Hooray bois";

# Class configuration
// Database
$DB = new Database();
// Load database from file and get its connection as variable.
$DB_CONNECTION = $DB = $DB->loadDbFromFile("database.db");

// User
// Instantiate a User class.
$USER = new User($DB_CONNECTION);
// Set its table name.
$USER->setTable("Accounts");
// Set its login cookie name.
$USER->cookie_name = $LOGIN_COOKIE_NAME;

// Authentication / remember me
// Instantiate an AuthToken class.
$AUTH = new AuthToken($DB_CONNECTION);
// Set its table.
$AUTH->setTable("Auth_Tokens");
// Then its remember me cookie name.
$AUTH->cookie_name = $REMEMBER_ME_COOKIE_NAME;

# Bcrypt encryption configuration
$BCRYPT_OPTIONS = [
    // The salt for encrypting strings (passwords). Needs to be atleast 20 characters long.
    'salt' => $ENC_SALT,
    'cost' => 11
];
