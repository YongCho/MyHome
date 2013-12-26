<?php
define ("INPUT EMPTY", 11);
define ("INPUT_TOO_SHORT", 12);
define ("WEAK_PASSWORD", 13);
define ("INVALID_CHAR", 14);
define ("INVALID_LENGTH", 15);
define ("VALID", 0);

function isAlphaNumeric($str)
{
    if ($str == "")
        return INPUT_EMPTY;
    else if (preg_match("/[^a-zA-Z0-9]/", $str))
        return INVALID_CHAR;
    else
        return VALID;
}

function isGoodPassword($str)
{
    if ($str == "")
        return INPUT_EMPTY;
    else if (strlen($str) < 8)
        return INPUT_TOO_SHORT;
    else if (!preg_match("/[a-z]/", $str) ||
             !preg_match("/[A-Z]/", $str) ||
             !preg_match("/[0-9]/", $str))
        return WEAK_PASSWORD;
    else
        return VALID;
}

function isGoodUser($str)
{
    if (strlen($str) < 4 || strlen($str) > 16)
        return INVALID_LENGTH;
    return isAlphaNumeric($str);
}

function mysql_entities_prep_string($str)
{
    return htmlspecialchars(mysql_prep_string($str));
}

function mysql_prep_string($str)
{
    if (get_magic_quotes_gpc()){
        $str = stripslashes($str);
    }
    return mysql_real_escape_string($str);
}


?>