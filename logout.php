<?php
require_once 'user_account.php';

ini_set('session.gc_maxlifetime', 60 * 60);    // one hour
session_start();

$redirect = $_POST['returnto'];
echo "\$redirect = $redirect" . "<br />"; 

destroy_session_and_data();

echo "You are logged out";

$host = $_SERVER['HTTP_HOST'];
$path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
header("Location: http://$host$path$redirect");
?>