<?php
/**
 * https://community.apachefriends.org/viewtopic.php?p=139799
 * https://stackoverflow.com/questions/13962789/get-results-from-from-mysql-using-pdo
 * https://www.sitepoint.com/hashing-passwords-php-5-5-password-hashing-api/
 * https://www.php.net/manual/en/function.setcookie.php
 * https://www.w3schools.com/js/js_cookies.asp
 * https://stackoverflow.com/questions/3290424/set-a-cookie-to-never-expire
 * https://stackoverflow.com/questions/3128985/php-login-system-remember-me-persistent-cookie
 */

// Helper file
include_once "inc/helper.php";

// Get the POST request.
$request = $_POST;
// Empty the response data.
$response = "";

// Set header type.
//header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");


// Check if the url has the "action" parameter.
if (isParameterSet($request, "action")) {

    // Get the action's action type.
    $action = getParameter($request, "action");

    switch ($action) {
        case "login":
            // If login, find username & password.
            $username = isParameterSet($request, "username") ? getParameter($request, "username") : "";
            $password = isParameterSet($request, "password") ? getParameter($request, "password") : "";
            $rememberme = isParameterSet($request, "rememberme") ? getParameter($request, "rememberme") : "";
            $rememberme = $rememberme == "on" ? true : false;

            if ($username != "" && $password != "") {
                // Username and password are not empty, continue...
                $hashed_pass = password_hash($password, PASSWORD_BCRYPT, $bcrypt_options);
                //echo $password . " hashed:" . $hashed_pass;

                // Fetch the account from database.
                $USER->setUserInfo($username, $hashed_pass, null);
                $AUTH->username = $username;

                // If user exists.
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

                    gotoPage("index.php");
                } // If not...
                else $response = json_encode(array("error" => "No matching account was found."));

            } else $response = json_encode(array("error" => "No username and password supplied."));
            break;

        case "register":
            // If register, find username & password.
            $username = isParameterSet($request, "username") ? getParameter($request, "username") : "";
            $password = isParameterSet($request, "password") ? getParameter($request, "password") : "";

            if ($username != "" && $password != "") {
                // Username and password are not empty, continue...
                $hashed_pass = password_hash($password, PASSWORD_BCRYPT, $bcrypt_options);
                //echo $password . " hashed:" . $hashed_pass;

                // Fetch the account from database.
                $USER->setUserInfo($username, $hashed_pass, null);

                // If user doesn't exists.
                if (!$USER->userExists()) {
                    $USER->createUser();

                    // Set the login session.
                    $USER->setuserTokenSession();
                    $response = json_encode(array("Account for: $username is now created."));
                    gotoPage("index.php");
                } else $response = json_encode(array("Account for: $username already exists. Try another username."));
            } else $response = json_encode(array("error" => "No username and password supplied."));
            break;

        case "":
            // Else nothing. Wrong.
            $response = json_encode(array("error" => "Wrong action type."));
            break;
    }
} else {
    // Else nothing. Wrong.
    $response = json_encode(array("error" => "No action specified."));
}

echo $response;