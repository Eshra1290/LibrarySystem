<?php
// Start the session
session_start();

// Destroy the session to log the user out
session_unset();  // Removes all session variables
session_destroy(); // Destroys the session

// Redirect to Login page
header("Location: Login.php");
exit();
?>