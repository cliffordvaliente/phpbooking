<?php
session_start();
// Unset all of the session variables, I dont have any
$_SESSION = array();

session_unset();

// Destroy the session.
session_destroy();

// Redirect to the login page after logout
header("Location: index.php?logout=1");
exit();
?>
