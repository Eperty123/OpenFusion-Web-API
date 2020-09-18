<?php

// Config file must be included!

function isGetSet($get)
{
    return isset($get);
}

function isParameterSet($request, $parameter)
{
    return isset($request[$parameter]);
}

function hasParameter($request, $parameter)
{
    $result = false;
    $result = !empty(getParameter($request, $parameter));
    return $result;
}

function getParameter($request, $parameter)
{
    return $request[$parameter];
}

function isCookieSet($name)
{
    return isset($_COOKIE[$name]);
}

function getCookie($name)
{
    return $_COOKIE[$name];
}

function isVariableSet($parameter)
{
    return !empty($parameter);
}

function isSessionSet($name)
{
    return isset($_SESSION[$name]);
}

function getSession($name)
{
    return $_SESSION[$name];
}

function destroyCookie($name)
{
    if (isCookieSet($name))
        setcookie($name, "", time(), "/");
}

function destroySession($name)
{
    if (isSessionSet($name))
        unset($_SESSION[$name]);
}

function canRememberMe()
{
    global $REMEMBER_ME_COOKIE_NAME;
    global $DB_CONNECTION;

    if (!isSessionSet("UserId") && isCookieSet($REMEMBER_ME_COOKIE_NAME)) {
        list($selector, $authenticator) = explode(':', getCookie($REMEMBER_ME_COOKIE_NAME));

        $row = $DB_CONNECTION->prepare("SELECT * FROM Auth_Tokens WHERE Selector = ?");
        $row->bindValue(1, $selector, PDO::PARAM_STR);
        $row->execute();

        $auth_token = $row->fetch(PDO::FETCH_ASSOC);
        if (hash_equals($auth_token['Token'], hash('sha256', base64_decode($authenticator)))) {
            $_SESSION['UserId'] = $auth_token['UserId'];
            return true;
        }
    }
}

function gotoPage($name)
{
    header("Location: " . $name);
}