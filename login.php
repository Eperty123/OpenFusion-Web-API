<?php
include_once "inc/helper.php";
// Start game if we are remembered or logged in.
// Otherwise log in.
if (canRememberMe() || isCookieSet($LOGIN_COOKIE_NAME)) gotoPage("game.php");
?>

<html>
<body>

<form action="action.php" method="post">
    <input type="hidden" name="action" value="login">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="checkbox" name="rememberme"> Remember me?<br>
    <a href="register.php">Register</a><br>
    <input type="submit" value="Login">
</form>

</body>
</html>
