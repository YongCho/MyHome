<?php
require_once 'dblogin.php';
require_once 'string_sanitation.php';

define ("LOGIN_SUCCESS", 0);
define ("CONNECT_FAIL", 11);
define ("SELECT_FAIL", 12);
define ("ACCESS_FAIL", 13);
define ("INVALID_USER", 14);
define ("SALT1", "4!&)");
define ("SALT2", "D*+1");

function adduser($username, $password)
{
    
    $query = "INSERT INTO users VALUES($username, $password)";
}

/* Log in a user and set the session info. */
function login($username, $password)
{   
    $db_link = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
    if (!$db_link)
        return CONNECT_FAIL;
    
    if(!mysql_select_db(DB_DATABASE, $db_link))
        return SELECT_FAIL;
    
    $temp_name = mysql_entities_prep_string($username);
    $temp_pass = mysql_entities_prep_string($password);
    
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysql_query($query, $db_link);
    if (!$result)
        return ACCESS_FAIL;
    else if (mysql_num_rows($result)){
        $row = mysql_fetch_row($result);
        $pw_token = md5(SALT1 . "$password" . SALT2);
        
        if ($pw_token == $row[1]){
            $_SESSION['authenticated'] = true;
            $_SESSION['user'] = $temp_name;
            $_SESSION['pass'] = $temp_pass;
            return LOGIN_SUCCESS;
        }
        else return INVALID_USER;
    }
    else return INVALID_USER;
}

function isLoggedIn($username, $password)
{

    return false;
}
function create_user($username, $password)
{

    return false;
}

function destroy_session_and_data()
{
    $_SESSION = array();
    if (session_id() != "" || isset($_COOKIE[session_name()])){
        setcookie(session_name(), '', time() - 2592000, '/');
    }
    session_destroy();
}
?>