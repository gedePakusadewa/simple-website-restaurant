<?php
    session_start();


    session_destroy(); // Destroying All Sessions
    header("Location: /websiteResto/index.php"); // Redirecting To Home Page
    exit();
    
?>