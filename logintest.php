<?php
require_once 'user_account.php';
require_once 'dblogin.php';

ini_set('session.gc_maxlifetime', 60 * 60);    // one hour
session_start();

$redirect = $_POST['returnto'];
echo "\$redirect = $redirect" . "<br />";   

// Proceed if username and password were submitted.
if (isset($_POST['user']) && isset($_POST['pass'])){
    echo "user = " . $_POST['user'] . "<br />";
    echo "pass = " . $_POST['pass'] . "<br />";

    // if username and password are valid, log user in
    if (($retval = login($_POST['user'], $_POST['pass'])) == LOGIN_SUCCESS)
    {
        // remember that user's logged in
        $_SESSION['authenticated'] = true;
        $_SESSION['user'] = $_POST['user'];
        echo "Authenticated = " . $_SESSION['authenticated'] . "<br />";
    }
    else {
        echo $retval . "<br />";
    }
}
else {
    echo "POST variables are not set. <br />";
}
?>