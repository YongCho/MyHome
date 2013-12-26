<?php
require_once 'user_account.php';

ini_set('session.gc_maxlifetime', 60 * 60);    // one hour
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta name="description" content="test page" />
	<title>Test Page</title>
</head>

<body>
    <div>
<?php
    if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true &&
        isset($_SESSION['user'])){
?>
        <ul>
            <li>
                <span>Welcome back, "<?= $_SESSION['user'] ?>"</span>
                <form action="logout.php" method="post">
                <input type="submit" value="Log Out" />
                <input type="hidden" value="/index.php" name="returnto" />
                </form>
            </li>
        </ul>
<?php
    }
    // if username and password were saved in cookie, check them
    else if (isset($_COOKIE['user']) && isset($_COOKIE['pass']))
    {
        // if username and password are valid, log user back in
        if (login($_COOKIE['user'], $_COOKIE['pass']) == LOGIN_SUCCESS)
        {
            // remember that user's logged in
            $_SESSION['authenticated'] = true;
            echo $_SESSION['authenticated'];

            // re-save username and, ack, password in cookies for another day
            setcookie("user", $_COOKIE['user'], time() + 1 * 24 * 60 * 60);
            setcookie("pass", $_COOKIE['pass'], time() + 1 * 24 * 60 * 60);
?>
            <ul>
                <li>
                    <span>Welcome back, "<?= $_COOKIE['user'] ?>"</span>
                    <form action="logout.php" method="post">
                    <input type="submit" value="Log Out" />
                    <input type="hidden" value="/index.php" name="returnto" />
                    </form>
                </li>
            </ul>
<?php
        }
        else {
?>
            <ul>
            <form action="login.php" method="post">
                <li id="login">
                Login<input type="text" value="" name="user" size="16" />
                PW   <input type="text" value="" name="pass" size="16" />
                     <input type="checkbox" name="keep" /><label for="keep">Stay logged in</label>
                     <input type="hidden" value="/index.php" name="returnto" />
                     <input type="submit" value="Log In" />
                </li>
            </form>
            </ul>
<?php
        }
    }
    else {
?>
        <ul>
        <form action="login.php" method="post">
            <li id="login">
            Login<input type="text" value="" name="user" size="16" />
            PW   <input type="text" value="" name="pass" size="16" />
                 <input type="checkbox" name="keep" /><label for="keep">Stay logged in</label>
                 <input type="hidden" value="/index.php" name="returnto" />
                 <input type="submit" value="Log In" />
            </li>
        </form>
        </ul>
<?php
    }
?>
    </div>
    <h3>Heading</h3>


    <div>
    <nav>
        <ul>
            <li><a href="classes.html">Classes</a></li>
            <li><a href="cheatsheet.php">Cheat Sheet</a></li>
            <li><a href="sqltest.php">MySQL Test</a></li>
            <li><a href="sqlsample.php">MySQL Sample from Textbook</a></li>
        </ul>
    </nav>
    </div>



	<footer>
		<p>&copy; 2013 Yong Cho</p>
	</footer>


</body>

</html>