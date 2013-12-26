<?php    // cheatsheet_create.php
require_once 'dblogin.php';
require_once 'string_sanitation.php';

ini_set('session.gc_maxlifetime', 60 * 60);    // one hour
session_start();

/* Checking for login status. */
echo "<section>Authenticated = ";
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
echo "<br /></section>";



/* If ADD form was submitted, execute the following. */
if (isset($_POST['category']) &&
    isset($_POST['title']) &&
    isset($_POST['body'])){

    /* Connect to the MySQL database server. */
    $db_link = mysql_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
    if (!$db_link){
        echo "Unable to connect to the database.<br />" . mysql_error();
        exit(1);
    }

    /* Select the database. */
    if (!mysql_select_db(DB_DATABASE, $db_link)){
        echo "Unable to select the database.<br />" . mysql_error();
        exit(1);
    }

    /* Sanitize the input strings. */
    $category = mysql_prep_string($_POST['category']);
    $title = mysql_prep_string($_POST['title']);
    $body = mysql_prep_string($_POST['body']);

    /* Form the query string for insertion. */
    if (isset($_POST['tags']) && $_POST['tags'] != ""){
        $tags = mysql_prep_string($_POST['tags']);
        $query = "INSERT INTO cheatsheet(category, title, created_by, body, date_created, time_created, tags) " .
                 "VALUES('$category', '$title', 'Yong', '$body', now(), now(), '$tags');";
    }
    else {
        $query = "INSERT INTO cheatsheet(category, title, created_by, body, date_created, time_created) " .
                 "VALUES('$category', '$title', 'Yong', '$body', now(), now());";
    }

    /* Query the database to insert the entry. */
    $result = mysql_query($query, $db_link);
    if (!$result) {
        echo "<span style=\"color:#FF0000\">INSERT failed: </span>" . mysql_error() . "<br /><br />";
    }
    else {
        echo "<span style=\"color:#00FF00\">INSERT succeeded.</span> <br /><br />";        
    }
    
    mysql_close($db_link);
}



/* The HTML section */
echo <<<_END
<!DOCTYPE HTML>
<html>
<head>
    <title>Cheat Sheet - Create an entry</title>
</head>

<body>
    <header>
        <h3>Cheat Sheet - Create an entry</h3>
    </header>

    <section>
    <table class="add_entry" style="width:100%; max-width: 800px" border="0" cellpadding="2" cellspacing="5">    
    <form action="cheatsheet_create.php" method="post">
        <tr><td style="width:80"><label for="category">Category</label></td>
            <td><select name="category">
                <option value="Cheat Sheet">Cheat Sheet</option>
                <option value="Class">Class</option>
                </select></td></tr>
        <tr><td><label for="title">Title</label></td>
            <td><input style="width:100%" type="text" name="title" /></td></tr>
        <tr><td><label for="tags">Tags</label></td>
            <td><input style="width:100%" type="text" name="tags" /></td></tr>
        <tr><td colspan="2">
                <label for="body">Body</label><br />
                <textarea style="width:100%" name="body" rows="25"></textarea></td></tr>
        <tr><td colspan="2">
                <input type="submit" value="ADD ENTRY" /></td></tr>
    </form>
    </table>
    </section>

</body>
</html>

_END;
?>