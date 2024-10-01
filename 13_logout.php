<?php
// Start the sessios
session_start();

// Destroy the session
session_destroy();

// Redirect to the home page
header("Location: http://localhost/Project/01_home.php");
exit();
?>