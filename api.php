<?php
// Require the needed classes.
include_once "class/AuthToken.php";
include_once "class/Database.php";
include_once "class/User.php";
include_once "inc/config.php";
include_once "inc/helper.php";
include_once "class/Route.php";

// Use this namespace.
use Steampixel\Route;

// Define base path.
define("BASEPATH", $BASE_PATH);

// Index route.
Route::add("/", function () {
    global $LOGIN_COOKIE_NAME;
    global $REMEMBER_ME_COOKIE_NAME;
    if (isCookieSet($LOGIN_COOKIE_NAME) || isSessionSet($REMEMBER_ME_COOKIE_NAME))
        gotoPage(BASEPATH . "/game");
    else gotoPage(BASEPATH . "/login");
});

// Login route.
Route::add("/login", function () {

    // Globalize some important variables. Failure to do so will output errors like the 500 error.
    global $AUTH;
    global $USER;
    global $BCRYPT_OPTIONS;

    // Assign request post and response.
    $request = $_POST;
    $response = "";

    // Check if the url has the "action" parameter.
    if (isParameterSet($request, "action")) {

        // Assign header to be a type of json.
        header("Content-Type: application/json");

        // Get the action's action type.
        $action = getParameter($request, "action");

        // If login, find username & password.
        $username = isParameterSet($request, "username") ? getParameter($request, "username") : "";
        $password = isParameterSet($request, "password") ? getParameter($request, "password") : "";

        switch ($action) {
            case "login":

                // If login, find username & password.
                $username = isParameterSet($request, "username") ? getParameter($request, "username") : "";
                $password = isParameterSet($request, "password") ? getParameter($request, "password") : "";
                $rememberme = isParameterSet($request, "rememberme") ? getParameter($request, "rememberme") : "";
                $rememberme = $rememberme == "on" ? true : false;

                // If username and password fields aren't empty.
                if (!empty($username) && !empty($password)) {
                    // Username and password are not empty, continue...
                    $hashed_pass = password_hash($password, PASSWORD_BCRYPT, $BCRYPT_OPTIONS);
                    //echo $password . " hashed:" . $hashed_pass;

                    // Fetch the account from database.
                    $USER->setUserInfo($username, $hashed_pass, null);
                    $AUTH->username = $username;

                    // If user exists login.
                    if ($USER->userExists()) {

                        // Set the login session.
                        $USER->setuserTokenSession();

                        // If user should be remembered.
                        if ($rememberme) {

                            // Create or update auth token to skip login
                            // in future login attempts.
                            if ($AUTH->authTokenExists()) {
                                // Generate new token for this user.
                                $AUTH->updateauthToken();
                                // Set the auth token in a session.
                                $AUTH->setauthTokenSession();
                            } else {
                                $AUTH->createauthToken();
                                // Set the auth token in a session.
                                $AUTH->setauthTokenSession();
                            }
                        }

                        // Then at last add the login complete response!
                        $response = json_encode(array("message" => "You have been logged in."));
                    } // If not...
                    else $response = json_encode(array("error" => "No matching account was found."));

                } // If they are...
                else $response = json_encode(array("error" => "No username and password supplied."));
                break;
        }
    } else include "login.php";

    // Show the response.
    echo $response;
}, ['get', 'post']);

// Registration route.
Route::add("/register", function () {

    // Globalize some important variables. Failure to do so will output errors like the 500 error.
    global $USER;
    global $BCRYPT_OPTIONS;

    // Assign request post and response.
    $request = $_POST;
    $response = "";

    // Check if the url has the "action" parameter.
    if (isParameterSet($request, "action")) {

        // Assign header to be a type of json.
        header("Content-Type: application/json");

        // Get the action's action type.
        $action = getParameter($request, "action");

        // If login, find username & password.
        $username = isParameterSet($request, "username") ? getParameter($request, "username") : "";
        $password = isParameterSet($request, "password") ? getParameter($request, "password") : "";

        switch ($action) {
            case "register":

                // If register, find username & password.
                $username = isParameterSet($request, "username") ? getParameter($request, "username") : "";
                $password = isParameterSet($request, "password") ? getParameter($request, "password") : "";

                if (!empty($username) && !empty($password)) {
                    // Username and password are not empty, continue...
                    $hashed_pass = password_hash($password, PASSWORD_BCRYPT, $BCRYPT_OPTIONS);
                    //echo $password . " hashed:" . $hashed_pass;

                    // Fetch the account from database and assign it as the found.
                    $USER->setUserInfo($username, $hashed_pass, null);

                    // If user doesn't exists.
                    if (!$USER->userExists()) {

                        // Create the user.
                        $USER->createUser();

                        // Set the login session. Makes us be seen as logged in.
                        $USER->setuserTokenSession();

                        // Then add the login success response.
                        $response = json_encode(array("message" => "Account for: $username is now created."));

                    } // If it does, tell the user that the username is already taken.
                    else $response = json_encode(array("error" => "Account for: $username already exists. Try another username."));
                } // If the fields are empty, tell the user.
                else $response = json_encode(array("error" => "No username and password supplied."));
                break;
        }
    } else include "register.php";

    // Show the response.
    echo $response;
}, ['get', 'post']);

// Play game route.
Route::add("/game", function () {
    global $LOGIN_COOKIE_NAME;
    global $REMEMBER_ME_COOKIE_NAME;

    $response = "";
    if (!isCookieSet($LOGIN_COOKIE_NAME) || !isSessionSet($REMEMBER_ME_COOKIE_NAME))
        $response = json_encode(array("error" => "You are not logged in. Please do so."));
});

// Log out route.
Route::add("/logout", function () {
    global $LOGIN_COOKIE_NAME;
    $response = "";
    if (isCookieSet($LOGIN_COOKIE_NAME)) {
        destroySession($LOGIN_COOKIE_NAME);
        $response = json_encode(array("message" => "You have been logged out."));
    } else $response = json_encode(array("error" => "You are not logged in."));
    echo $response;
});

// Use the path as base path for urls. This must lead to the php file.
Route::run(BASEPATH);