<?php
require_once 'dblogin.php';
require_once 'string_sanitation.php';
require_once 'user_account.php';

if (isset($_POST['username']) && isset($_POST['password'])){
    echo "Raw username = " . $_POST['username'] . "<br />";
    echo "Raw password = " . $_POST['password'] . "<br /><br />";
    echo "Validate username = ";
    if (isGoodUser($_POST['username']) == VALID) echo "PASS";
    else echo "FAIL";
    echo "<br />";
    
    echo "Validate password = ";
    if (($retval = isGoodPassword($_POST['password'])) == VALID) echo "PASS";
    else echo "FAIL: " . $retval;
    echo "<br /><br />";
    
    $username = mysql_entities_prep_string($_POST['username']);
    $password = mysql_entities_prep_string($_POST['password']);
    echo "Sanitized username = " . $username . "<br />";
    echo "Sanitized password = " . $password . "<br />";
    
    /* Encrypt the password. */    
    $pw_token = md5(SALT1 . "$password" . SALT2);
    echo "Salted = " . SALT1 . "$password" . SALT2 . "<br />";
    echo "Token = " . $pw_token . "<br />";
    
    /* Enter the new user into the database. */
    $db_link = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
    if (!$db_link)
        echo "<span style=\"color:#FF0000\">Unable to connect to the database server.</span><br />";
    if (!mysql_select_db(DB_DATABASE, $db_link))
        echo "<span style=\"color:#FF0000\">Unable to select the database.</span><br />";
    $query = "INSERT INTO users VALUES('$username', '$pw_token')";
    $result = mysql_query($query, $db_link);
    if (!$result)
        echo "<span style=\"color:#FF0000\">ERROR: Unable to create the user.</span><br />";
    else
        echo "<span style=\"color:#00FF00\">The user account is created.</span><br />";
        

}









echo <<<_END
<html>
<head>
</head>

<body>
<header>
    <h3>Create a new user</h3>
</header>
    <table class="add_user" style="width:100%; max-width: 200px" border="0" cellpadding="2" cellspacing="5">
        <form action="create_user.php" method="post">
        <tr><td style="width:80">Username</td>
            <td><input style="width:100%" type="text" name="username" /></td></tr>
        <tr><td>Password</td>
            <td><input style="width:100%" type="text" name="password" /></td></tr>
        <tr><td colspan="2"><input type="submit" value="ADD USER" /></td>
        </form>
    </table>
</body>
</html>
_END;


?>