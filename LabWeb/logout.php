<?php
    session_start();

    // Destroy session and log out
    session_unset();  // Remove all session variables
    session_destroy(); // Destroy the session

    // Redirect to the home page
    header("Location: process.php"); // Replace 'homepage.php' with the path to your home page
    exit();
?>
