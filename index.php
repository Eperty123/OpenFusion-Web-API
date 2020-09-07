<?php
include_once "inc/helper.php";
// Start game if we are remembered or logged in.
// Otherwise log in.
if (canRememberMe() || isCookieSet($LOGIN_COOKIE_NAME)) gotoPage("game.php");
else gotoPage("login.php");
?>