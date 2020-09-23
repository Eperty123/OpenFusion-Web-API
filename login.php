<?php
// Require config file.
require_once "class/AuthToken.php";
require_once "class/Database.php";
require_once "class/Route.php";
require_once "class/Server.php";
require_once "class/User.php";
require_once "inc/config.php";
require_once "inc/helper.php";

// If any cookies found, go to the game.
if (isCookieSet($LOGIN_COOKIE_NAME) || isCookieSet($REMEMBER_ME_COOKIE_NAME)) {
    gotoPage("game.php");
}
?>
<html>
<body>

<form action="<?php echo API_PATH . "login" ?>" method="post">
    <input type="hidden" name="action" value="login">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="checkbox" name="rememberme"> Remember me?<br>
    <a href="/register.php">Register</a><br>
    <input type="submit" value="Login">
</form>

</body>
</html>
