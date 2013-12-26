<?php
/* Checking for login status. */
echo "Authenticated = ";
if (isset($_SESSION['authenticated'])){
    if ($_SESSION['authenticated'] == true){
        echo "YES";
    }
    else {
        echo "NO";
    }
}
else {
    echo "NO / Session is not started.";
}
echo "<br />";

/* Log in to MySQL server. */
require_once 'dblogin.php';
$db_link = mysql_connect($db_hostname, $db_username, $db_password);

if (!$db_link){
    echo "Connection to SQL server: FAIL (" . mysql_error() . ")";
}
else {
    echo "Connection to SQL server: SUCCESS <br />";
    echo "User = " . $db_username . "<br />";
    echo "Host = " . $db_hostname . "<br />";
    echo "<br />";
}

/* Select a database. */
$db_database = 'publications';
if (!mysql_select_db($db_database, $db_link)){
    echo "Unable to select database" . $db_database;
    exit(1);
}
echo "<br /><br />";

/* Try printing the contents of a table. */
$query = "SELECT * from classics";
$result = mysql_query($query);
if (!$result){
    echo "Unable to query...";
    exit(1);
}

$rows = mysql_num_rows($result);
for ($j = 0; $j < $rows; $j++){
    $row = mysql_fetch_row($result);
    for ($k = 0; $k < sizeof($row); $k++){
        echo $row[$k] . "<br />";
    }
}






?>