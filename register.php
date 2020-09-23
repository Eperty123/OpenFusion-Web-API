<?php
// Require config file.
require_once "inc/config.php";
?>
<html>
<body>

<form action="<?php echo API_PATH . "register" ?>" method="post">
    <input type="hidden" name="action" value="register">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="checkbox" name="rememberme">
    Remember me?
    <input type="submit" value="Register">
</form>

</body>
</html>
