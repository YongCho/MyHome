<!DOCTYPE html>

<?php
require_once 'dblogin.php';

ini_set('session.gc_maxlifetime', 60 * 60);    // one hour
session_start();

/* Checking for login status. */
echo "Authenticated = ";

if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true){
    echo "YES";
}
else {
    echo "NO";
}
echo "<br />";
?>

<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>Cheat Sheets</title>
</head>

<body>
	<header>
        <h3>Cheat Sheets</h3>
	</header>
	
    <!-- Link to Login and Logout-->
    <section>        
        <?php
         $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
         echo "<a href=\"login.php?url=".urlencode($url)."\">Login</a><br />";
         echo "<a href=\"logout.php?url=".urlencode($url)."\">Logout</a>";
         ?>
    </section>
    
    <!-- Article options-->
    <section>
        <a href="cheatsheet_create.php">Create an entry</a>    
    </section>
    
    <!-- Display articles -->
    <section>
        <br />
        <?php                
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
        /* Display the list of articles. */
        $query = "SELECT * FROM cheatsheet";
        $result = mysql_query($query, $db_link);
        if (!$result) {
            echo "Unable to query the list.<br />" . mysql_error();
        }
        $rows = mysql_num_rows($result);
        for ($j = 0; $j < $rows; $j++){
            $current_row = mysql_fetch_row($result);
            for ($k = 0; $k < sizeof($current_row); $k++){
                $current_row[$k] = htmlspecialchars($current_row[$k]);
                echo nl2br($current_row[$k]) . "<br />";
            }
            echo "<br />";
        }
        
        mysql_close($db_link);
        ?>
        
        
        
    </section>
	
	<footer>
		<p>&copy; 2013 Yong Cho</p>
	</footer>
    
</body>

</html>