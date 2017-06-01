<?php
/**************************************************************
* LOGOUT PAGE
* by Kyle West
*
* Destroys session data and kicks the user out of the application
**************************************************************/

session_start();
session_destroy();
header("Location: login.php");
die();

?>
