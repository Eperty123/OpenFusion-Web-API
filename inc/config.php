<?php
// Include libs...
require_once "class/AuthToken.php";
require_once "class/Database.php";
require_once "class/User.php";

# ==================
# API configuration
# ==================

// The path to your installation.
// If it's in a subfolder like localhost/openfusion
// then the path is "/openfusion", otherwise "/".
$BASE_PATH = "/openfusion";

// The virtual path to the api.
// You'll have to access the api through the base path
// and then "/api", example: "localhost/openfusion/api/".
$API_PATH = "/api/";

// This is the encryption key used to encrypt passwords.
$ENCRYPTION_KEY = "openFusion is open source! Hooray bois";

# =======================
# Database configuration
# =======================

$DB_IP = "127.0.0.1";
$DB_PORT = 3306;
$DB_USER = "root";
$DB_PASSWORD = "";

# ============================
# Api to server configuration
# ============================

// 0 - Api.
// 1 - In-game client.
$LOGIN_TYPE = 0;

// The name for the login cookie.
$LOGIN_COOKIE_NAME = "FFLogin";

// The name for the remember me cookie.
$REMEMBER_ME_COOKIE_NAME = "FFRemember";

// Name of the server.
$SERVER_NAME = "Local Server";

// Link to the game files.
$CDN_LINK = "http://ht.cdn.turner.com/ff/big/beta-20100104/";

// Login server ip and port.
$LOGIN_IP = "127.0.0.1:8001";

// Change only the part where it says "main.unity3d".
$UNITY_FILE = $CDN_LINK . "main.unity3d";

# ====================
# Class configuration
# ====================

// Instantiate a new Database instance.
$DB = new Database();

// Load database from file and return its connection.
$DB_CONNECTION = $DB = $DB->loadDbFromFile("database.db");

// Instantiate a User class.
$USER = new User($DB_CONNECTION);

// Set its table name.
$USER->setTable("Accounts");

// Set its login cookie name.
$USER->cookie_name = $LOGIN_COOKIE_NAME;

// Set the user's encryption key.
$USER->setEncryptionKey($ENCRYPTION_KEY);


// Instantiate an AuthToken class. This is required to make
// the remember me to work.
$AUTH = new AuthToken($DB_CONNECTION);

// Set its table.
$AUTH->setTable("Auth_Tokens");

// Then its remember me cookie name.
$AUTH->cookie_name = $REMEMBER_ME_COOKIE_NAME;


# ============================
# DON'T TOUCH UNLESS YOU KNOW
# WHAT YOU ARE DOING!
# ============================

// Define base path.
define("BASE_PATH", $BASE_PATH);

// Define virtual api path.
define("API_PATH", $API_PATH);

define("GAME_FILES", $CDN_LINK);
define("UNITY_FILE", $UNITY_FILE);