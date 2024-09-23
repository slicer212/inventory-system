<?php
session_start();

// Destroy all sessions
session_destroy();

// Redirect to the login page (index.php)
header("Location: index.php");
exit();
?>