<?php    // sqlsample.php
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


/* This example is from "Learning PHP, MySQL, Javascript & CSS"
   written by Robin Nixon. */
   
require_once 'dblogin.php';
$db_link = mysql_connect($db_hostname, $db_username, $db_password);
if (!$db_link){
    echo "Unable to connect to MySQL: " . mysql_error();
    exit(1);
}

mysql_select_db('publications', $db_link) or die(mysql_error());

if (isset($_POST['delete']) && isset($_POST['isbn'])){
    $isbn = get_post('isbn');
    $query = "DELETE FROM classics WHERE isbn = '$isbn'";
    
    if (!mysql_query($query, $db_link)){
        echo "DELETE failed: $query<br />" .
        mysql_error() . "<br /><br />";
    }
}

if (isset($_POST['author']) &&
    isset($_POST['title']) &&
    isset($_POST['category']) &&
    isset($_POST['year']) &&
    isset($_POST['isbn'])) {
    $author = get_post('author');
    $title = get_post('title');
    $category = get_post('category');
    $year = get_post('year');
    $isbn = get_post('isbn');
    
    $query = "INSERT INTO classics VALUES" .
             "('$author', '$title', '$category', '$year', '$isbn')";
    if (!mysql_query($query, $db_link)){
        echo "INSERT failed: $query<br />" . mysql_error() . "<br /><br />";    
    }   
}

echo <<<_END
<form action = "sqlsample.php" method="post"><pre>
  Author <input type="text" name="author" />
   Title <input type="text" name="title" />
Category <input type="text" name="category" />
    Year <input type="text" name="year" />
    ISBN <input type="text" name="isbn" />
         <input type="submit" value="ADD RECORD" />
</pre></form>
_END;

$query = "SELECT * FROM classics";
$result = mysql_query($query);

if (!$result) die (mysql_error());

$rows = mysql_num_rows($result);

for ($j = 0; $j < $rows; $j++){
    $row = mysql_fetch_row($result);
    for ($k = 0; $k < sizeof($row); $k++){
        $row[$k] = htmlspecialchars($row[$k]);
    }
    echo <<<_END
<pre>
  Author $row[0]
   Title $row[1]
Category $row[2]
    Year $row[3]
    ISBN $row[4]
</pre>
<form action="sqlsample.php" method="post">
<input type="hidden" name="delete" value="yes" />
<input type="hidden" name="isbn" value="$row[4]" />
<input type="submit" value="DELETE RECORD" />    
</form>
_END;
}

mysql_close($db_link);

function get_post($var)
{
    return mysql_real_escape_string($_POST[$var]);
}

?>