<?php
require_once 'user_account.php';

ini_set('session.gc_maxlifetime', 60 * 60);    // one hour
session_start();

$redirect = $_POST['returnto'];
echo "\$redirect = $redirect";   

// Proceed if username and password were submitted.
if (isset($_POST['user']) && isset($_POST['pass'])){

    // if username and password are valid, log user in
    if (login($_POST['user'], $_POST['pass']) == LOGIN_SUCCESS)
    {        
        // save username in cookie for a day
        setcookie("user", $_POST['user'], time() + 1 * 24 * 60 * 60);

        // save password in, ack, cookie for a week if requested
        if ($_POST['keep'])
            setcookie("pass", $_POST['pass'], time() + 1 * 24 * 60 * 60);

        // redirect user to index page, using absolute path, per
        // http://us2.php.net/manual/en/function.header.php
        $host = $_SERVER['HTTP_HOST'];
        $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
        header("Location: http://$host$path$redirect");

    }
}
else {
    // redirect user to index page, using absolute path, per
    // http://us2.php.net/manual/en/function.header.php
    $host = $_SERVER['HTTP_HOST'];
    $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    header("Location: http://$host$path$redirect");
}
?>
