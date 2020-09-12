<?php
// Require config file.
require_once "inc/config.php";
?>
<html>
<body>

<form action="<?php echo $API_PATH . "login" ?>" method="post">
    <input type="hidden" name="action" value="login">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="checkbox" name="rememberme"> Remember me?<br>
    <a href="/register.php">Register</a><br>
    <input type="submit" value="Login">
</form>

</body>
</html>
